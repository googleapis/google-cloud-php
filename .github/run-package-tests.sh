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
for DIR in ${DIRS}; do
    echo "--- Processing ${DIR} ---"
    cp "${DIR}/composer.json" "${DIR}/composer-local.json"
    # Update composer to use local packages
    PACKAGE_DEPENDENCIES=(
        "CommonProtos,common-protos,4.100"
        "BigQuery,cloud-bigquery"
        "Core,cloud-core"
        "Logging,cloud-logging"
        "PubSub,cloud-pubsub"
        "Storage,cloud-storage"
        "ShoppingCommonProtos,shopping-common-protos"
        "GeoCommonProtos,geo-common-protos,0.1"
    )
    for i in "${PACKAGE_DEPENDENCIES[@]}"; do
        IFS="," read -r PKG_DIR PKG_NAME PKG_VERSION <<< "$i"
        if grep -q "\"google/${PKG_NAME}\":" "${DIR}/composer.json"; then
            # determine local package version
            if [ "${STRICT}" = "true" ]; then
                VERSION=$(cat "${PKG_DIR}/VERSION")
            elif [ -z "${PKG_VERSION}" ]; then
                VERSION="1.100"
            else
                VERSION=${PKG_VERSION}
            fi
            echo "Use local package ${PKG_DIR} as google/${PKG_NAME}:${VERSION} in ${DIR}"
            # "canonical: false" ensures composer will try to install from packagist when the "--prefer-lowest" flag is set.
            JSON_CONFIG=$(printf '{"type":"path","url":"../%s","options":{"versions":{"google/%s":"%s"}},"canonical":false}' "${PKG_DIR}" "${PKG_NAME}" "${VERSION}")
            composer config "repositories.${PKG_NAME}" -d "${DIR}" "${JSON_CONFIG}"
        fi
    done

    echo -n "Installing composer in ${DIR}"
    if [ -n "${PREFER_LOWEST}" ]; then
        echo -n " (with ${PREFER_LOWEST})"
    fi
    echo ""
    composer -q --no-interaction --no-ansi --no-progress ${PREFER_LOWEST} update -d "${DIR}" || {
        echo "${DIR}: composer install failed" >> "${FAILED_FILE}"
        # run again but without "-q" so we can see the error
        composer --no-interaction --no-ansi --no-progress ${PREFER_LOWEST} update -d "${DIR}"
        continue
    }
    echo "Running ${DIR} Unit Tests"
    "${DIR}/vendor/bin/phpunit" -c "${DIR}/phpunit.xml.dist" || echo "${DIR}: failed" >> "${FAILED_FILE}"

    if [ -f "${DIR}/phpunit-snippets.xml.dist" ]; then
        echo "Running ${DIR} Snippet Tests"
        "${DIR}/vendor/bin/phpunit" -c "${DIR}/phpunit-snippets.xml.dist" || echo "${DIR} (snippets): failed" >> "${FAILED_FILE}"
    fi
done

if [ -f "${FAILED_FILE}" ]; then
    echo "--------- Failed tests --------------"
    cat "${FAILED_FILE}"
    echo "-------------------------------------"
    exit 1
fi
