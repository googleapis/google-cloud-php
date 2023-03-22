#!/bin/bash

COMPONENT_NAME=""
if [ "$#" -eq 1 ]; then
    COMPONENT_NAME=" -name $1 "
elif [ "$#" -ne 0 ]; then
    echo "usage: generate-gapic-services.sh [COMPONENT]"
    exit 1;
fi

GOOGLE_CLOUD_PHP=~/github/google-cloud-php
GOOGLEAPIS_GEN=~/github/googleapis-gen
IMAGE="gcr.io/cloud-devrel-public-resources/owlbot-php:latest"
find $GOOGLE_CLOUD_PHP -mindepth 1 -maxdepth 1 -type d -name '*Spanner*' -printf '%f\n' | grep '^[A-Z]' | sort | while read DIR
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

docker pull $IMAGE
docker run  --user $(id -u):$(id -g) --rm -v $(pwd):/repo -w /repo $IMAGE
