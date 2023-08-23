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

// [START dialogflow_v2_generated_Versions_UpdateVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Version;
use Google\Cloud\Dialogflow\V2\VersionsClient;
use Google\Protobuf\FieldMask;

/**
 * Updates the specified agent version.
 *
 * Note that this method does not allow you to update the state of the agent
 * the given version points to. It allows you to update only mutable
 * properties of the version resource.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_version_sample(): void
{
    // Create a client.
    $versionsClient = new VersionsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $version = new Version();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Version $response */
        $response = $versionsClient->updateVersion($version, $updateMask);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dialogflow_v2_generated_Versions_UpdateVersion_sync]
