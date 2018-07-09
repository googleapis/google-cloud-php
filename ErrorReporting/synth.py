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
    service='clouderrorreporting',
    version='v1beta1',
    config_path='/google/devtools/clouderrorreporting/artman_errorreporting.yaml',
    artman_output_name='google-cloud-error-reporting-v1beta1')

# copy all src including partial veneer classes
s.move(library / 'src')

# copy proto files to src also
s.move(library / 'proto/src/Google/Cloud/ErrorReporting', 'src/')
s.move(library / 'tests/')

# copy GPBMetadata file to metadata
s.move(library / 'proto/src/GPBMetadata/Google/Devtools/Clouderrorreporting', 'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2017')
for client in ['ErrorGroupService', 'ErrorStatsService', 'ReportErrorsService']:
    s.replace(
        f'**/V1beta1/{client}Client.php',
        r'Copyright \d{4}',
        'Copyright 2017')
s.replace(
    'tests/**/V1beta1/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2018')
