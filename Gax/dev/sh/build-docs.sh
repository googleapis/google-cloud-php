#!/bin/bash

# Script to build doc site.
# This script expects to be invoked from the gax-php root. It requires a git tag
# as the first argument.

set -ev

if [[ $# -lt 1 ]]
then
    echo "Usage: $0 <tag>"
    exit 1
fi

GIT_TAG_NAME=$1

ROOT_DIR=$(pwd)
DOC_OUTPUT_DIR=${ROOT_DIR}/tmp_gh-pages
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

function checkVersionFile() {
  # Verify that the specified version matches the contents
  # of the VERSION file.
  VERSION_FILE_CONTENTS="$(cat ${ROOT_DIR}/VERSION)"
  if [ ${VERSION_FILE_CONTENTS} != ${1} ]; then
    echo ERROR: mismatched versions
    echo Expected version: ${1}
    echo VERSION file: ${VERSION_FILE_CONTENTS}
    exit 1
  fi
}

function buildDocs() {
  DOCTUM_CONFIG=${ROOT_DIR}/dev/src/Docs/doctum-config.php
  API_CORE_DOCS_VERSION=${GIT_TAG_NAME} php ${DOCTUM_EXECUTABLE} update ${DOCTUM_CONFIG} -v
}

# Remove "v" from start of string if it exists
GIT_TAG_NUMBER=$GIT_TAG_NAME
if [[ ${GIT_TAG_NAME::1} == "v" ]]
then
  GIT_TAG_NUMBER="${GIT_TAG_NAME:1}"
fi

checkVersionFile ${GIT_TAG_NUMBER}
downloadDoctum
buildDocs ${GIT_TAG_NAME}

# Construct the base index file to redirect to the latest version of the docs.
UPDATED_INDEX_FILE=$(cat << EndOfMessage
<html><head><script>window.location.replace('/gax-php/${GIT_TAG_NAME}/' + location.hash.substring(1))</script></head><body></body></html>
EndOfMessage
)
echo ${UPDATED_INDEX_FILE} > ${DOC_OUTPUT_DIR}/index.html
