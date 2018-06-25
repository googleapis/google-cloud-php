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
    service='spanner',
    version='v1',
    config_path='/google/spanner/artman_spanner.yaml',
    artman_output_name='google-cloud-spanner-v1')

# copy all src except handwritten partial veneers
s.move(library / f'src/V1/Gapic')
s.move(library / f'src/V1/resources')

# copy proto files to src also
s.move(library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(library / f'tests/')

# copy GPBMetadata file to metadata
s.move(library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Spanner Database Admin also lives here
admin_library = gapic.php_library(
    service='spanner-admin-database',
    version='v1',
    config_path='/google/spanner/admin/database/artman_spanner_admin_database.yaml',
    artman_output_name='google-cloud-spanner-admin-database-v1')

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Database/V1/Gapic')
s.move(admin_library / f'src/V1/resources', f'src/Admin/Database/V1/resources')

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Database')

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/Admin/Database/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Spanner Instance Admin also lives here
admin_library = gapic.php_library(
    service='spanner-admin-instance',
    version='v1',
    config_path='/google/spanner/admin/instance/artman_spanner_admin_instance.yaml',
    artman_output_name='google-cloud-spanner-admin-instance-v1')

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Instance/V1/Gapic')
s.move(admin_library / f'src/V1/resources', f'src/Admin/Instance/V1/resources')

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Instance')

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/Admin/Instance/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
