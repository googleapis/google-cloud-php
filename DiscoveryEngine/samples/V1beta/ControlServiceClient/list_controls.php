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

// [START discoveryengine_v1beta_generated_ControlService_ListControls_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\ControlServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\Control;
use Google\Cloud\DiscoveryEngine\V1beta\ListControlsRequest;

/**
 * Lists all Controls by their parent
 * [DataStore][google.cloud.discoveryengine.v1beta.DataStore].
 *
 * @param string $formattedParent The data store resource name. Format:
 *                                `projects/{project_number}/locations/{location_id}/collections/{collection_id}/dataStores/{data_store_id}`
 *                                or
 *                                `projects/{project_number}/locations/{location_id}/collections/{collection_id}/engines/{engine_id}`. Please see
 *                                {@see ControlServiceClient::dataStoreName()} for help formatting this field.
 */
function list_controls_sample(string $formattedParent): void
{
    // Create a client.
    $controlServiceClient = new ControlServiceClient();

    // Prepare the request message.
    $request = (new ListControlsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $controlServiceClient->listControls($request);

        /** @var Control $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = ControlServiceClient::dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');

    list_controls_sample($formattedParent);
}
// [END discoveryengine_v1beta_generated_ControlService_ListControls_sync]
