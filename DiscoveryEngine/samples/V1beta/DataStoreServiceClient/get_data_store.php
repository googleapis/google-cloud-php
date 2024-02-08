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

// [START discoveryengine_v1beta_generated_DataStoreService_GetDataStore_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\Client\DataStoreServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\DataStore;
use Google\Cloud\DiscoveryEngine\V1beta\GetDataStoreRequest;

/**
 * Gets a [DataStore][google.cloud.discoveryengine.v1beta.DataStore].
 *
 * @param string $formattedName Full resource name of
 *                              [DataStore][google.cloud.discoveryengine.v1beta.DataStore], such as
 *                              `projects/{project}/locations/{location}/collections/{collection_id}/dataStores/{data_store_id}`.
 *
 *                              If the caller does not have permission to access the
 *                              [DataStore][google.cloud.discoveryengine.v1beta.DataStore], regardless of
 *                              whether or not it exists, a PERMISSION_DENIED error is returned.
 *
 *                              If the requested [DataStore][google.cloud.discoveryengine.v1beta.DataStore]
 *                              does not exist, a NOT_FOUND error is returned. Please see
 *                              {@see DataStoreServiceClient::dataStoreName()} for help formatting this field.
 */
function get_data_store_sample(string $formattedName): void
{
    // Create a client.
    $dataStoreServiceClient = new DataStoreServiceClient();

    // Prepare the request message.
    $request = (new GetDataStoreRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DataStore $response */
        $response = $dataStoreServiceClient->getDataStore($request);
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
    $formattedName = DataStoreServiceClient::dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');

    get_data_store_sample($formattedName);
}
// [END discoveryengine_v1beta_generated_DataStoreService_GetDataStore_sync]
