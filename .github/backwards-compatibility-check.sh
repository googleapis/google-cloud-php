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
#     backwards-compatibility-check.sh COMPONENT [BASE_REF]
#
# COMPONENT: The component directory name to run the backwards compatibility check for.
# BASE_REF: Optional. The baseline git ref (e.g. 'main', 'origin/main' or a release tag) to compare against. Defaults to 'main'.

if [ "$#" -lt 1 ] || [ "$#" -gt 2 ]; then
    echo "usage: backwards-compatibility-check.sh COMPONENT [BASE_REF]"
    exit 1
fi

COMPONENT=$1
BASE_REF=${2:-main}

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

echo "Checking backwards compatibility for component: ${COMPONENT} against baseline: ${BASE_REF}" >&2

# Check if the component existed in the baseline reference
if ! git rev-parse --verify "${BASE_REF}:${COMPONENT}" >/dev/null 2>&1; then
    echo "Component ${COMPONENT} did not exist in baseline ${BASE_REF}. Skipping check (all additions)." >&2
    exit 0
fi

# Create a temporary directory
TMP_DIR=$(mktemp -d)

# Initialize a dummy git repo inside TMP_DIR so roave-backward-compatibility-check can compare revisions
(
    cd "${TMP_DIR}"
    git init -q
)

# Extract baseline files from the BASE_REF, stripping the prefix folder so they land at the root of TMP_DIR
if ! git archive "${BASE_REF}" "${COMPONENT}" | tar -x --strip-components=1 -C "${TMP_DIR}" 2>/dev/null; then
    echo "Error: Failed to archive and extract files for ${COMPONENT} from git ref ${BASE_REF}." >&2
    rm -rf "${TMP_DIR}"
    exit 1
fi

(
    cd "${TMP_DIR}"
    git add -A
    git commit -q -m "Base state from ${BASE_REF}"
)

# Copy the current local component files over the baseline repository,
# making sure to exclude vendor directories or composer-local files.
echo "Applying local changes from ${COMPONENT} to the baseline clone..." >&2
rsync -a --exclude="vendor/" --exclude="composer-local.json" "${COMPONENT}/" "${TMP_DIR}/"

# Commit the changes in the cloned split repository so we can compare them
CODE=0
if (
    cd "${TMP_DIR}"
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
        echo "No files modified for ${COMPONENT} compared to ${BASE_REF}. Skipping check." >&2
    fi
); then
    CODE=0
else
    CODE=1
fi

rm -rf "${TMP_DIR}"
exit $CODE
