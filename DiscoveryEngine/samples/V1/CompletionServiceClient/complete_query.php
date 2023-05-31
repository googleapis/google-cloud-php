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

// [START discoveryengine_v1_generated_CompletionService_CompleteQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\CompletionServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CompleteQueryRequest;
use Google\Cloud\DiscoveryEngine\V1\CompleteQueryResponse;

/**
 * Completes the specified user input with keyword suggestions.
 *
 * @param string $formattedDataStore The parent data store resource name for which the completion is
 *                                   performed, such as
 *                                   `projects/&#42;/locations/global/collections/default_collection/dataStores/default_data_store`. Please see
 *                                   {@see CompletionServiceClient::dataStoreName()} for help formatting this field.
 * @param string $query              The typeahead input used to fetch suggestions. Maximum length is
 *                                   128 characters.
 */
function complete_query_sample(string $formattedDataStore, string $query): void
{
    // Create a client.
    $completionServiceClient = new CompletionServiceClient();

    // Prepare the request message.
    $request = (new CompleteQueryRequest())
        ->setDataStore($formattedDataStore)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var CompleteQueryResponse $response */
        $response = $completionServiceClient->completeQuery($request);
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
    $formattedDataStore = CompletionServiceClient::dataStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $query = '[QUERY]';

    complete_query_sample($formattedDataStore, $query);
}
// [END discoveryengine_v1_generated_CompletionService_CompleteQuery_sync]
