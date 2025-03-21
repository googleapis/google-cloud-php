# Copyright 2018 Google LLC
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
import re
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/Spanner").resolve()
dest = Path().resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

php.owlbot_main(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "*/src/V1/SpannerClient.php",
        src / "*/proto/src/Google/Cloud/Spanner/V1/TransactionOptions/ReadOnly.php",
    ]
)

# Spanner Database Admin also lives here
admin_library = Path(f"../{php.STAGING_DIR}/Spanner/v1/Admin/Database/v1").resolve()

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Database/V1/Gapic', merge=php._merge)
s.move(admin_library / f'src/V1/Client', 'src/Admin/Database/V1/Client', merge=php._merge)
s.move(admin_library / f'src/V1/resources', f'src/Admin/Database/V1/resources', merge=php._merge)

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/', merge=php._merge)
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Database', merge=php._merge)

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/', merge=php._merge)

# Spanner Instance Admin also lives here
admin_library = Path(f"../{php.STAGING_DIR}/Spanner/v1/Admin/Instance/v1").resolve()

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Instance/V1/Gapic', merge=php._merge)
s.move(admin_library / f'src/V1/Client', 'src/Admin/Instance/V1/Client', merge=php._merge)
s.move(admin_library / f'src/V1/resources', f'src/Admin/Instance/V1/resources', merge=php._merge)

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/', merge=php._merge)
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Instance', merge=php._merge)

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/', merge=php._merge)

# remove class_alias code
s.replace(
    "src/V*/**/*.php",
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

# fix relative cloud.google.com links
s.replace(
    "src/**/V*/**/*.php",
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
