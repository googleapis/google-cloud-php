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
import re

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICBazel()
common = gcp.CommonTemplates()

library = gapic.php_library(
    service='spanner',
    version='v1',
    bazel_target='//google/spanner/v1:google-cloud-spanner-v1-php',
)

# copy all src except handwritten partial veneers
s.move(library / f'src/V1/Gapic')
s.move(library / f'src/V1/resources')

# copy proto files to src also
s.move(library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(library / f'tests/')

# copy GPBMetadata file to metadata
s.move(library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

# Spanner Database Admin also lives here
admin_library = gapic.php_library(
    service='spanner-admin-database',
    version='v1',
    bazel_target='//google/spanner/admin/database/v1:google-cloud-admin-database-v1-php',
)

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Database/V1/Gapic')
s.move(admin_library / f'src/V1/resources', f'src/Admin/Database/V1/resources')

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Database')

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

# Spanner Instance Admin also lives here
admin_library = gapic.php_library(
    service='spanner-admin-instance',
    version='v1',
    bazel_target='//google/spanner/admin/instance/v1:google-cloud-admin-instance-v1-php',
)

# copy all src except handwritten partial veneers
s.move(admin_library / f'src/V1/Gapic', 'src/Admin/Instance/V1/Gapic')
s.move(admin_library / f'src/V1/resources', f'src/Admin/Instance/V1/resources')

# copy proto files to src also
s.move(admin_library / f'proto/src/Google/Cloud/Spanner', f'src/')
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin/Instance')

# copy GPBMetadata file to metadata
s.move(admin_library / f'proto/src/GPBMetadata/Google/Spanner', f'metadata/')

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
s.replace(
    '**/Gapic/*GapicClient.php',
    r'Copyright \d{4}',
    r'Copyright 2017')
s.replace(
    'tests/**/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')

# Fix test namespaces
s.replace(
    'tests/Unit/Admin/Database/*/*.php',
    r'namespace Google\\Cloud\\Spanner\\Admin\\Database\\Tests\\Unit',
    r'namespace Google\\Cloud\\Spanner\\Tests\\Unit\\Admin\\Database')
s.replace(
    'tests/Unit/Admin/Instance/*/*.php',
    r'namespace Google\\Cloud\\Spanner\\Admin\\Instance\\Tests\\Unit',
    r'namespace Google\\Cloud\\Spanner\\Tests\\Unit\\Admin\\Instance')

# fix test group
s.replace(
    'tests/**/Admin/Database/V1/*Test.php',
    '@group database',
    '@group spanner-admin-database')

s.replace(
    'tests/**/Admin/Instance/V1/*Test.php',
    '@group instance',
    '@group spanner-admin-instance')

## START fixing commit() breaking change

# move $mutations back into commit() signature
s.replace(
    "src/*/Gapic/SpannerGapicClient.php",
    re.escape("public function commit($session, array $optionalArgs = [])"),
    "public function commit($session, $mutations, array $optionalArgs = [])"
)

# set request value from signature rather than optional args
s.replace(
    "src/*/Gapic/SpannerGapicClient.php",
    re.escape("""if (isset($optionalArgs['mutations'])) {
            $request->setMutations($optionalArgs['mutations']);
        }""" + "\n"),
    "$request->setMutations($mutations);"
)

# fix sample code
s.replace(
    "src/*/Gapic/SpannerGapicClient.php",
    re.escape("""$formattedSession = $spannerClient->sessionName('[PROJECT]', '[INSTANCE]', '[DATABASE]', '[SESSION]');
     *     $response = $spannerClient->commit($formattedSession);"""),
    """$formattedSession = $spannerClient->sessionName('[PROJECT]', '[INSTANCE]', '[DATABASE]', '[SESSION]');
     *     $mutation = new \\\Google\\\Cloud\\\Spanner\\\V1\\\Mutation();
     *     $response = $spannerClient->commit($formattedSession, [$mutation]);"""
)

# remove $mutations from optional args documentation
s.replace(
    "src/*/Gapic/SpannerGapicClient.php",
    re.escape("""@type Mutation[] $mutations
     *          The mutations to be executed when this transaction commits. All
     *          mutations are applied atomically, in the order they appear in
     *          this list.
     *     """),
     ""
)

# add $mutations to parameter documentation
s.replace(
    "src/*/Gapic/SpannerGapicClient.php",
    re.escape("""@param string $session      Required. The session in which the transaction to be committed is running.
     * @param array  $optionalArgs {"""),
    """@param string     $session      Required. The session in which the transaction to be committed is running.
     * @param Mutation[] $mutations    The mutations to be executed when this transaction commits. All
     *                                 mutations are applied atomically, in the order they appear in
     *                                 this list.
     * @param array      $optionalArgs {"""
)

# fix test commitTest()
s.replace(
    "tests/Unit/V1/SpannerClientTest.php",
    re.escape("$response = $client->commit($formattedSession);"),
    """$mutation = new \\\Google\\\Cloud\\\Spanner\\\V1\\\Mutation();
        $response = $client->commit($formattedSession, [$mutation]);"""
)

# fix test commitExceptionTest()
s.replace(
    "tests/Unit/V1/SpannerClientTest.php",
    re.escape("$client->commit($formattedSession);"),
    """$mutation = new \\\Google\\\Cloud\\\Spanner\\\V1\\\Mutation();
            $client->commit($formattedSession, [$mutation]);"""
)

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
