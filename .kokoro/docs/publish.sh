#!/bin/bash

# determine staging bucket (e.g. "docs-staging-v2-dev")
if [ "$#" -eq 1 ]; then
    STAGING_BUCKET=$1
elif [ "$#" -ne 0 ]; then
    echo "usage: publish.sh [STAGING_BUCKET]"
    exit 1;
fi

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
PROJECT_DIR=$(dirname $(dirname $SCRIPT_DIR))

# Run "composer install" if it hasn't been run yet
if [ ! -d 'vendor/' ]; then
    composer install -d $PROJECT_DIR
fi

if [ "$STAGING_BUCKET" != "" ]; then
    echo "Using staging bucket ${STAGING_BUCKET}..."
fi

find $PROJECT_DIR/* -mindepth 1 -maxdepth 1 -name 'composer.json' -not -path '*vendor/*' -exec dirname {} \; | while read DIR
do
    COMPONENT=$(basename $DIR)
    VERSION=$(cat $DIR/VERSION)
    if [ "$STAGING_BUCKET" != "" ]; then
        $PROJECT_DIR/dev/google-cloud docfx \
            --component $COMPONENT \
            --out $DIR/out \
            --metadata-version $VERSION \
            --staging-bucket $STAGING_BUCKET
    else
        # dry run
        $PROJECT_DIR/dev/google-cloud docfx \
            --component $COMPONENT \
            --out $DIR/out \
            --metadata-version $VERSION
    fi
done
