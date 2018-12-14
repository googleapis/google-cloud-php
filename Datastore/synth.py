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
    service='datastore',
    version='v1',
    config_path='/google/datastore/artman_datastore.yaml',
    artman_output_name='google-cloud-datastore-v1')

# copy all src including partial veneer classes
s.move(library / 'src')

# copy proto files to src also
s.move(library / 'proto/src/Google/Cloud/Datastore', 'src/')
s.move(library / 'tests/')

# copy GPBMetadata file to metadata
s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Datastore', 'metadata/')

# fix year
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    'Copyright 2018')
s.replace(
    '**/V1/DatastoreClient.php',
    r'Copyright \d{4}',
    'Copyright 2018')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    'Copyright 2018')

# Use new namespace in the doc sample. See
# https://github.com/googleapis/gapic-generator/issues/2141
s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) CommitRequest_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'CommitRequest_',
    r'CommitRequest\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) CompositeFilter_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'CompositeFilter_',
    r'CompositeFilter\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) EntityResult_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'EntityResult_',
    r'EntityResult\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) Key_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'Key_',
    r'Key\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) PropertyFilter_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'PropertyFilter_',
    r'PropertyFilter\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) PropertyOrder_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'PropertyOrder_',
    r'PropertyOrder\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) QueryResultBatch_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'QueryResultBatch_',
    r'QueryResultBatch\\')

s.replace(
    'src/V1/Gapic/*.php',
    r'(\@type|\@param) ReadOptions_',
    r'\1 ')

s.replace(
    'src/V1/Gapic/*.php',
    r'ReadOptions_',
    r'ReadOptions\\')
