#!/bin/bash

# Script to build doc site.
# This script expects to be invoked from the gax-php root.
#
# This script will look for the GITHUB_REF environment variable, and
# use that as the version number. If no environment variable is found,
# it will use the first command line argument. If no command line
# argument is specified, default to 'master'.

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

UPDATED_INDEX_FILE=$(cat << EndOfMessage
<html><head><script>window.location.replace('/gax-php/${GIT_TAG_NAME}/' + location.hash.substring(1))</script></head><body></body></html>
EndOfMessage
)

function downloadDoctum() {
  # Download the latest (5.1.x) release
  # You can fetch the latest (5.1.x) version code here:
  # https://doctum.long-term.support/releases/5.1/VERSION
  rm -f "${DOCTUM_EXECUTABLE}"
  rm -f "${DOCTUM_EXECUTABLE}.sha256"
  curl -# https://doctum.long-term.support/releases/5.1/doctum.phar -o "${DOCTUM_EXECUTABLE}"
  curl -# https://doctum.long-term.support/releases/5.1/doctum.phar.sha256  -o "${DOCTUM_EXECUTABLE}.sha256"
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
  DOCS_VERSION_TO_BUILD=${1}
  DOCTUM_CONFIG=${ROOT_DIR}/dev/src/Docs/doctum-config.php
  API_CORE_DOCS_VERSION=${DOCS_VERSION_TO_BUILD} php ${DOCTUM_EXECUTABLE} update ${DOCTUM_CONFIG} -v
}

downloadDoctum
if [[ ! -z ${GIT_TAG_NAME} ]]; then
  checkVersionFile ${GIT_TAG_NAME}
  buildDocs ${GIT_TAG_NAME}
  # Update the redirect index file only for builds that use the
  # GIT_TAG_NAME env variable.
  echo ${UPDATED_INDEX_FILE} > ${DOC_OUTPUT_DIR}/index.html
else
  if [[ ! -z ${1} ]]; then
    DOCS_VERSION_TO_BUILD=${1}
  else
    # If no command line arg is specified, default to 'master'
    DOCS_VERSION_TO_BUILD=master
  fi
  buildDocs ${DOCS_VERSION_TO_BUILD}
fi
