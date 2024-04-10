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
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/LongRunning").resolve()
dest = Path().resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

# use owlbot_copy_version instead of owlbot_main and set "version_string"
# manually because LongRunning does not have a version
php.owlbot_copy_version(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "**/[A-Z]*_*.php"
    ],
    version_string="longrunning",
)

# Add an alias for the previous namespace
s.replace(
    "src/LongRunning/OperationsClient.php",
    r"^}$\n",
    r"}\n\nclass_alias('Google\\LongRunning\\OperationsClient', 'Google\\ApiCore\\LongRunning\\OperationsClient');\n")

### [START] protoc backwards compatibility fixes

# roll back to private properties.
s.replace(
    "src/**/**/*.php",
    r"Generated from protobuf field ([^\n]{0,})\n\s{5}\*/\n\s{4}protected \$",
    r"""Generated from protobuf field \1
     */
    private $""")

# prevent proto messages from being marked final
s.replace(
    "src/**/**/*.php",
    r"final class",
    r"class")

### [END] protoc backwards compatibility fixes

# fix relative cloud.google.com links
s.replace(
    "src/**/**/*.php",
    r"(.{0,})\]\((/.{0,})\)",
    r"\1](https://cloud.google.com\2)"
)

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.16',
    '--',
    'prettier',
    '**/Gapic/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=80'])

