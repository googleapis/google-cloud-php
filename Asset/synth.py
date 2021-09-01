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

logging.basicConfig(level=logging.DEBUG)

gapic = gcp.GAPICBazel()

library = gapic.php_library(
    service='asset',
    version='v1',
    bazel_target=f'//google/cloud/asset/v1:google-cloud-asset-v1-php',
)
# copy all src including partial veneer classes
s.move(library / 'src')

# copy proto files to src also
s.move(library / f'proto/src/Google/Cloud/Asset', f'src/')
s.move(library / f'tests/')

# copy GPBMetadata file to metadata
s.move(library / f'proto/src/GPBMetadata/Google/Cloud/Asset', f'metadata/')

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

# V1 is GA, so remove @experimental tags
s.replace(
    'src/V1/**/*Client.php',
    r'^(\s+\*\n)?\s+\*\s@experimental\n',
    '')

# fix year
s.replace(
    'src/V1beta1/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'tests/*/V1beta1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2018')
s.replace(
    'src/V1/**/*.php',
    r'Copyright \d{4}',
    r'Copyright 2019')
s.replace(
    'tests/*/V1/*Test.php',
    r'Copyright \d{4}',
    r'Copyright 2019')

# Fix missing formatting method
s.replace(
    'src/V1/Gapic/AssetServiceGapicClient.php',
    r"private static \$feedNameTemplate;\n\s{4}private static \$folderFeedNameTemplate;",
    """private static $feedNameTemplate;
    private static $folderFeedNameTemplate;
    private static $projectNameTemplate;"""
)
s.replace(
    'src/V1/Gapic/AssetServiceGapicClient.php',
    "private static function getPathTemplateMap",
    """private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getPathTemplateMap"""
)
s.replace(
    'src/V1/Gapic/AssetServiceGapicClient.php',
    r"'feed' => self::getFeedNameTemplate\(\),\n\s{0,}'folderFeed' => self::getFolderFeedNameTemplate\(\),",
    """'feed' => self::getFeedNameTemplate(),
                'folderFeed' => self::getFolderFeedNameTemplate(),
                'project' => self::getProjectNameTemplate(),"""
)
s.replace(
    'src/V1/Gapic/AssetServiceGapicClient.php',
    r"\/\*\*\n\s{5}\* Parses a formatted name string and returns an",
    """/**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Parses a formatted name string and returns an"""
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

# Address breaking changes
subprocess.run('git show 1c9eabaf2124b21607f48b7e888cc3c017957ff8 | git apply', shell=True)
