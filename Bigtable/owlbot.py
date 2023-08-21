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
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/Bigtable").resolve()
dest = Path().resolve()

# For preserving the copyright year, we use php._merge function
preserve_copyright_year = php._merge

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

# Excluding the partial veneer files.
php.owlbot_main(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "*/src/V2/BigtableClient.php"
    ]
)

# First copy the Bigtable Admin
admin_library = Path(f"../{php.STAGING_DIR}/Bigtable/v2/Admin").resolve()

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V2/Gapic', 'src/Admin/V2/Gapic', merge=preserve_copyright_year)
s.move(admin_library / f'src/V2/Client', 'src/Admin/V2/Client', merge=preserve_copyright_year)
s.move(admin_library / f'src/V2/resources', f'src/Admin/V2/resources', merge=preserve_copyright_year)

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Bigtable', f'src/', merge=preserve_copyright_year)
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin', merge=preserve_copyright_year)

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Bigtable', f'metadata/', merge=preserve_copyright_year)


# fix unit test namespace
s.replace(
    'tests/Unit/Admin/*/*.php',
    r'namespace Google\\Cloud\\Bigtable\\Admin\\Tests\\Unit',
    r'namespace Google\\Cloud\\Bigtable\\Tests\\Unit\\Admin')

# fix test group
s.replace(
    'tests/**/Admin/**/*Test.php',
    '@group admin',
    '@group bigtable' + '\n' + ' * bigtable-admin')

# Fix class references in gapic samples
for version in ['V2']:
    pathExpr = [
        'src/' + version + '/Gapic/BigtableGapicClient.php',
        'src/Admin/' + version + '/Gapic/*GapicClient.php'
    ]

    types = {
        'new BigtableClient': r'new Google\\Cloud\\Bigtable\\' + version + r'\\BigtableClient',
        'new BigtableInstanceAdminClient': r'new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\BigtableInstanceAdminClient',
        r'\$instance = new Instance': r'$instance = new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\Instance',
        '= Type::': r'= Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\Instance\\Type::',
        'new FieldMask': r'new Google\\Protobuf\\FieldMask',
        r'\$cluster = new Cluster': r'$cluster = new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\Cluster',
        'new AppProfile': r'new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\AppProfile',
        'new Policy': r'new Google\\Cloud\\Iam\\V1\\Policy',
        'new BigtableTableAdminClient': r'new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\BigtableTableAdminClient',
        'new Table': r'new Google\\Cloud\\Bigtable\\Admin\\' + version + r'\\Table',
    }

    for search, replace in types.items():
        s.replace(
            pathExpr,
            search,
            replace
)

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

