#!/bin/sh -eux

docker pull -q gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators
docker run \
  -d \
  -p 8081:8081 \
  gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators gcloud beta emulators datastore start --host-port=0.0.0.0:8081
sleep 10
