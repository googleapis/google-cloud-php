#!/bin/bash

set -ex

pushd github/google-cloud-php

# retry composer update command on fail up to 3 times.
for i in $(seq 1 3); do composer --no-interaction --no-ansi --no-progress update && s=0 && break || s=$? && sleep 15; done; (exit $s)

SHORT_JOB_NAME=${KOKORO_JOB_NAME##*/}

# if [ "${SHORT_JOB_NAME}" == "php72" ]; then
#     pecl install xdebug
#     echo "zend_extension=xdebug.so" > ${PHP_DIR}/lib/conf.d/xdebug.ini
#     RUN_CODECOV="true"
#     OPT_CLOVER="--coverage-clover=clover.xml"
# fi

mkdir -p ${SHORT_JOB_NAME}/unit
mkdir -p ${SHORT_JOB_NAME}/snippets

UNIT_LOG_FILENAME=${SHORT_JOB_NAME}/unit/sponge_log.xml
SNIPPETS_LOG_FILENAME=${SHORT_JOB_NAME}/snippets/sponge_log.xml

echo "Running PHPCS Code Style Checker"
dev/sh/style

PHP_VERSION=$(php -r 'echo PHP_VERSION;')
if [ "5" == ${PHP_VERSION:0:1} ]; then
    # Exclude compute if the PHP version is below 7.0
    PHPUNIT_SUFFIX="-php5"
fi

echo "Running Unit Test Suite"

vendor/bin/phpunit -c phpunit${PHPUNIT_SUFFIX}.xml.dist --log-junit \
                   ${UNIT_LOG_FILENAME} ${OPT_CLOVER}

if [ "${RUN_CODECOV}" == "true" ]; then
    bash ${KOKORO_GFILE_DIR}/codecov.sh
fi

echo "Running Snippet Test Suite"

vendor/bin/phpunit -c phpunit-snippets.xml.dist --verbose --log-junit \
                   ${SNIPPETS_LOG_FILENAME}

# Run docs gen on PHP 7.3 only
if [ "7.3" == ${PHP_VERSION:0:3} ]; then
    echo "Running Doc Generator"

    # Require phpdocumentor:4 for docs generation
    composer require --dev --with-dependencies phpdocumentor/reflection:^4.0

    php -d 'memory_limit=-1' dev/google-cloud doc
fi

popd
