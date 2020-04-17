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

import synthtool as s
import synthtool.gcp as gcp
import logging

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICBazel()
common = gcp.CommonTemplates()

for ver in ['V1']:
    lower_version = ver.lower()

    library = gapic.php_library(
        service='firestore',
        version=lower_version,
        bazel_target=f'//google/firestore/{lower_version}:google-cloud-firestore-{lower_version}-php',
    )

    # copy all src except partial veneer classes
    s.move(library / f'src/{ver}/Gapic')
    s.move(library / f'src/{ver}/resources')

    # copy proto files to src also
    s.move(library / f'proto/src/Google/Cloud/Firestore', f'src/')
    s.move(library / f'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / f'proto/src/GPBMetadata/Google/Firestore', f'metadata/')

# Firestore Admin also lives here
admin_library = gapic.php_library(
    service='firestore-admin',
    version='v1',
    bazel_target=f'//google/firestore/admin/v1:google-cloud-firestore-admin-v1-php',
)

# copy all src
s.move(admin_library / f'src', 'src/Admin')

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Firestore', f'src/')
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin')

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Firestore', f'metadata/')

# document and utilize apiEndpoint instead of serviceAddress
s.replace(
    "**/Gapic/*GapicClient.php",
    r"'serviceAddress' =>",
    r"'apiEndpoint' =>")
s.replace(
    "**/Gapic/*GapicClient.php",
    r"@type string \$serviceAddress\n\s+\*\s+The address",
    r"""@type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address""")
s.replace(
    "**/Gapic/*GapicClient.php",
    r"\$transportConfig, and any \$serviceAddress",
    r"$transportConfig, and any `$apiEndpoint`")

yearFixes = [
    {
        "year": "2017",
        "files": [
            "src/V1beta1/Gapic/*GapicClient.php",
            "src/V1beta1/*Client.php",
            "tests/**/V1beta1/*Test.php"
        ]
    }, {
        "year": "2019",
        "files": [
            "src/V1/Gapic/*GapicClient.php",
            "src/V1/*Client.php",
            "tests/**/V1/*Test.php",
            "src/Admin/V1/*Client.php",
            'src/Admin/V1/Gapic/*GapicClient.php',
        ]
    }
]

for fix in yearFixes:
    year = fix.get("year")
    for path in fix.get("files"):
        s.replace(
            path,
            r'Copyright \d{4}',
            f'Copyright {year}'
        )

# fix test group
s.replace(
    'tests/**/Admin/V1/*Test.php',
    r'@group admin',
    '@group firestore-admin')

### [START] protoc backwards compatibility fixes

# roll back to private properties.
s.replace(
    "src/**/V*/**/*.php",
    r"Generated from protobuf field ([^\n]{0,})\n\s{5}\*/\n\s{4}protected \$",
    r"""Generated from protobuf field \1
     */
    private $""")

# prevent proto messages from being marked final
s.replace(
    "src/**/V*/**/*.php",
    r"final class",
    r"class")

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
