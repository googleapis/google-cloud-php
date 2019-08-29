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

v1beta = gapic.php_library(
    service='oslogin',
    version='v1beta',
    artman_output_name='google-cloud-os-login-v1beta')

v1 = gapic.php_library(
    service='oslogin',
    version='v1',
    artman_output_name='google-cloud-os-login-v1')

# copy all src
s.move(v1beta / f'src/V1beta')
s.move(v1 / f'src/V1')

# copy proto files to src also
s.move(v1beta / f'proto/src/Google/Cloud/OsLogin', f'src/')
s.move(v1 / f'proto/src/Google/Cloud/OsLogin', f'src/')

s.move(v1beta / f'tests/')
s.move(v1 / f'tests/')

# copy GPBMetadata file to metadata
s.move(v1beta / f'proto/src/GPBMetadata/Google/Cloud/Oslogin', f'metadata/')
s.move(v1 / f'proto/src/GPBMetadata/Google/Cloud/Oslogin', f'metadata/')

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
    "src/**/*.php",
    r"final class",
    r"class")

# Replace "Unwrapped" with "Value" for method names.
s.replace(
    "src/**/*.php",
    r"public function ([s|g]\w{3,})Unwrapped",
    r"public function \1Value"
)

# fix copyright year
s.replace(
    'src/V1beta/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/V1beta/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'src/V1/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
