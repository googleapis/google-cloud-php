#!/bin/bash

set -ex

pushd github/google-cloud-php

composer --no-interaction --no-ansi --no-progress update

SHORT_JOB_NAME=${KOKORO_JOB_NAME##*/}

if [ "${SHORT_JOB_NAME}" == "php72" ]; then
    pecl install xdebug
    echo "zend_extension=xdebug.so" > ${PHP_DIR}/lib/conf.d/xdebug.ini
    RUN_CODECOV="true"
    OPT_CLOVER="--coverage-clover=clover.xml"
fi

mkdir -p ${SHORT_JOB_NAME}/unit
mkdir -p ${SHORT_JOB_NAME}/snippets

UNIT_LOG_FILENAME=${SHORT_JOB_NAME}/unit/sponge_log.xml
SNIPPETS_LOG_FILENAME=${SHORT_JOB_NAME}/snippets/sponge_log.xml

echo "Running PHPCS Code Style Checker"
dev/sh/style

echo "Running Unit Test Suite"

vendor/bin/phpunit --log-junit ${UNIT_LOG_FILENAME} ${OPT_CLOVER}

if [ "${RUN_CODECOV}" == "true" ]; then
    bash ${KOKORO_GFILE_DIR}/codecov.sh
fi

echo "Running Snippet Test Suite"

vendor/bin/phpunit -c phpunit-snippets.xml.dist --verbose --log-junit \
                   ${SNIPPETS_LOG_FILENAME}

echo "Running Doc Generator"

php -d 'memory_limit=-1' dev/google-cloud doc

popd
