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
common = gcp.CommonTemplates()

for version in ['V1', 'V1beta2']:
    lower_version = version.lower()

    library = gapic.php_library(
        service='videointelligence',
        version=lower_version,
        artman_output_name=f'google-cloud-video-intelligence-{lower_version}')

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / 'proto/src/Google/Cloud/VideoIntelligence', 'src/')
    s.move(library / 'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Videointelligence', 'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2017')
s.replace(
    '**/V1*/VideoIntelligenceServiceClient.php',
    r'Copyright \d{4}',
    'Copyright 2017')
s.replace(
    'tests/**/V1*/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2018')

# V1 is GA, so remove @experimental tags
s.replace(
    'src/V1/VideoIntelligenceServiceClient.php',
    r'^(\s+\*\n)?\s+\*\s@experimental\n',
    '')
s.replace(
    'src/V1/Gapic/*GapicClient.php',
    r'^(\s+\*\n)?\s+\*\s@experimental\n',
    '')
