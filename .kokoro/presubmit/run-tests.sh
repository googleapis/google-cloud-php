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

echo "Running Unit Test Suite"

vendor/bin/phpunit --log-junit ${UNIT_LOG_FILENAME} ${OPT_CLOVER}

if [ "${RUN_CODECOV}" == "true" ]; then
    bash ${KOKORO_GFILE_DIR}/codecov.sh
fi

# We can only run snippets and docs generation on PHP 7.2 and above because of
# phpdocumentor/reflection's minimum requirement.
PHP72_PLUS=$(php -r "echo version_compare(PHP_VERSION, '7.2', '<') ? '' : '1';")
if [ "1" == $PHP72_PLUS ]; then
    echo "Running Snippet Test Suite"

    # install phpdocumentor/reflection
    composer require --dev phpdocumentor/reflection:^4.0

    # run snippets tests
    vendor/bin/phpunit -c phpunit-snippets.xml.dist --verbose --log-junit \
                       ${SNIPPETS_LOG_FILENAME}

    # Run docs generation
    echo "Running Doc Generator"
    php -d 'memory_limit=-1' dev/google-cloud doc
fi

popd
