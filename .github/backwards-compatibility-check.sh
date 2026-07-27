#!/bin/bash
# Copyright 2026 Google LLC
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
#     backwards-compatibility-check.sh COMPONENT
#
# COMPONENT: The component directory name to run the backwards compatibility check for.

if [ "$#" -ne 1 ]; then
    echo "usage: backwards-compatibility-check.sh [COMPONENT]"
    exit 1
fi

COMPONENT=$1

# Exception for 'dev'
if [ "${COMPONENT}" = "dev" ]; then
    echo "Skipping dev directory (not a public component)."
    exit 0
fi

# Check if component directory exists
if [ ! -d "${COMPONENT}" ]; then
    echo "Error: Directory ${COMPONENT} does not exist!" >&2
    exit 1
fi

# Check if composer.json exists
COMP_JSON="${COMPONENT}/composer.json"
if [ ! -f "${COMP_JSON}" ]; then
    echo "Error: composer.json not found in ${COMPONENT}!" >&2
    exit 1
fi

# Retrieve the split repository target using jq
TARGET_REPO=$(jq -r '.extra.component.target // empty' "${COMP_JSON}")
if [ -z "${TARGET_REPO}" ]; then
    echo "Error: no split repository target configured in ${COMP_JSON}!" >&2
    exit 1
fi

echo "Checking backwards compatibility for component: ${COMPONENT}" >&2
echo "Split repository target: ${TARGET_REPO}" >&2

# Create a temporary directory for cloning the split repository
TMP_DIR=$(mktemp -d)

# Clone the split repository with a depth of 1 (containing only the latest commit)
echo "Cloning https://github.com/${TARGET_REPO}..." >&2
if ! git clone -q --depth 1 "https://github.com/${TARGET_REPO}" "${TMP_DIR}"; then
    echo "Failed to clone split repository ${TARGET_REPO}." >&2
    rm -rf "${TMP_DIR}"
    exit 1
fi

# Copy the current local component files over the cloned split repository,
# making sure to exclude vendor directories or composer-local files.
echo "Applying local changes from ${COMPONENT} to the split clone..." >&2
rsync -a --exclude="vendor/" --exclude="composer-local.json" "${COMPONENT}/" "${TMP_DIR}/"

# Commit the changes in the cloned split repository so we can compare them
CODE=0
if (
    cd "${TMP_DIR}"
    git config user.name "Github Actions"
    git config user.email "actions@github.com"
    git add -A

    # Check if there are any changes to commit
    if ! git diff --cached --quiet; then
        git commit -q -m "Apply local PR changes"
        echo "Running Roave Backward Compatibility Check..." >&2

        # Locate the roave binary portably
        COMPOSER_BIN=$(composer global config bin-dir --absolute 2>/dev/null || echo ~/.composer/vendor/bin)
        ROAVE_BIN=$(command -v roave-backward-compatibility-check || echo "${COMPOSER_BIN}/roave-backward-compatibility-check")

        if ! "${ROAVE_BIN}" --from=HEAD~1 --format=markdown; then
            echo "❌ BC Breaks detected in ${COMPONENT}!" >&2
            exit 1
        else
            echo "✅ No BC Breaks detected in ${COMPONENT}." >&2
        fi
    else
        echo "No files modified for ${COMPONENT} compared to the split repository HEAD. Skipping check." >&2
    fi
); then
    CODE=0
else
    CODE=1
fi

rm -rf "${TMP_DIR}"
exit $CODE
