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

v1_library = gapic.php_library(
    service='kms',
    version='v1',
    config_path='artman_cloudkms.yaml',
    artman_output_name='google-cloud-kms-v1')

s.copy(v1_library / f'src/')
s.copy(v1_library / f'proto/src/GPBMetadata/Google/Cloud/Kms', f'metadata')
s.copy(v1_library / f'proto/src/Google/Cloud/Kms', f'src')
s.copy(v1_library / f'tests')

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
    "src/V*/**/*.php",
    r"final class",
    r"class")

# Replace "Unwrapped" with "Value" for method names.
s.replace(
    "src/V*/**/*.php",
    r"public function ([s|g]\w{3,})Unwrapped",
    r"public function \1Value"
)

# fix copyright year
s.replace(
    'src/V1/**/*Client.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Use new namespace in the doc sample. See
# https://github.com/googleapis/gapic-generator/issues/2141
s.replace(
    'src/V1/Gapic/KeyManagementServiceGapicClient.php',
    r'CryptoKey_CryptoKeyPurpose',
    'CryptoKeyPurpose')
# Change the wording for the deprecation warning.
s.replace(
    'src/V1/CryptoKey*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')
