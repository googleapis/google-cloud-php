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
if [ ! -d "$PROJECT_DIR/dev/vendor" ]; then
    composer install --no-dev -d "$PROJECT_DIR/dev"
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
run_docfx() {
    local DIR=$1
    local COMPONENT
    COMPONENT=$(basename "$DIR")
    local VERSION
    VERSION=$(cat "$DIR/VERSION")

    echo "--- Generating DocFX for ${COMPONENT} ---"
    if ! "$PROJECT_DIR/dev/google-cloud" docfx \
        --component "$COMPONENT" \
        --out "$DIR/out" \
        --metadata-version "$VERSION" \
        --with-cache \
        $STAGING_FLAG \
        $VERBOSITY_FLAG; then
        echo "Error: DocFX generation failed for ${COMPONENT}"
        return 1
    fi
    return 0
}

run_docfx_parallel() {
    local DIR=$1
    local LOG_FILE
    LOG_FILE=$(mktemp)

    run_docfx "${DIR}" > "$LOG_FILE" 2>&1
    local EXIT_CODE=$?

    cat "$LOG_FILE"
    rm "$LOG_FILE"
    return $EXIT_CODE
}
export -f run_docfx
export -f run_docfx_parallel
export PROJECT_DIR
export STAGING_FLAG
export VERBOSITY_FLAG

# Get the list of directories
DIRS=$(find $PROJECT_DIR/* -mindepth 1 -maxdepth 1 -name 'composer.json' -not -path '*vendor/*' -regex "$PROJECT_DIR/[A-Z].*" -exec dirname {} \;)

DIR_ARRAY=()
for DIR in ${DIRS}; do
    if [ -d "${DIR}" ]; then
        DIR_ARRAY+=("${DIR}")
    fi
done

# Warm the cache
echo "--- Warming DocFX Cache ---"
if ! "$PROJECT_DIR/dev/google-cloud" docfx --warm-cache; then
    echo "Error: Initial DocFX cache warming failed. Aborting." >&2
    exit 1
fi

# Run all in parallel
if [ ${#DIR_ARRAY[@]} -gt 0 ]; then
    MAX_JOBS=${MAX_JOBS:-$(nproc 2>/dev/null || echo 8)}
    printf "%s\n" "${DIR_ARRAY[@]}" | xargs -P "${MAX_JOBS}" -I {} bash -c 'run_docfx_parallel "$@"' _ {}
fi

# Add protobuf
PROTOBUF_DIR=$PROJECT_DIR/dev/vendor/google/protobuf
PROTOBUF_VERSION=$(composer info google/protobuf -f json -d $PROJECT_DIR/dev | jq -r .versions[0])
$PROJECT_DIR/dev/google-cloud docfx \
    --path $PROTOBUF_DIR \
    --out protobuf-out \
    --metadata-version $PROTOBUF_VERSION \
    $STAGING_FLAG \
    $VERBOSITY_FLAG

# Add product-neutral guides
$PROJECT_DIR/dev/google-cloud docfx \
    --generate-product-neutral-guides \
    --out help-out \
    --metadata-version 1.0.0 \
    $STAGING_FLAG \
    $VERBOSITY_FLAG
