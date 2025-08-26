#!/bin/bash

set -e

# determine staging bucket (e.g. "docs-staging-v2-dev")
if [ "$#" -eq 1 ]; then
    STAGING_BUCKET=$1
elif [ "$#" -ne 0 ]; then
    echo "usage: publish.sh [STAGING_BUCKET]"
    exit 1;
fi

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
PROJECT_DIR=$(dirname $(dirname $SCRIPT_DIR))

phpdoc --version

# Run "composer install" if it hasn't been run yet
if [ ! -d 'dev/vendor/' ]; then
    composer install -d $PROJECT_DIR/dev
fi
STAGING_FLAG="";
if [ "$STAGING_BUCKET" != "" ]; then
    echo "Using staging bucket ${STAGING_BUCKET}..."
    STAGING_FLAG="--staging-bucket $STAGING_BUCKET"
fi
VERBOSITY_FLAG="";
if [ "$GCLOUD_DEBUG" = "1" ]; then
    echo "Setting verbosity to VERBOSE...";
    VERBOSITY_FLAG=" -v";
fi
find $PROJECT_DIR/* -mindepth 1 -maxdepth 1 -name 'composer.json' -not -path '*vendor/*' -regex "$PROJECT_DIR/[A-Z].*" -exec dirname {} \; | while read DIR
do
    COMPONENT=$(basename $DIR)
    VERSION=$(cat $DIR/VERSION)
    $PROJECT_DIR/dev/google-cloud docfx \
        --component $COMPONENT \
        --out $DIR/out \
        --metadata-version $VERSION \
        --with-cache \
        $STAGING_FLAG \
        $VERBOSITY_FLAG
done

# Add GAX repo
GAX_DIR=$PROJECT_DIR/dev/vendor/google/gax
$PROJECT_DIR/dev/google-cloud docfx \
    --path $GAX_DIR \
    --out gax-out \
    --metadata-version $(cat $GAX_DIR/VERSION) \
    $STAGING_FLAG \
    $VERBOSITY_FLAG

# Add Auth repo
AUTH_DIR=$PROJECT_DIR/dev/vendor/google/auth
$PROJECT_DIR/dev/google-cloud docfx \
    --path $AUTH_DIR \
    --out auth-out \
    --metadata-version $(cat $AUTH_DIR/VERSION) \
    $STAGING_FLAG \
    $VERBOSITY_FLAG

# Add product-neutral guides
$PROJECT_DIR/dev/google-cloud docfx \
    --generate-product-neutral-guides \
    --out help-out \
    --metadata-version 1.0.0 \
    $STAGING_FLAG \
    $VERBOSITY_FLAG
