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


# first argument can be a directory
DIRS=$(find * -maxdepth 0 -type d -name '[A-Z]*')
if [ "$#" -eq 1 ]; then
    DIRS=$1
elif [ "$#" -ne 0 ]; then
    echo "usage: run-package-tests.sh [DIR]"
    exit 1;
fi

FAILED_FILE=$(mktemp -d)/failed
for DIR in $DIRS; do {
    echo "Running $DIR Unit Tests"
    if grep -q 'google/cloud-core' ${DIR}/composer.json; then
        composer config minimum-stability dev -d ${DIR}
        composer config repositories.local path "../Core" -d ${DIR}
        composer require -q --no-interaction --no-ansi --no-progress "google/cloud-core:*" "google/cloud-storage:*" -d ${DIR}
    else
        composer -q --no-interaction --no-ansi --no-progress update -d ${DIR};
    fi
    if [ $? != 0 ]; then
        echo "$DIR: composer install failed" >> "${FAILED_FILE}"
        continue
    fi
    ${DIR}/vendor/bin/phpunit -c ${DIR}/phpunit.xml.dist;
    if [ $? != 0 ]; then
        echo "$DIR: failed" >> "${FAILED_FILE}"
    fi
    if [ -f "${DIR}/phpunit-snippets.xml.dist" ]; then
        echo "Running $DIR Snippet Tests"
        ${DIR}/vendor/bin/phpunit -c ${DIR}/phpunit-snippets.xml.dist;
        if [ $? != 0 ]; then
            echo "$DIR (snippets): failed" >> "${FAILED_FILE}"
        fi
    fi
}; done

if [ -f "${FAILED_FILE}" ]; then
    echo "--------- Failed tests --------------"
    cat "${FAILED_FILE}"
    echo "-------------------------------------"
    exit 1
fi
