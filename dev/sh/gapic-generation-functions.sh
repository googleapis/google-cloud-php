#!/bin/bash

function setup_environment() {
  # This function expects to be executed from the root of
  # google-cloud-php
  GOOGLE_CLOUD_PHP_ROOT_DIR=$(pwd)
  REGENERATION_WORKING_DIR="$GOOGLE_CLOUD_PHP_ROOT_DIR/gapic-generation-workspace"

  ARTMAN_OUTPUT_DIR="$REGENERATION_WORKING_DIR/artman-output"
  ARTMAN_IMAGE="googleapis/artman:latest"
  GOOGLEAPIS_DIR="$REGENERATION_WORKING_DIR/googleapis"

  if [ ! -d "$GOOGLEAPIS_DIR" ]; then
    git clone git@github.com:googleapis/googleapis.git $GOOGLEAPIS_DIR
  fi

  # Check that artman is available on the path
  command -v artman >/dev/null 2>&1 || {
    echo >&2 "artman is required but not installed.  Aborting."; exit 1;
  }
}

# Merge the contents of the `proto` directory into `src`
# and `metadata` directories
#
# We assume that the protos live under the `Google\Cloud\<API>`
# root namespace - otherwise we can't distribute them as part
# of google-cloud-php
function merge_proto_into_src() {
  GENERATED_ROOT_DIR="$1"       # Absolute path to root of generated package
  ROOT_NAMESPACE_AS_PATH="$2"   # e.g. 'Google/Cloud/Language'

  # Optional, defaults to "GPBMetadata/$ROOT_NAMESPACE_AS_PATH"
  ROOT_METADATA_NAMESPACE_AS_PATH="$3" # e.g. 'Google/Cloud/Language'
  if [ -z "$3" ]; then
    ROOT_METADATA_NAMESPACE_AS_PATH="GPBMetadata/$ROOT_NAMESPACE_AS_PATH"
  fi

  echo "merge_proto_into_src $1 $2 $3"

  CLOUD_SRC_DIR=$GENERATED_ROOT_DIR/src
  CLOUD_METADATA_DIR=$GENERATED_ROOT_DIR/metadata

  mkdir -p $CLOUD_SRC_DIR
  mkdir -p $CLOUD_METADATA_DIR

  PROTO_DIR_TO_COPY=$GENERATED_ROOT_DIR/proto/src/$ROOT_NAMESPACE_AS_PATH
  PROTO_METADATA_DIR_TO_COPY=$GENERATED_ROOT_DIR/proto/src/$ROOT_METADATA_NAMESPACE_AS_PATH

  echo "cp -r $PROTO_DIR_TO_COPY/* $CLOUD_SRC_DIR/"
  cp -r $PROTO_DIR_TO_COPY/* $CLOUD_SRC_DIR/
  echo "cp -r $PROTO_METADATA_DIR_TO_COPY/* $CLOUD_METADATA_DIR/"
  cp -r $PROTO_METADATA_DIR_TO_COPY/* $CLOUD_METADATA_DIR/
}

function copy_artman_output_to_google_cloud_php() {
  GENERATED_ROOT_DIR="$1"         # Absolute path to root of generated package
  GOOGLE_CLOUD_PHP_API_DIR="$2"   # Absolute path to API dir in google-cloud-php

  mkdir -p $GOOGLE_CLOUD_PHP_API_DIR/src
  mkdir -p $GOOGLE_CLOUD_PHP_API_DIR/metadata

  cp -r $GENERATED_ROOT_DIR/src/* $GOOGLE_CLOUD_PHP_API_DIR/src/
  cp -r $GENERATED_ROOT_DIR/metadata/* $GOOGLE_CLOUD_PHP_API_DIR/metadata/
}

function copy_artman_test_output_to_google_cloud_php() {
  GENERATED_ROOT_DIR="$1"         # Absolute path to root of generated package
  GOOGLE_CLOUD_PHP_API_DIR="$2"   # Absolute path to API dir in google-cloud-php

  mkdir -p $GOOGLE_CLOUD_PHP_API_DIR/tests

  cp -r $GENERATED_ROOT_DIR/tests/* $GOOGLE_CLOUD_PHP_API_DIR/tests/
}

# For some APIs such as Admin APIs, the generated structure is incorrect
# and we need to update it.
#
# For example, setting $DIRECTORY_STRUCTURE_TO_INSERT="Admin" will transform
# `src/V1/*` into `src/Admin/V1/*`
function restructure_generated_package() {
  GENERATED_ROOT_DIR="$1"            # Absolute path to root of generated package
  DIRECTORY_STRUCTURE_TO_INSERT="$2" # Structure to insert.

  GENERATED_SRC_DIR="$GENERATED_ROOT_DIR/src"
  TEMP_GENERATED_SRC_DIR="$GENERATED_ROOT_DIR/srcTempDir"
  RESTRUCTURED_SRC_DIR="$GENERATED_ROOT_DIR/src/$DIRECTORY_STRUCTURE_TO_INSERT"

  GENERATED_TEST_DIR="$GENERATED_ROOT_DIR/tests"
  TEMP_GENERATED_TEST_DIR="$GENERATED_ROOT_DIR/testsTempDir"
  RESTRUCTURED_TEST_DIR="$GENERATED_ROOT_DIR/tests/$DIRECTORY_STRUCTURE_TO_INSERT"

  # Move existing `src` folder, then grab its contents after
  # creating the new directory
  mv $GENERATED_SRC_DIR $TEMP_GENERATED_SRC_DIR
  mkdir -p $RESTRUCTURED_SRC_DIR
  mv $TEMP_GENERATED_SRC_DIR/* $RESTRUCTURED_SRC_DIR/
  rm -r $TEMP_GENERATED_SRC_DIR

  # Move existing `tests` folder, then grab its contents after
  # creating the new directory
  mv $GENERATED_TEST_DIR $TEMP_GENERATED_TEST_DIR
  mkdir -p $RESTRUCTURED_TEST_DIR

  mv $TEMP_GENERATED_TEST_DIR/* $RESTRUCTURED_TEST_DIR/
  rm -r $TEMP_GENERATED_TEST_DIR
}

function run_artman() {
  ARTMAN_YAML="$1"

  ARTMAN_ARGS="--image $ARTMAN_IMAGE --root-dir $GOOGLEAPIS_DIR --output-dir $ARTMAN_OUTPUT_DIR --config $ARTMAN_YAML generate php_gapic"
  artman $ARTMAN_ARGS
}

function regenerate_api() {
  API_ARTMAN_YAML="$1"
  API_ARTMAN_OUTPUT_DIR="$2"
  API_GCP_FOLDER_NAME="$3"
  API_NAMESPACE_DIR="$4"           # Optional
  API_METADATA_NAMESPACE_DIR="$5"  # Optional

  if [ -z "$API_NAMESPACE_DIR" ]; then
    API_NAMESPACE_DIR="Google/Cloud/$API_GCP_FOLDER_NAME"
  fi
  if [ -z "$API_METADATA_NAMESPACE_DIR" ]; then
    API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/$API_GCP_FOLDER_NAME"
  fi

  ABSOLUTE_API_ARTMAN_OUTPUT_DIR="$ARTMAN_OUTPUT_DIR/php/$API_ARTMAN_OUTPUT_DIR"
  GOOGLE_CLOUD_PHP_API_DIR="$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"

  run_artman "$GOOGLEAPIS_DIR/$API_ARTMAN_YAML"
  merge_proto_into_src $ABSOLUTE_API_ARTMAN_OUTPUT_DIR $API_NAMESPACE_DIR $API_METADATA_NAMESPACE_DIR
  copy_artman_output_to_google_cloud_php $ABSOLUTE_API_ARTMAN_OUTPUT_DIR $GOOGLE_CLOUD_PHP_API_DIR
  copy_artman_test_output_to_google_cloud_php $ABSOLUTE_API_ARTMAN_OUTPUT_DIR $GOOGLE_CLOUD_PHP_API_DIR
}

function post_regenerate() {

  # Revert changes in clients with partial veneers
  git checkout Iot/src/V1/DeviceManagerClient.php
  git checkout Redis/src/V1beta1/CloudRedisClient.php
  git checkout Spanner/src/V1/SpannerClient.php
  git checkout Speech/src/V1/SpeechClient.php
  git checkout Speech/src/V1beta1/SpeechClient.php
  git checkout Vision/src/V1/ImageAnnotatorClient.php

  # Revert changes in copyright files for generated clients
  FOLDERS_2016=(
    "Logging"
    "PubSub"
  )
  FOLDERS_2017=(
    "BigQueryDataTransfer"
    "Bigtable"
    "Container"
    "Dataproc"
    "ErrorReporting"
    "Firestore"
    "Language"
    "Monitoring"
    "OsLogin"
    "Spanner"
    "Speech"
    "Trace"
    "VideoIntelligence"
    "Vision"
  )
  FOLDERS_2018=(
    "Dlp"
    "Iot"
    "Monitoring/src/V3/Alert*"
    "Monitoring/src/V3/Gapic/Alert*"
    "Monitoring/src/V3/Notification*"
    "Monitoring/src/V3/Gapic/Notification*"
    "Speech/src/V1p1beta1/*"
  )

  function update_copyright {
    arr=( "$@" )
    for i in "${arr[@]:1}"
    do
      find $i -wholename */V[0-9]*/*Client.php -exec sed -i "s/Copyright 20[0-9]\{2\} Google LLC/Copyright $1 Google LLC/" {} \;
    done
  }

  update_copyright 2016 "${FOLDERS_2016[@]}"
  update_copyright 2017 "${FOLDERS_2017[@]}"
  update_copyright 2018 "${FOLDERS_2018[@]}"
}

function regenerate_bigtable_v2() {

  API_ARTMAN_YAML="google/bigtable/artman_bigtable.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-bigtable-v2"
  API_GCP_FOLDER_NAME="Bigtable"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Bigtable"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"

  ABSOLUTE_ADMIN_API_ARTMAN_OUTPUT_DIR="$ARTMAN_OUTPUT_DIR/php/google-cloud-bigtable-admin-v2"
  GOOGLE_CLOUD_PHP_API_DIR="$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"

  run_artman "$GOOGLEAPIS_DIR/google/bigtable/admin/artman_bigtableadmin.yaml"
  restructure_generated_package $ABSOLUTE_ADMIN_API_ARTMAN_OUTPUT_DIR "Admin"
  merge_proto_into_src $ABSOLUTE_ADMIN_API_ARTMAN_OUTPUT_DIR "Google/Cloud/Bigtable" "GPBMetadata/Google/Bigtable"
  copy_artman_output_to_google_cloud_php $ABSOLUTE_ADMIN_API_ARTMAN_OUTPUT_DIR "$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"
}

function regenerate_bqdt_v1() {
  API_ARTMAN_YAML="google/cloud/bigquery/datatransfer/artman_bigquerydatatransfer.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-bigquerydatatransfer-v1"
  API_GCP_FOLDER_NAME="BigQueryDataTransfer"
  API_NAMESPACE_DIR="Google/Cloud/BigQuery/DataTransfer"
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/Bigquery/Datatransfer"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_container_v1() {
  API_ARTMAN_YAML="google/container/artman_container.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-container-v1"
  API_GCP_FOLDER_NAME="Container"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Container"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_dataproc_v1() {
  API_ARTMAN_YAML="google/cloud/dataproc/artman_dataproc_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-dataproc-v1"
  API_GCP_FOLDER_NAME="Dataproc"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_debugger_v2() {
  API_ARTMAN_YAML="google/devtools/artman_clouddebugger.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-debugger-v2"
  API_GCP_FOLDER_NAME="Debugger"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Devtools/Clouddebugger"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_dialogflow_v2() {
  API_ARTMAN_YAML="google/cloud/dialogflow/artman_dialogflow_v2.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-dialogflow-v2"
  API_GCP_FOLDER_NAME="Dialogflow"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_dlp_v2() {
  API_ARTMAN_YAML="google/privacy/dlp/artman_dlp_v2.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-dlp-v2"
  API_GCP_FOLDER_NAME="Dlp"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Privacy/Dlp"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"

  # Post-process to insert missing documentation.
  COMMENTS_TO_INSERT='\     \*          The configuration details for an inspect job. Only one of $inspectJob and $riskJob\n     \*          may be provided.'
  sed -i "/@type InspectJobConfig \$inspectJob/a $COMMENTS_TO_INSERT" Dlp/src/V2/Gapic/DlpServiceGapicClient.php

  COMMENTS_TO_INSERT='\     \*          The configuration details for a risk analysis job. Only one of $inspectJob and $riskJob\n     \*          may be provided.'
  sed -i "/@type RiskAnalysisJobConfig \$riskJob/a $COMMENTS_TO_INSERT" Dlp/src/V2/Gapic/DlpServiceGapicClient.php
}

function regenerate_errorreporting_v1beta1() {
  API_ARTMAN_YAML="google/devtools/clouderrorreporting/artman_errorreporting.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-error-reporting-v1beta1"
  API_GCP_FOLDER_NAME="ErrorReporting"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Devtools/Clouderrorreporting"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_firestore_v1beta1() {
  API_ARTMAN_YAML="google/firestore/artman_firestore.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-firestore-v1beta1"
  API_GCP_FOLDER_NAME="Firestore"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Firestore"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_iot_v1() {
  API_ARTMAN_YAML="google/cloud/iot/artman_cloudiot.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-iot-v1"
  API_GCP_FOLDER_NAME="Iot"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_language_v1() {
  API_ARTMAN_YAML="google/cloud/language/artman_language_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-language-v1"
  API_GCP_FOLDER_NAME="Language"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_language_v1beta2() {
  API_ARTMAN_YAML="google/cloud/language/artman_language_v1beta2.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-language-v1beta2"
  API_GCP_FOLDER_NAME="Language"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_logging_v2() {
  API_ARTMAN_YAML="google/logging/artman_logging.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-logging-v2"
  API_GCP_FOLDER_NAME="Logging"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Logging"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_monitoring_v3() {
  API_ARTMAN_YAML="google/monitoring/artman_monitoring.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-monitoring-v3"
  API_GCP_FOLDER_NAME="Monitoring"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Monitoring"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_oslogin_v1beta() {
  API_ARTMAN_YAML="google/cloud/oslogin/artman_oslogin_v1beta.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-os-login-v1beta"
  API_GCP_FOLDER_NAME="OsLogin"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/Oslogin"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_pubsub_v1() {
  API_ARTMAN_YAML="google/pubsub/artman_pubsub.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-pubsub-v1"
  API_GCP_FOLDER_NAME="PubSub"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Pubsub"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_redis_v1beta1() {
  API_ARTMAN_YAML="google/cloud/redis/artman_redis_v1beta1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-redis-v1beta1"
  API_GCP_FOLDER_NAME="Redis"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"

  # Post-processing to remove the metadataReturnType setting from descriptor config.
  # This is required because the returned metadata type is not available.
  sed -i "/[[:blank:]]*'metadataReturnType' => '\\\\Google\\\\Protobuf\\\\Any',/d" $GOOGLE_CLOUD_PHP_ROOT_DIR/Redis/src/V1beta1/resources/cloud_redis_descriptor_config.php
}

function regenerate_spanner_v1() {

  API_ARTMAN_YAML="google/spanner/artman_spanner.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-spanner-v1"
  API_GCP_FOLDER_NAME="Spanner"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Spanner"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"

  GOOGLE_CLOUD_PHP_API_DIR="$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"

  ABSOLUTE_DATABASE_API_ARTMAN_OUTPUT_DIR="$ARTMAN_OUTPUT_DIR/php/google-cloud-spanner-admin-database-v1"
  run_artman "$GOOGLEAPIS_DIR/google/spanner/admin/database/artman_spanner_admin_database.yaml"
  restructure_generated_package $ABSOLUTE_DATABASE_API_ARTMAN_OUTPUT_DIR "Admin/Database"
  merge_proto_into_src $ABSOLUTE_DATABASE_API_ARTMAN_OUTPUT_DIR "Google/Cloud/Spanner" "GPBMetadata/Google/Spanner"
  copy_artman_output_to_google_cloud_php $ABSOLUTE_DATABASE_API_ARTMAN_OUTPUT_DIR "$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"

  ABSOLUTE_INSTANCE_API_ARTMAN_OUTPUT_DIR="$ARTMAN_OUTPUT_DIR/php/google-cloud-spanner-admin-instance-v1"
  run_artman "$GOOGLEAPIS_DIR/google/spanner/admin/instance/artman_spanner_admin_instance.yaml"
  restructure_generated_package $ABSOLUTE_INSTANCE_API_ARTMAN_OUTPUT_DIR "Admin/Instance"
  merge_proto_into_src $ABSOLUTE_INSTANCE_API_ARTMAN_OUTPUT_DIR "Google/Cloud/Spanner" "GPBMetadata/Google/Spanner"
  copy_artman_output_to_google_cloud_php $ABSOLUTE_INSTANCE_API_ARTMAN_OUTPUT_DIR "$GOOGLE_CLOUD_PHP_ROOT_DIR/$API_GCP_FOLDER_NAME"
}

function regenerate_speech_v1() {
  API_ARTMAN_YAML="google/cloud/speech/artman_speech_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-speech-v1"
  API_GCP_FOLDER_NAME="Speech"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_speech_v1beta1() {
  API_ARTMAN_YAML="google/cloud/speech/artman_speech_v1beta1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-speech-v1beta1"
  API_GCP_FOLDER_NAME="Speech"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_speech_v1p1beta1() {
  API_ARTMAN_YAML="google/cloud/speech/artman_speech_v1p1beta1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-speech-v1p1beta1"
  API_GCP_FOLDER_NAME="Speech"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_tasks_v2beta2() {
  API_ARTMAN_YAML="google/cloud/tasks/artman_cloudtasks.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-cloudtasks-v2beta2"
  API_GCP_FOLDER_NAME="Tasks"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_trace_v2() {
  API_ARTMAN_YAML="google/devtools/cloudtrace/artman_cloudtrace_v2.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-trace-v2"
  API_GCP_FOLDER_NAME="Trace"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Devtools/Cloudtrace"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_tts_v1() {
  API_ARTMAN_YAML="google/cloud/texttospeech/artman_texttospeech_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-texttospeech-v1"
  API_GCP_FOLDER_NAME="TextToSpeech"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/Texttospeech"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_video_v1() {
  API_ARTMAN_YAML="google/cloud/videointelligence/artman_videointelligence_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-video-intelligence-v1"
  API_GCP_FOLDER_NAME="VideoIntelligence"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/Videointelligence"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_video_v1beta2() {
  API_ARTMAN_YAML="google/cloud/videointelligence/artman_videointelligence_v1beta2.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-video-intelligence-v1beta2"
  API_GCP_FOLDER_NAME="VideoIntelligence"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR="GPBMetadata/Google/Cloud/Videointelligence"

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

function regenerate_vision_v1() {
  API_ARTMAN_YAML="google/cloud/vision/artman_vision_v1.yaml"
  API_ARTMAN_OUTPUT_DIR="google-cloud-vision-v1"
  API_GCP_FOLDER_NAME="Vision"
  API_NAMESPACE_DIR=""
  API_METADATA_NAMESPACE_DIR=""

  regenerate_api "$API_ARTMAN_YAML" "$API_ARTMAN_OUTPUT_DIR" "$API_GCP_FOLDER_NAME" "$API_NAMESPACE_DIR" "$API_METADATA_NAMESPACE_DIR"
}

if [ ! -d "./gapic-generation-workspace/env" ]; then
  ERROR_MESSAGE=$(cat <<'EOM'
Could not find expected python virtualenv folder 'gapic-generation-workspace/env'.
To create this required virtualenv folder, you need to have python and virtualenv
installed on your machine, and run the following commands:
$ mkdir -p gapic-generation-workspace
$ cd gapic-generation-workspace
$ virtualenv env
$ source env/bin/activate
$ pip install googleapis-artman
$ deactivate
$ cd -
EOM
)
  echo >&2 "$ERROR_MESSAGE"; exit 1;
fi

source ./gapic-generation-workspace/env/bin/activate

set -ev
