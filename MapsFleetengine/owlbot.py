# Copyright 2023 Google LLC
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
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

dest = Path().resolve()

src0 = Path(f"../{php.STAGING_DIR}/MapsFleetengine").resolve()
_tracked_paths.add(src0)
php.owlbot_copy_version(
    src=src0,
    dest=dest,
    copy_excludes=[
        src0 / "**/[A-Z]*_*.php"
    ],
    version_string="delivery",
)

src = Path(f"../{php.STAGING_DIR}/MapsFleetengine").resolve()
# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

php.owlbot_main(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "**/[A-Z]*_*.php",
    ]
)

# use owlbot_copy_version instead of owlbot_main and set "version_string"
# manually because some common protos do not have a version
src2 = Path(f"../{php.STAGING_DIR}/MapsFleetengine/common-protos").resolve()
_tracked_paths.add(src2)
php.owlbot_copy_version(
    src=src2,
    dest=dest,
    copy_excludes=[
        src2 / "**/[A-Z]*_*.php"
    ],
    version_string="geo",
)

# remove class_alias code
s.replace(
    "src/V*/**/*.php",
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.16',
    '--',
    'prettier',
    '**/BaseClient/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=80'])
