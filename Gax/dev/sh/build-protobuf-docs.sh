#!/bin/bash

# Script to build docs for PHP Protobuf. To be run locally and submitted
# manually when an update is desired.
# The Protobuf team does not maintain the reference documentation for PHP at
# this time and rely on the Core Client Libraries team to do so.
# Docs are deployed to developers.google.com, but soon will be deployed to
# protobuf.dev.
# @see https://developers.google.com/protocol-buffers/docs/reference/overview

# This script expects to be invoked from the gax-php root. It requires a git tag
# of a valid protobuf-php releas eas the first argument.
# @see https://github.com/protocolbuffers/protobuf-php/tags

# Once ran, copy the "api-docs" directory to the protocolbuffers.github.io repo:
# https://github.com/protocolbuffers/protocolbuffers.github.io/tree/main/content/reference/php/api-docs

set -ev

if [ "$#" -ne 1 ]; then
    echo "Usage: $0 TAG"
    exit 1
fi
GIT_TAG_NAME=$1
ROOT_DIR=$(pwd)
DOC_OUTPUT_DIR=${ROOT_DIR}/api-docs
DOCTUM_EXECUTABLE=${ROOT_DIR}/doctum.phar

function downloadDoctum() {
  # Download the latest (5.1.x) release
  # You can fetch the latest (5.1.x) version code here:
  # https://doctum.long-term.support/releases/5.1/VERSION
  rm -f "${DOCTUM_EXECUTABLE}"
  rm -f "${DOCTUM_EXECUTABLE}.sha256"
  curl -# https://doctum.long-term.support/releases/5.5/doctum.phar -o "${DOCTUM_EXECUTABLE}"
  curl -# https://doctum.long-term.support/releases/5.5/doctum.phar.sha256  -o "${DOCTUM_EXECUTABLE}.sha256"
  sha256sum --strict --check "${DOCTUM_EXECUTABLE}.sha256"
  rm -f "${DOCTUM_EXECUTABLE}.sha256"
}

function buildDocs() {
  DOCTUM_CONFIG=${ROOT_DIR}/dev/src/Docs/doctum-protobuf-config.php
  PROTOBUF_DOCS_VERSION=${GIT_TAG_NAME} php ${DOCTUM_EXECUTABLE} update ${DOCTUM_CONFIG} -v
}
# ensure we have the correct version of protobuf
composer update google/protobuf:$GIT_TAG_NAME
# download doctum.phar
downloadDoctum
# build the docs
buildDocs ${GIT_TAG_NAME}

# Construct the base index file to redirect to the Protobuf namespace
UPDATED_INDEX_FILE=$(cat << EndOfMessage
<html><head><script>window.location.replace('Google/Protobuf.html')</script></head><body></body></html>
EndOfMessage
)
echo ${UPDATED_INDEX_FILE} > ${DOC_OUTPUT_DIR}/index.html
