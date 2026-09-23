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

set -euo pipefail

# USAGE:
#
#     backwards-compatibility-check.sh COMPONENT [BASE_REF]
#
# COMPONENT: The component directory name to run the backwards compatibility check for.
# BASE_REF: Optional. The baseline git ref (e.g. 'main', 'origin/main' or a release tag) to compare against. Defaults to 'main'.
#
# BC_FORMAT: Optional env var. 'github-actions' (default) streams Roave
# annotations, 'markdown' writes a collapsible report to stdout instead. In both
# cases the exit code is non-zero when BC breaks are found, and all progress
# messages are written to stderr.

if [ "$#" -lt 1 ] || [ "$#" -gt 2 ]; then
    echo "usage: backwards-compatibility-check.sh COMPONENT [BASE_REF]"
    exit 1
fi

COMPONENT=$1
BASE_REF=${2:-main}

if [ ! -f "${COMPONENT}/composer.json" ]; then
    echo "Error: ${COMPONENT}/composer.json not found!" >&2
    exit 1
fi

# Nothing to compare against if the component is new in this change.
if ! git rev-parse --verify "${BASE_REF}:${COMPONENT}" >/dev/null 2>&1; then
    echo "Component ${COMPONENT} did not exist in ${BASE_REF}. Skipping check (all additions)." >&2
    exit 0
fi

echo "Checking backwards compatibility for ${COMPONENT} against ${BASE_REF}" >&2

TMP_DIR=$(mktemp -d)
trap 'rm -rf "${TMP_DIR}"' EXIT

# Commit the baseline component to a scratch repo, stripping the component
# prefix so the files land at the root (as they do in the split repo). Note
# that git archive honors "export-ignore", so tests/ and config files are
# absent from the baseline. That is harmless here: Roave only inspects the
# autoloaded src/ classes, and extra files only ever register as additions.
git init -q "${TMP_DIR}"
git archive "${BASE_REF}" "${COMPONENT}" | tar -x --strip-components=1 -C "${TMP_DIR}"
git -C "${TMP_DIR}" add -A
git -C "${TMP_DIR}" commit -q -m "Baseline from ${BASE_REF}"

# Overlay the local component on top of the baseline. --delete is required so
# that files removed by this change register as deletions instead of being
# silently retained from the baseline. .git/ must be excluded from --delete.
rsync -a --delete --exclude=".git/" --exclude="vendor/" --exclude="composer-local.json" \
    "${COMPONENT}/" "${TMP_DIR}/"

git -C "${TMP_DIR}" add -A
if git -C "${TMP_DIR}" diff --cached --quiet; then
    echo "No files modified in ${COMPONENT} compared to ${BASE_REF}. Skipping check." >&2
    exit 0
fi
git -C "${TMP_DIR}" commit -q -m "Apply local changes"

ROAVE=$(command -v roave-backward-compatibility-check || echo ~/.composer/vendor/bin/roave-backward-compatibility-check)

if [ "${BC_FORMAT:-github-actions}" = "markdown" ]; then
    # Capture the report so the caller can put it in a PR comment. Progress
    # messages go to stderr above so stdout holds nothing but the report.
    STATUS=0
    OUTPUT=$(cd "${TMP_DIR}" && "${ROAVE}" --from=HEAD~1 --format=markdown) || STATUS=$?
    if [ "${STATUS}" -ne 0 ]; then
        printf '<details>\n<summary><b>%s</b></summary>\n\n%s\n\n</details>\n\n' "${COMPONENT}" "${OUTPUT}"
    fi
elif ! (cd "${TMP_DIR}" && "${ROAVE}" --from=HEAD~1 --format=github-actions); then
    STATUS=1
else
    STATUS=0
fi

if [ "${STATUS}" -ne 0 ]; then
    echo "❌ BC breaks detected in ${COMPONENT}!" >&2
    exit 1
fi

echo "✅ No BC breaks detected in ${COMPONENT}." >&2
