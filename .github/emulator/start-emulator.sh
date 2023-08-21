#!/bin/sh -eux

# default to "emulators", which is the latest available version
EMULATOR_VERSION=emulators
if [ "$#" -eq 2 ]; then
    # use the supplied emulator version (e.g. "384.0.1-emulators")
    EMULATOR_VERSION=$2
elif [ "$#" -ne 1 ]; then
    echo "usage: start-emulator.sh PRODUCT_GROUP [EMULATOR_VERSION]"
    exit 1;
fi
# Emulator version maybe different for individual products
IMAGE="gcr.io/google.com/cloudsdktool/cloud-sdk:$EMULATOR_VERSION"
docker pull -q $IMAGE
CONTAINER=`docker run \
  -d \
  -p 8085:8085 \
  $IMAGE gcloud beta emulators $1 start --host-port=0.0.0.0:8085 --project=emulator-project`
sleep 10
docker logs $CONTAINER
