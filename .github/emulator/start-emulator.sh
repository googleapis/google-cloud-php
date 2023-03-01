#!/bin/sh -eux

# Emulator version maybe different for individual products
IMAGE="gcr.io/google.com/cloudsdktool/cloud-sdk:$2"
docker pull -q $IMAGE
CONTAINER=`docker run \
  -d \
  -p 8085:8085 \
  $IMAGE gcloud beta emulators $1 start --host-port=0.0.0.0:8085 --project=emulator-project`
sleep 10
docker logs $CONTAINER
