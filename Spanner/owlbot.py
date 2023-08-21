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


# Fix test namespaces
s.replace(
    'tests/Unit/Admin/Database/*/*.php',
    r'namespace Google\\Cloud\\Spanner\\Admin\\Database\\Tests\\Unit',
    r'namespace Google\\Cloud\\Spanner\\Tests\\Unit\\Admin\\Database')
s.replace(
    'tests/Unit/Admin/Instance/*/*.php',
    r'namespace Google\\Cloud\\Spanner\\Admin\\Instance\\Tests\\Unit',
    r'namespace Google\\Cloud\\Spanner\\Tests\\Unit\\Admin\\Instance')

# fix test group
s.replace(
    'tests/**/Admin/Database/V1/*Test.php',
    '@group database',
    '@group spanner-admin-database')

s.replace(
    'tests/**/Admin/Instance/V1/*Test.php',
    '@group instance',
    '@group spanner-admin-instance')

# remove ReadOnly class_alias code
s.replace(
    "src/V*/**/PBReadOnly.php",
    r"^// Adding a class alias for backwards compatibility with the \"readonly\" keyword.$"
    + "\n"
    + r"^class_alias\(PBReadOnly::class, __NAMESPACE__ . '\\ReadOnly'\);$"
    + "\n",
    '')

### [START] protoc backwards compatibility fixes

# roll back to private properties.
s.replace(
    "src/**/V*/**/*.php",
    r"Generated from protobuf field ([^\n]{0,})\n\s{5}\*/\n\s{4}protected \$",
    r"""Generated from protobuf field \1
     */
    private $""")

# Replace "Unwrapped" with "Value" for method names.
s.replace(
    "src/**/V*/**/*.php",
    r"public function ([s|g]\w{3,})Unwrapped",
    r"public function \1Value"
)

### [END] protoc backwards compatibility fixes

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
