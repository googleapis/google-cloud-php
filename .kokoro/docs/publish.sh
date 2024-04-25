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

# Run "composer install" if it hasn't been run yet
if [ ! -d 'dev/vendor/' ]; then
    composer install -d $PROJECT_DIR/dev
fi

if [ "$STAGING_BUCKET" != "" ]; then
    echo "Using staging bucket ${STAGING_BUCKET}..."
fi

find $PROJECT_DIR/* -mindepth 1 -maxdepth 1 -name 'composer.json' -not -path '*vendor/*' -regex "$PROJECT_DIR/[A-Z].*" -exec dirname {} \; | while read DIR
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

# If this run after a release, store the released artifacts.
if [ "$KOKORO_GITHUB_COMMIT" != "" ]; then
    # Move to the project directory
    cd $PROJECT_DIR

    # Create a directory for storing all the artifacts
    mkdir pkg

    # Get the released version of the commit
    VERSION=$(git tag --contains "$KOKORO_GITHUB_COMMIT" | head -n 1)

    # Returns the list of modules released in the PR.
    release_modules () {
        modules=$( ./dev/google-cloud release-info "$1" --format=json | jq -r '.releases[].component' )
        echo "${modules[@]}"
    }

    # Store the released artifacts and composer.lock for SBOM generation.
    for module in $(release_modules "$VERSION");
    do
        # Store the released package
        zip -r "pkg/$module.zip" "$module"  -x \
            "$module/.github/*" \
            "$module/samples/*" \
            "$module/tests/*" \
            "$module/.OwlBot.yaml" \
            "$module/.gitattributes" \
            "$module/.repo-metadata.json" \
            "$module/owlbot.py" \
            "$module/phpunit.xml.dist"

        # Store composer.lock for SBOM generation
        mkdir "pkg/$module"
        composer update -d "$module"
        cp "$module/composer.lock" "pkg/$module/composer.lock"
    done
fi