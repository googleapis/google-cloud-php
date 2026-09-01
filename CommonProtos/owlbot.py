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

"""This script is used to synthesize generated parts of this library."""

import logging
from pathlib import Path
import shutil
import subprocess

import os
import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

# Work around a bug in synthtool's `php._find_copy_target`:
# When searching a directory tree for `version_string`, synthtool executes
# `return _find_copy_target(...)` on the first subdirectory it encounters without
# verifying that the recursive call returned a match. If that branch returns None,
# it terminates immediately and abandons checking sibling entries.
#
# In CommonProtos, `google/iam/v1` generates both `Google/Cloud` (for IAM V1)
# and `Google/Iam` (for logging/audit_data) under `.../iam/proto/src/Google/`.
# If the filesystem directory iteration order returns `Iam` before `Cloud` (which
# consistently happens in CI depending on the ext4 directory hash seed), synthtool
# recurses into `Iam`, finds no "cloud" match, and returns None early—failing to
# copy `CommonProtos/src/Cloud/Iam/V1/*.php`.
#
# This patched version continues the loop if `target is None`, ensuring all
# sibling directories are searched regardless of filesystem iteration order.
def _fixed_find_copy_target(src: Path, version_string: str):
    for entry in src.iterdir():
        if entry.name.lower() == version_string:
            return src
        if entry.is_dir():
            target = _fixed_find_copy_target(entry, version_string)
            if target is not None:
                return target
    return None


php._find_copy_target = _fixed_find_copy_target

# (dirname, version)
protos = [
    ("api", "api"),
    ("extendedoperations", "cloud"),
    ("location", "cloud"),
    ("logging", "google"), # for the metadata
    ("logging", "cloud"),
    ("iam", "google"), # for the metadata
    ("iam", "cloud"),
    ("iamlogging", "iam"),
    ("rpc", "rpc"),
    ("type", "type"),
]

dest = Path().resolve()
for proto in protos:
    src = Path(f"../{php.STAGING_DIR}/CommonProtos/{proto[0]}").resolve()

    # Added so that we can pass copy_excludes in the owlbot_main() call
    _tracked_paths.add(src)

    # use owlbot_copy_version instead of owlbot_main and set "version_string"
    # manually because common protos do not have a version
    php.owlbot_copy_version(
        src=src,
        dest=dest,
        version_string=proto[1],
        copy_excludes=[
            src / "**/[A-Z]*_*.php"
        ],
    )

# move metadata to more specific directories (owlbot isnt smart enough to do this)
s.move("metadata/Google/Iam/V1", "metadata/Iam/V1")
s.move("metadata/Google/Logging/Type", "metadata/Logging/Type")

s.replace(
    "src/**/*.php",
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

