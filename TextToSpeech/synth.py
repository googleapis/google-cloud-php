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

v1_library = gapic._generate_code(
    'texttospeech', 'v1', 'php',
    config_path='artman_texttospeech_v1.yaml',
    artman_output_name='google-cloud-texttospeech-v1')

s.copy(v1_library / f'src/')
s.copy(v1_library / f'proto/src/GPBMetadata/Google/Cloud/Texttospeech', f'metadata')
s.copy(v1_library / f'proto/src/Google/Cloud/TextToSpeech', f'src')
s.copy(v1_library / f'tests')

# fix copyright year
s.replace(
    'src/V1/**/*Client.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
