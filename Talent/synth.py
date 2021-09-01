# Copyright 2019 Google LLC
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

import subprocess
import synthtool as s
import synthtool.gcp as gcp
import logging

AUTOSYNTH_MULTIPLE_COMMITS = True

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICBazel()
common = gcp.CommonTemplates()

for version in ['v4', 'v4beta1']:
    library = gapic.php_library(
        service='talent',
        version=version,
        bazel_target=f'//google/cloud/talent/{version}:google-cloud-talent-{version}-php'
    )

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / 'proto/src/Google/Cloud/Talent', 'src/')
    s.move(library / 'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Talent', 'metadata/')

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
    'src/V4/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2020')
s.replace(
    'tests/**/V4/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2020')
s.replace(
    'src/V4beta1/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2019')
s.replace(
    'tests/**/V4beta1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2019')

clients = ['ApplicationService', 'CompanyService', 'Completion', 'EventService', 'JobService', 'ProfileService', 'TenantService']
for client in clients:
    s.replace(
        f'src/V*/{client}Client.php',
        r'Copyright \d{4}',
        'Copyright 2019')
    s.replace(
        f'src/V*/{client}GrpcClient.php',
        r'Copyright \d{4}',
        'Copyright 2019')

# Use correct namespace
s.replace(
    'src/**/Gapic/*.php',
    r'CompleteQueryRequest_',
    r'CompleteQueryRequest\\')
s.replace(
    'src/**/Gapic/*.php',
    r'SearchJobsRequest_',
    r'SearchJobsRequest\\')

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

# Address breaking changes
subprocess.run('git show 5e560594fdcfcbb24e32030f7a37aa6b55c39518 | git apply', shell=True)