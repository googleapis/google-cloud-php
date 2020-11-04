#!/bin/sh -eux

docker pull -q gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators
docker run \
  -d \
  -p 8080:8080 \
  gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators gcloud beta emulators firestore start --host-port=0.0.0.0:8080
sleep 10
