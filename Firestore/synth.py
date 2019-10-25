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

import os
import synthtool as s
import synthtool.gcp as gcp
import logging

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICGenerator()
common = gcp.CommonTemplates()

versions = []
versions.append({'version': 'V1', 'config': '/google/firestore/artman_firestore_v1.yaml'})
versions.append({'version': 'V1beta1', 'config': '/google/firestore/artman_firestore.yaml'})

for v in versions:
    ver = v['version']
    lower_version = ver.lower()

    library = gapic.php_library(
        service='firestore',
        version=lower_version,
        config_path=v['config'],
        artman_output_name=f'google-cloud-firestore-{lower_version}')

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
    config_path='/google/firestore/admin/artman_firestore_v1.yaml',
    artman_output_name='google-cloud-firestore-admin-v1')

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

# prevent proto messages from being marked final
s.replace(
    ["src/Admin/**/*.php", "src/V*/**/*.php"],
    r"final class",
    r"class")

# Replace "Unwrapped" with "Value" for method names.
s.replace(
    ["src/Admin/**/*.php", "src/V*/**/*.php"],
    r"public function ([s|g]\w{3,})Unwrapped",
    r"public function \1Value"
)

# fix year
s.replace(
    '**/V1beta1/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2017')
s.replace(
    '**/V1beta1/FirestoreClient.php',
    r'Copyright \d{4}',
    'Copyright 2017')
s.replace(
    'tests/**/V1beta1/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2018')

# fix year
s.replace(
    '**/V1/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2019')
s.replace(
    '**/V1/FirestoreClient.php',
    r'Copyright \d{4}',
    'Copyright 2019')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2019')

# fix year
s.replace(
    'src/Admin/V1/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2019')
s.replace(
    'src/Admin/V1/FirestoreAdminGrpcClient.php',
    r'Copyright \d{4}',
    'Copyright 2019')
s.replace(
    'tests/Unit/Admin/V1/FirestoreAdminClientTest.php',
    r'Copyright \d{4}',
    'Copyright 2019')

# fix test group
s.replace(
    'tests/**/Admin/V1/*Test.php',
    r'@group admin',
    '@group firestore-admin')
