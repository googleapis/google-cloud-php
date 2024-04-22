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
import shutil
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/AppsChat/v1").resolve()
dest = Path().resolve()
card_src = Path(f"../{php.STAGING_DIR}/AppsChat/card-protos/v1").resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

php.owlbot_copy_version(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "**/[A-Z]*_*.php",
    ],
    version_string="chat"
)

php.owlbot_copy_version(
    src=card_src,
    dest=dest,
    copy_excludes=[
        src / "**/[A-Z]*_*.php",
    ],
    version_string="card"
)

# move the GAPIC files into a "Chat" subdirectory
s.move(dest / 'src/V1', dest / 'src/Chat/V1', merge=php._merge)
shutil.rmtree(dest / "src/V1")

# remove class_alias code
s.replace(
    "src/**/*.php",
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
    '**/Client/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=120'])
