# Copyright 2022 Google LLC
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
    src = Path(f"{php.STAGING_DIR}/{proto[0]}").resolve()

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

# remove owl-bot-staging dir
if os.path.exists(php.STAGING_DIR):
    shutil.rmtree(Path(php.STAGING_DIR))

# remove the metadata/Google files that we copied
if os.path.exists("metadata/Google"):
    shutil.rmtree(Path("metadata/Google"))

s.replace(
    "src/**/*.php",
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

