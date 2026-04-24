# Copyright 2023 Google LLC
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

import logging
from pathlib import Path
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/DataCatalogLineage").resolve()
dest = Path().resolve()

# copy over configmanagement (gapic src, samples,  and tests, proto src and metadata) 
configmanagement_src = Path(f"../{php.STAGING_DIR}/DataCatalogLineage/ConfigManagement/v1").resolve()
#executions_library = Path(f"../{php.STAGING_DIR}/Workflows/Executions/v1").resolve()

# copy all src including partial veneer classes
#s.move(
#    executions_library / 'src',
#    'src/Executions',
#    merge=preserve_copyright_year,
#)
## copy proto files to src also
#s.move(
#    executions_library / 'proto/src/Google/Cloud/Workflows',
#    'src/',
#    merge=preserve_copyright_year,
#    excludes=[
#        executions_library / "**/*_*.php"
#    ]
#)
#s.move(
#    executions_library / 'tests/Unit',
#    'tests/Unit/Executions',
#    merge=preserve_copyright_year,
#)
## copy GPBMetadata file to metadata
#s.move(executions_library / 'proto/src/GPBMetadata/Google/Cloud/Workflows',
#    'metadata/',
#    merge=preserve_copyright_year,
#)
#
## Fix test namespaces
#s.replace(
#    'tests/Unit/Executions/*/*.php',
#    r'namespace Google\\Cloud\\Workflows\\Executions\\Tests\\Unit',
#    r'namespace Google\\Cloud\\Workflows\\Tests\\Unit\\Executions')
s.move(configmanagement_src / f'src', 'src/ConfigManagement')
s.move(configmanagement_src / f'samples', 'samples/ConfigManagement')
s.move(configmanagement_src / f'tests/Unit', 'tests/Unit/ConfigManagement')
s.move(configmanagement_src / f'proto/src/Google/Cloud/DataCatalog/Lineage', f'src')
s.move(configmanagement_src / f'proto/src/GPBMetadata/Google/Cloud/Datacatalog/Lineage', f'metadata')

# copy over the standard files
php.owlbot_main(src=src, dest=dest)

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.19',
    '--',
    'prettier',
    '**/Client/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=120'])
