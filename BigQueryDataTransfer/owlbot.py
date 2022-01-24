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

import logging
from pathlib import Path
import subprocess

import synthtool as s
from synthtool.languages import php

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/BigQueryDataTransfer").resolve()
dest = Path().resolve()

php.owlbot_main(src=src, dest=dest)



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

# Change the wording for the deprecation warning.
s.replace(
    'src/*/*_*.php',
    r'will be removed in the next major release',
    'will be removed in a future release')

# fix test group
s.replace(
    'tests/**/V1/*Test.php',
    r'@group datatransfer',
    '@group bigquerydatatransfer')

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

# fix backwards-compatibility issues due to removed resource name helpers
f = open("src/V1/Gapic/DataTransferServiceGapicClient.php",  "r")
if "public static function locationDataSourceName" not in f.read():
    s.replace(
        "src/V1/Gapic/DataTransferServiceGapicClient.php",
        r"^}$",
        r"""
    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_data_source resource.
     *
     * @param string $project
     * @param string $location
     * @param string $dataSource
     *
     * @return string The formatted location_data_source resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationDataSourceName($project, $location, $dataSource)
    {
        return self::projectLocationDataSourceName($project, $location, $dataSource);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_run resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted location_run resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationRunName($project, $location, $transferConfig, $run)
    {
        return self::projectLocationTransferConfigRunName($project, $location, $transferConfig, $run);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_transfer_config resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     *
     * @return string The formatted location_transfer_config resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationTransferConfigName($project, $location, $transferConfig)
    {
        return self::projectLocationTransferConfigName($project, $location, $transferConfig);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_run resource.
     *
     * @param string $project
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted project_run resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function projectRunName($project, $transferConfig, $run)
    {
        return self::projectTransferConfigRunName($project, $transferConfig, $run);
    }
}"""
    )
