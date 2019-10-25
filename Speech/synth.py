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

for version in ['V1', 'V1p1beta1']:
    lower_version = version.lower()

    library = gapic.php_library(
        service='speech',
        version=lower_version,
        artman_output_name=f'google-cloud-speech-{lower_version}')

    # copy all src except partial veneer classes
    s.move(library / f'src/{version}/Gapic')
    s.move(library / f'src/{version}/resources')

    # copy proto files to src also
    s.move(library / f'proto/src/Google/Cloud/Speech', f'src/')
    s.move(library / f'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / f'proto/src/GPBMetadata/Google/Cloud/Speech', f'metadata/')

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

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    '**/V1p1beta1/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/**/V1*/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Change the wording for the deprecation warning.
s.replace(
    'src/*/*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')

# Fix class references in gapic samples
for version in ['V1', 'V1p1beta1']:
    pathExpr = 'src/' + version + '/Gapic/SpeechGapicClient.php'

    types = {
        'new SpeechClient': r'new Google\\Cloud\\Speech\\' + version + r'\\SpeechClient',
        '= AudioEncoding::': r'= Google\\Cloud\\Speech\\' + version + r'\\RecognitionConfig\\AudioEncoding::',
        'new RecognitionConfig': r'new Google\\Cloud\\Speech\\' + version + r'\\RecognitionConfig',
        'new RecognitionAudio': r'new Google\\Cloud\\Speech\\' + version + r'\\RecognitionAudio',
        'new StreamingRecognizeRequest': r'new Google\\Cloud\\Speech\\' + version + r'\\StreamingRecognizeRequest',
    }

    for search, replace in types.items():
        s.replace(
            pathExpr,
            search,
            replace
)
