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

import subprocess
import synthtool as s
import synthtool.gcp as gcp
import logging

AUTOSYNTH_MULTIPLE_COMMITS = True

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICBazel()
versions = ["V1beta1", "V1"]

for version in versions:
    lower_version = version.lower()
    library = gapic.php_library(
        service='automl',
        version=lower_version,
        bazel_target=f'//google/cloud/automl/{lower_version}:google-cloud-automl-{lower_version}-php',
    )

    # copy all src including partial veneer classes
    s.move(library / 'src')

    # copy proto files to src also
    s.move(library / 'proto/src/Google/Cloud/AutoMl', 'src/')
    s.move(library / 'tests/')

    # copy GPBMetadata file to metadata
    s.move(library / 'proto/src/GPBMetadata/Google/Cloud/Automl', 'metadata/')

# document and utilize apiEndpoint instead of serviceAddress
s.replace(
    "**/Gapic/*GapicClient.php",
    r"'serviceAddress' =>",
    r"'apiEndpoint' =>")
s.replace(
    "**/Gapic/*GapicClient.php",
    r"@type string \$serviceAddress\n\s+\*\s+The address",
    r"""@type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address""")
s.replace(
    "**/Gapic/*GapicClient.php",
    r"\$transportConfig, and any \$serviceAddress",
    r"$transportConfig, and any `$apiEndpoint`")

# fix year
clients = ['AutoMl', 'PredictionService']
versions = ['V1', 'V1beta1']
for client in clients:
    for version in versions:
        s.replace(
            f'src/{version}/Gapic/{client}GapicClient.php',
            r'Copyright \d{4}',
            'Copyright 2019')
        s.replace(
            f'src/{version}/{client}Client.php',
            r'Copyright \d{4}',
            'Copyright 2019')
        s.replace(
            f'src/{version}/{client}GrpcClient.php',
            r'Copyright \d{4}',
            'Copyright 2019')
        s.replace(
            f'tests/**/{version}/{client}ClientTest.php',
            r'Copyright \d{4}',
            'Copyright 2019')

# V1 is GA, so remove @experimental tags
s.replace(
    'src/V1/**/*Client.php',
    r'^(\s+\*\n)?\s+\*\s@experimental\n',
    '')

# Fix class references in gapic samples
for version in versions:
    pathExprs = [
        'src/' + version + '/Gapic/AutoMlGapicClient.php',
        'src/' + version + '/Gapic/PredictionServiceGapicClient.php'
    ]

    for pathExpr in pathExprs:
        types = {
            'new AutoMlClient': r'new Google\\Cloud\\AutoMl\\' + version + r'\\AutoMlClient',
            'new PredictionServiceClient': r'new Google\\Cloud\\AutoMl\\' + version + r'\\PredictionServiceClient',
            '= AudioEncoding::': r'= Google\\Cloud\\Speech\\' + version + r'\\RecognitionConfig\\AudioEncoding::',
            'new Dataset': r'new Google\\Cloud\\AutoMl\\' + version + r'\\Dataset',
            '= new ModelExportOutputConfig': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\ModelExportOutputConfig',
            '= new ExportEvaluatedExamplesOutputConfig': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\ExportEvaluatedExamplesOutputConfig',
            '= new ExportEvaluatedExamplesOutputConfig': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\ExportEvaluatedExamplesOutputConfig',
            '= new TableSpec': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\TableSpec',
            '= new ColumnSpec': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\ColumnSpec',
            '= new BatchPredictInputConfig': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\BatchPredictInputConfig',
            '= new BatchPredictOutputConfig': r'= new Google\\Cloud\\AutoMl\\' + version + r'\\BatchPredictOutputConfig',
        }

        for search, replace in types.items():
            s.replace(
                pathExpr,
                search,
                replace)

### [START] protoc backwards compatibility fixes

# roll back to private properties.
s.replace(
    "src/**/V*/**/*.php",
    r"Generated from protobuf field ([^\n]{0,})\n\s{5}\*/\n\s{4}protected \$",
    r"""Generated from protobuf field \1
     */
    private $""")

# prevent proto messages from being marked final
s.replace(
    "src/**/V*/**/*.php",
    r"final class",
    r"class")

# Replace "Unwrapped" with "Value" for method names.
s.replace(
    "src/**/V*/**/*.php",
    r"public function ([s|g]\w{3,})Unwrapped",
    r"public function \1Value"
)

### [END] protoc backwards compatibility fixes

# fix relative cloud.google.com links
s.replace(
    "src/**/V*/**/*.php",
    r"(.{0,})\]\((/.{0,})\)",
    r"\1](https://cloud.google.com\2)"
)

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.16',
    '--',
    'prettier',
    '**/Gapic/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=80'])
