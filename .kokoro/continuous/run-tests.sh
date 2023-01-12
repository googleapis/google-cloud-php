#!/bin/bash

set -ex

pushd github/google-cloud-php
composer --no-interaction --no-ansi --no-progress update

SHORT_JOB_NAME=${KOKORO_JOB_NAME##*/}

mkdir -p ${SHORT_JOB_NAME}/unit
mkdir -p ${SHORT_JOB_NAME}/snippets
mkdir -p ${SHORT_JOB_NAME}/system

UNIT_LOG_FILENAME=${SHORT_JOB_NAME}/unit/sponge_log.xml
SNIPPETS_LOG_FILENAME=${SHORT_JOB_NAME}/snippets/sponge_log.xml
SYSTEM_LOG_FILENAME=${SHORT_JOB_NAME}/system/sponge_log.xml

if [ ! -z "${GOOGLE_CLOUD_PHP_TESTS_KEY_PATH}" ]; then
    export GOOGLE_CLOUD_PHP_TESTS_KEY_PATH="${KOKORO_KEYSTORE_DIR}/${GOOGLE_CLOUD_PHP_TESTS_KEY_PATH}"
fi

if [ ! -z "${GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH}" ]; then
    export GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH="${KOKORO_KEYSTORE_DIR}/${GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH}"
fi

if [ ! -z "${GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH}" ]; then
    export GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH="${KOKORO_KEYSTORE_DIR}/${GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH}"
fi

# non-secret env vars
export ASSET_TEST_BUCKET="php_asset_test_bucket"

echo "Running PHPCS Code Style Checker"
dev/sh/style

PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION;')
if [ "5" == $PHP_VERSION ]; then
    # Exclude compute if the PHP version is below 7.0
    PHPUNIT_SUFFIX="-php5"
fi

echo "Running Unit Test Suite"
vendor/bin/phpunit -c phpunit${PHPUNIT_SUFFIX}.xml.dist --log-junit ${UNIT_LOG_FILENAME}

echo "Running Snippet Test Suite"
vendor/bin/phpunit -c phpunit-snippets.xml.dist --verbose --log-junit \
                   ${SNIPPETS_LOG_FILENAME}

echo "Running System Test Suite"
vendor/bin/phpunit -d memory_limit=512M -c phpunit${PHPUNIT_SUFFIX}-system.xml.dist \
                   --verbose --log-junit ${SYSTEM_LOG_FILENAME}

echo "Running package integration Test"

dev/google-cloud integration -u

popd
