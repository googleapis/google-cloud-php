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

// [START discoveryengine_v1_generated_SearchTuningService_ListCustomModels_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\SearchTuningServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ListCustomModelsRequest;
use Google\Cloud\DiscoveryEngine\V1\ListCustomModelsResponse;

/**
 * Gets a list of all the custom models.
 *
 * @param string $formattedDataStore The resource name of the parent Data Store, such as
 *                                   `projects/&#42;/locations/global/collections/default_collection/dataStores/default_data_store`.
 *                                   This field is used to identify the data store where to fetch the models
 *                                   from. Please see
 *                                   {@see SearchTuningServiceClient::dataStoreName()} for help formatting this field.
 */
function list_custom_models_sample(string $formattedDataStore): void
{
    // Create a client.
    $searchTuningServiceClient = new SearchTuningServiceClient();

    // Prepare the request message.
    $request = (new ListCustomModelsRequest())
        ->setDataStore($formattedDataStore);

    // Call the API and handle any network failures.
    try {
        /** @var ListCustomModelsResponse $response */
        $response = $searchTuningServiceClient->listCustomModels($request);
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
    $formattedDataStore = SearchTuningServiceClient::dataStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );

    list_custom_models_sample($formattedDataStore);
}
// [END discoveryengine_v1_generated_SearchTuningService_ListCustomModels_sync]
