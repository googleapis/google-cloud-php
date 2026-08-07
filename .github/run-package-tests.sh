#!/bin/bash
# Copyright 2022 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

set -e

# USAGE:
#
#     run-package-tests.sh [DIRECTORY] [PREFER_LOWEST]
#
# DIRECTORY:     Optionally pass in a component directory and only run the script
#.               for that component.
#
# PREFER_LOWEST: can be "--prefer-lowest" or "--prefer-lowest-strict". When the
#                "--prefer-lowest-strict" flag is set, local package dependencies
#                are  installed according to their version number in
#                `[Component]/VERSION`. This flag is set on the release PRs to
#.               ensure the dependencies for the upcoming release will be
#                configured correctly.

DIRS=$(find * -maxdepth 0 -type d -name '[A-Z]*')
PREFER_LOWEST=""
if [ "$#" -eq 1 ]; then
    # first argument can be a directory or "--prefer-lowest"
    if [ "$1" = "--prefer-lowest" ] || [ "$1" = "--prefer-lowest-strict" ]; then
        PREFER_LOWEST="--prefer-lowest"
        if [ "$1" = "--prefer-lowest-strict" ]; then STRICT="true"; fi
    else
        DIRS=$1
    fi
elif [ "$#" -eq 2 ]; then
    # first argument is a directory, second is "--prefer-lowest"
    if [ "$2" = "--prefer-lowest" ] || [ "$2" = "--prefer-lowest-strict" ]; then
        DIRS=$1
        PREFER_LOWEST="--prefer-lowest"
        if [ "$2" = "--prefer-lowest-strict" ]; then STRICT="true"; fi
    else
        echo "usage: run-package-tests.sh [DIR] [--prefer-lowest|--prefer-lowest-strict]"
        exit 1;
    fi
elif [ "$#" -ne 0 ]; then
    echo "usage: run-package-tests.sh [DIR] [--prefer-lowest|--prefer-lowest-strict]"
    exit 1;
fi

# Use "composer-local.json" to avoid unwanted changes
export COMPOSER=composer-local.json

FAILED_FILE=$(mktemp -d)/failed

# Executes the package test logic for a single component directory.
# This function is responsible for copy/configuring local dependencies,
# updating Composer, and running PHPUnit tests (unit + optional snippet tests).
# It returns 0 on success, or 1 on failure.
run_package_test() {
    local DIR=$1
    echo "--- Processing ${DIR} ---"
    cp "${DIR}/composer.json" "${DIR}/composer-local.json"

    # Update composer to use local packages
    local PACKAGE_DEPENDENCIES=(
        "Auth,auth"
        "Gax,gax"
        "CommonProtos,common-protos,4.100"
        "BigQuery,cloud-bigquery"
        "Core,cloud-core"
        "Logging,cloud-logging"
        "PubSub,cloud-pubsub"
        "Storage,cloud-storage,2.100"
        "ShoppingCommonProtos,shopping-common-protos"
        "GeoCommonProtos,geo-common-protos,0.1"
        "Monitoring,cloud-monitoring"
    )
    for i in "${PACKAGE_DEPENDENCIES[@]}"; do
        IFS="," read -r PKG_DIR PKG_NAME PKG_VERSION <<< "$i"
        if grep -q "\"google/${PKG_NAME}\":" "${DIR}/composer.json"; then
            # determine local package version
            local VERSION
            if [ "${STRICT}" = "true" ]; then
                VERSION=$(cat "${PKG_DIR}/VERSION")
            elif [ -z "${PKG_VERSION}" ]; then
                VERSION="1.100"
            else
                VERSION=${PKG_VERSION}
            fi
            echo "Use local package ${PKG_DIR} as google/${PKG_NAME}:${VERSION} in ${DIR}"
            # "canonical: false" ensures composer will try to install from packagist when the "--prefer-lowest" flag is set.
            local JSON_CONFIG
            JSON_CONFIG=$(printf '{"type":"path","url":"../%s","options":{"versions":{"google/%s":"%s"}},"canonical":false}' "${PKG_DIR}" "${PKG_NAME}" "${VERSION}")
            composer config "repositories.${PKG_NAME}" -d "${DIR}" "${JSON_CONFIG}"
        fi
    done

    echo -n "Installing composer in ${DIR}"
    if [ -n "${PREFER_LOWEST}" ]; then
        echo -n " (with ${PREFER_LOWEST})"
    fi
    echo ""
    if ! composer -q --no-interaction --no-ansi --no-progress ${PREFER_LOWEST} update -d "${DIR}"; then
        echo "${DIR}: composer install failed" >> "${FAILED_FILE}"
        # run again but without "-q" so we can see the error
        composer --no-interaction --no-ansi --no-progress ${PREFER_LOWEST} update -d "${DIR}"
        return 1
    fi

    echo "Running ${DIR} Unit Tests"
    if ! "${DIR}/vendor/bin/phpunit" -c "${DIR}/phpunit.xml.dist"; then
        echo "${DIR}: failed" >> "${FAILED_FILE}"
        return 1
    fi

    if [ -f "${DIR}/phpunit-snippets.xml.dist" ]; then
        echo "Running ${DIR} Snippet Tests"
        if ! "${DIR}/vendor/bin/phpunit" -c "${DIR}/phpunit-snippets.xml.dist"; then
            echo "${DIR} (snippets): failed" >> "${FAILED_FILE}"
            return 1
        fi
    fi
    return 0
}

# Wrapper function to run the package test logic for a single component.
# Buffers all stdout/stderr into a temporary log file to ensure that concurrent
# executions run completely hermetically and their log outputs are printed
# contiguously, rather than interleaved at the line level.
run_package_test_parallel() {
    local DIR=$1
    local LOG_FILE
    LOG_FILE=$(mktemp)

    # Run the logic, capturing all output
    run_package_test "${DIR}" > "$LOG_FILE" 2>&1
    local EXIT_CODE=$?

    # Print the captured output atomically to standard streams
    cat "$LOG_FILE"
    rm "$LOG_FILE"
    return $EXIT_CODE
}

# Export functions and key env vars so they are available within subprocesses spawned by xargs
export -f run_package_test
export -f run_package_test_parallel
export STRICT
export PREFER_LOWEST
export FAILED_FILE

# Determine optimal parallelism: default to the number of CPU cores on the host runner
MAX_JOBS=${MAX_JOBS:-$(nproc 2>/dev/null || echo 8)}

# Run the test suites concurrently using xargs -P
printf "%s\n" ${DIRS} | xargs -P "${MAX_JOBS}" -I {} bash -c 'run_package_test_parallel "$@"' _ {}

if [ -f "${FAILED_FILE}" ]; then
    echo "--------- Failed tests --------------"
    cat "${FAILED_FILE}"
    echo "-------------------------------------"
    exit 1
fi
