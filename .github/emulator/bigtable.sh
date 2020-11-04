#!/bin/sh -eux

docker pull -q gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators
docker run \
  -d \
  -p 8086:8086 \
  gcr.io/google.com/cloudsdktool/cloud-sdk:316.0.0-emulators gcloud beta emulators bigtable start --host-port=0.0.0.0:8086
sleep 10
