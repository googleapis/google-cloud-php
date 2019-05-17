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

import synthtool as s
import synthtool.gcp as gcp
import logging
import os

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICGenerator()
common = gcp.CommonTemplates()

library = gapic.php_library(
    service='talent',
    version='v4beta1',
    config_path='/google/cloud/talent/artman_talent_v4beta1.yaml',
    artman_output_name='google-cloud-talent-v4beta1')

# copy all src including partial veneer classes
s.move(library / 'src')

# copy proto files to src also
s.move(library / 'proto/src/Google/Cloud/Talent', 'src/')
s.move(library / 'tests/')

# copy GPBMetadata file to metadata
s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Talent', 'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2019')
s.replace(
    'tests/**/V4beta1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2019')

# Use correct namespace
s.replace(
    'src/V4beta1/Gapic/*.php',
    r'CompleteQueryRequest_',
    r'CompleteQueryRequest\\')
s.replace(
    'src/V4beta1/Gapic/*.php',
    r'SearchJobsRequest_',
    r'SearchJobsRequest\\')
