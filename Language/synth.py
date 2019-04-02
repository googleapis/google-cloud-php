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

gapic = gcp.GAPICGenerator()

for version in ['V1', 'V1beta2']:
    lower_version = version.lower()

    library = gapic.php_library(
        service='language',
        version=lower_version,
        artman_output_name=f'google-cloud-language-{lower_version}')

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / 'proto/src/Google/Cloud/Language', 'src/')
    s.move(library / 'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Language', 'metadata/')

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

# Use new namespaces
s.replace(
    'src/*/Gapic/LanguageServiceGapicClient.php',
    r'AnnotateTextRequest_Features',
    r'AnnotateTextRequest\\Features')
