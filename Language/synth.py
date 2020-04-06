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

for version in ['V1', 'V1beta2']:
    lower_version = version.lower()

    library = gapic.php_library(
        service='language',
        version=lower_version,
        bazel_target=f'//google/cloud/language/{lower_version}:google-cloud-language-{lower_version}-php'
    )

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / 'proto/src/Google/Cloud/Language', 'src/')
    s.move(library / 'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Language', 'metadata/')

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
    'src/V1beta2/**/*.php',
    r'Copyright \d{4}',
    'Copyright 2017')
s.replace(
    'tests/*/V1beta2/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2018')
s.replace(
    'src/V1/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2019')
s.replace(
    'tests/*/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2019')

# Fix class references in gapic samples
for version in ['V1', 'V1beta2']:
    pathExpr = 'src/' + version + '/Gapic/LanguageServiceGapicClient.php'

    types = {
        'new LanguageServiceClient': r'new Google\\Cloud\\Language\\'+ version + r'\\LanguageServiceClient',
        'new Document': r'new Google\\Cloud\\Language\\'+ version + r'\\Document',
        'new Features': r'new Google\\Cloud\\Language\\'+ version + r'\\AnnotateTextRequest\\Features',
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
