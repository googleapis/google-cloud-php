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

library = gapic.php_library(
    service='monitoring',
    version='v3',
    config_path='/google/monitoring/artman_monitoring.yaml',
    artman_output_name='google-cloud-monitoring-v3')

# copy all src except partial veneer classes
s.move(library / f'src/V3/Gapic')
s.move(library / f'src/V3/resources')

# copy proto files to src also
s.move(library / f'proto/src/Google/Cloud/Monitoring', f'src/')
s.move(library / f'tests/')

# copy GPBMetadata file to metadata
s.move(library / f'proto/src/GPBMetadata/Google/Monitoring', f'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    '**/Gapic/AlertPolicyServiceGapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    '**/Gapic/NotificationChannelServiceGapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/**/V3/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
