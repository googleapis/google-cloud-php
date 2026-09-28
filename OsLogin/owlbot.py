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
import shutil
from pathlib import Path
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/OsLogin").resolve()
dest = Path().resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

# 1. Handle common protos if staged separately (Librarian pipeline)
if (src / "common-protos").exists():
    php.owlbot_copy_version(
        src=src / "common-protos",
        dest=dest,
        version_string="common",
    )
# 2. Handle common protos bundled inside v1 staging (Legacy OwlBot pipeline)
proto_common = src / "v1/proto/src/Google/Cloud/OsLogin/Common"
metadata_common = src / "v1/proto/src/GPBMetadata/Google/Cloud/Oslogin/Common"
if proto_common.exists():
    s.move([proto_common], dest / "src/Common", merge=php._merge)
    shutil.rmtree(proto_common)
if metadata_common.exists():
    s.move([metadata_common], dest / "metadata/Common", merge=php._merge)
    shutil.rmtree(metadata_common)
# 3. Copy V1 protos and GAPIC files
php.owlbot_main(src=src, dest=dest)

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.19',
    '--',
    'prettier',
    '**/Client/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=120'])
