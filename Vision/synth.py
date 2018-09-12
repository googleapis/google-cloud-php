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

v1_library = gapic.php_library(
    service='vision',
    version='v1',
    artman_output_name='google-cloud-vision-v1')

# copy all src except partial veneer classes
s.move(v1_library / f'src/V1/Gapic')
s.move(v1_library / f'src/V1/resources')

# copy proto files to src also
s.move(v1_library / f'proto/src/Google/Cloud/Vision', f'src/')
s.move(v1_library / f'tests/')

# copy GPBMetadata file to metadata
s.move(v1_library / f'proto/src/GPBMetadata/Google/Cloud/Vision', f'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Change the wording for the deprecation warning.
s.replace(
    'src/*/*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')
