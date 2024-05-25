<?php
/*
 * Copyright 2024 Google LLC
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

// [START discoveryengine_v1_generated_ConversationalSearchService_DeleteSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\ConversationalSearchServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DeleteSessionRequest;

/**
 * Deletes a Session.
 *
 * If the [Session][google.cloud.discoveryengine.v1.Session] to delete does
 * not exist, a NOT_FOUND error is returned.
 *
 * @param string $formattedName The resource name of the Session to delete. Format:
 *                              `projects/{project_number}/locations/{location_id}/collections/{collection}/dataStores/{data_store_id}/sessions/{session_id}`
 *                              Please see {@see ConversationalSearchServiceClient::sessionName()} for help formatting this field.
 */
function delete_session_sample(string $formattedName): void
{
    // Create a client.
    $conversationalSearchServiceClient = new ConversationalSearchServiceClient();

    // Prepare the request message.
    $request = (new DeleteSessionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $conversationalSearchServiceClient->deleteSession($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = ConversationalSearchServiceClient::sessionName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[SESSION]'
    );

    delete_session_sample($formattedName);
}
// [END discoveryengine_v1_generated_ConversationalSearchService_DeleteSession_sync]
