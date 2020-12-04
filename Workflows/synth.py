# Copyright 2020 Google LLC
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

workflows_library = gapic.php_library(
    service='workflows',
    version='v1beta',
    bazel_target='//google/cloud/workflows/v1beta:google-cloud-workflows-v1beta-php',
)

# copy all src including partial veneer classes
s.move(workflows_library / 'src')

# copy proto files to src also
s.move(workflows_library / 'proto/src/Google/Cloud/Workflows', 'src/')
s.move(workflows_library / 'tests/')

# copy GPBMetadata file to metadata
s.move(workflows_library / 'proto/src/GPBMetadata/Google/Cloud/Workflows', 'metadata/')

executions_library = gapic.php_library(
    service='workflows-executions',
    version='v1beta',
    bazel_target='//google/cloud/workflows/executions/v1beta:google-cloud-workflows-executions-v1beta-php',
)

# copy all src including partial veneer classes
s.move(executions_library / 'src', 'src/Executions')

# copy proto files to src also
s.move(executions_library / 'proto/src/Google/Cloud/Workflows', 'src/')
s.move(executions_library / 'tests/Unit', 'tests/Unit/Executions')

# copy GPBMetadata file to metadata
s.move(executions_library / 'proto/src/GPBMetadata/Google/Cloud/Workflows', 'metadata/')

# Fix test namespaces
s.replace(
    'tests/Unit/Executions/*/*.php',
    r'namespace Google\\Cloud\\Workflows\\Executions\\Tests\\Unit',
    r'namespace Google\\Cloud\\Workflows\\Tests\\Unit\\Executions')

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

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2020')
s.replace(
    '**/V1beta/*Client.php',
    r'Copyright \d{4}',
    'Copyright 2020')
s.replace(
    'tests/**/V1beta/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2020')

# Change the wording for the deprecation warning.
s.replace(
    'src/*/*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')

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
