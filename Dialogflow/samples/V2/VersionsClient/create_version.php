<?php
/*
 * Copyright 2022 Google LLC
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

// [START dialogflow_v2_generated_Versions_CreateVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Version;
use Google\Cloud\Dialogflow\V2\VersionsClient;

/**
 * Creates an agent version.
 *
 * The new version points to the agent instance in the "default" environment.
 *
 * @param string $formattedParent The agent to create a version for.
 *                                Supported formats:
 *
 *                                - `projects/<Project ID>/agent`
 *                                - `projects/<Project ID>/locations/<Location ID>/agent`
 *                                Please see {@see VersionsClient::agentName()} for help formatting this field.
 */
function create_version_sample(string $formattedParent): void
{
    // Create a client.
    $versionsClient = new VersionsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $version = new Version();

    // Call the API and handle any network failures.
    try {
        /** @var Version $response */
        $response = $versionsClient->createVersion($formattedParent, $version);
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
    $formattedParent = VersionsClient::agentName('[PROJECT]');

    create_version_sample($formattedParent);
}
// [END dialogflow_v2_generated_Versions_CreateVersion_sync]
