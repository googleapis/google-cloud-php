<?php
/*
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START dialogflow_v3_generated_Versions_CompareVersions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\CompareVersionsResponse;
use Google\Cloud\Dialogflow\Cx\V3\VersionsClient;

/**
 * Compares the specified base version with target version.
 *
 * @param string $formattedBaseVersion   Name of the base flow version to compare with the target version.
 *                                       Use version ID `0` to indicate the draft version of the specified flow.
 *
 *                                       Format: `projects/<Project ID>/locations/<Location ID>/agents/
 *                                       <Agent ID>/flows/<Flow ID>/versions/<Version ID>`. Please see
 *                                       {@see VersionsClient::versionName()} for help formatting this field.
 * @param string $formattedTargetVersion Name of the target flow version to compare with the
 *                                       base version. Use version ID `0` to indicate the draft version of the
 *                                       specified flow. Format: `projects/<Project ID>/locations/<Location
 *                                       ID>/agents/<Agent ID>/flows/<Flow ID>/versions/<Version ID>`. Please see
 *                                       {@see VersionsClient::versionName()} for help formatting this field.
 */
function compare_versions_sample(
    string $formattedBaseVersion,
    string $formattedTargetVersion
): void {
    // Create a client.
    $versionsClient = new VersionsClient();

    // Call the API and handle any network failures.
    try {
        /** @var CompareVersionsResponse $response */
        $response = $versionsClient->compareVersions($formattedBaseVersion, $formattedTargetVersion);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedBaseVersion = VersionsClient::versionName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[FLOW]',
        '[VERSION]'
    );
    $formattedTargetVersion = VersionsClient::versionName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[FLOW]',
        '[VERSION]'
    );

    compare_versions_sample($formattedBaseVersion, $formattedTargetVersion);
}
// [END dialogflow_v3_generated_Versions_CompareVersions_sync]
