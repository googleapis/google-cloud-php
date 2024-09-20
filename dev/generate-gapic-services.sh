#!/bin/bash

COMPONENT_NAME=""
if [ "$#" -eq 1 ]; then
    # Component name must match the directory where the component lives in google-cloud-php, e.g. "AlloyDb"
    COMPONENT_NAME=" -name $1 "
elif [ "$#" -ne 0 ]; then
    echo "usage: generate-gapic-services.sh [COMPONENT]"
    exit 1;
fi

### IMPORTANT ###
# The following variables must be changed for your environment:

# Path to your checked out copy of https://github.com/googleapis/google-cloud-php
GOOGLE_CLOUD_PHP=~/Documents/projects/google-cloud-php

# Path to the directory which contains the output of googleapis/googleapis
# This will be a checked-out copy of https://github.com/googleapis/googleapis-gen (private repo)
# For public protos. For private protos, you will need to run the bazel job in your
# workspace (something like third_party/googleapis/preview/...) and untar the files there.
GOOGLEAPIS_GEN=~/Documents/projects/googleapis-gen
#################

IMAGE="gcr.io/cloud-devrel-public-resources/owlbot-php@sha256:1ab73a7e74a718382e9f13cbd8e90db24fad736b5fbbd1ab7e5139f163f08118"
DIRS=$(find $GOOGLE_CLOUD_PHP -mindepth 1 -maxdepth 1 -type d $COMPONENT_NAME -printf '%f\n')
if [ -z "${DIRS}" ]; then
  echo "Component directory $GOOGLE_CLOUD_PHP/$1 is invalid"
  exit 1;
fi
echo "$DIRS" | grep '^[A-Z]' | sort | while read DIR
do
  echo "Running Owlbot in $DIR";

  docker run --rm --user $(id -u):$(id -g) \
      -v $GOOGLE_CLOUD_PHP:/repo -v $GOOGLEAPIS_GEN:/googleapis-gen -w /repo \
      --env HOME=/tmp \
      gcr.io/cloud-devrel-public-resources/owlbot-cli:latest copy-code \
      --source-repo=/googleapis-gen \
      --config-file=$DIR/.OwlBot.yaml


  docker run --rm --user $(id -u):$(id -g) \
      -v $GOOGLE_CLOUD_PHP:/repo \
      -v $GOOGLEAPIS_GEN/bazel-bin:/bazel-bin \
      gcr.io/cloud-devrel-public-resources/owlbot-cli:latest copy-bazel-bin \
      --config-file=$DIR/.OwlBot.yaml \
      --source-dir /bazel-bin --dest /repo
done

echo "Run owlbot post processing for all generated files"

# run the synthtool image
docker pull $IMAGE
docker run  --user $(id -u):$(id -g) --rm -v $(pwd):/repo -w /repo $IMAGE

# To run local synthtool instead
#python -B -m synthtool.languages.php