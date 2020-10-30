#!/bin/sh -eux

docker pull -q gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators
docker run \
  -d \
  -p 8085:8085 \
  gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators gcloud beta emulators pubsub start --host-port=0.0.0.0:8085
sleep 10
