<?php
/*
 * Copyright 2026 Google LLC
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

// [START discoveryengine_v1_generated_CompletionService_AdvancedCompleteQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\AdvancedCompleteQueryRequest;
use Google\Cloud\DiscoveryEngine\V1\AdvancedCompleteQueryResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\CompletionServiceClient;

/**
 * Completes the user input with advanced keyword suggestions.
 *
 * @param string $formattedCompletionConfig The completion_config of the parent dataStore or engine resource
 *                                          name for which the completion is performed, such as
 *                                          `projects/&#42;/locations/global/collections/default_collection/dataStores/&#42;/completionConfig`
 *                                          `projects/&#42;/locations/global/collections/default_collection/engines/&#42;/completionConfig`. Please see
 *                                          {@see CompletionServiceClient::completionConfigName()} for help formatting this field.
 * @param string $query                     The typeahead input used to fetch suggestions. Maximum length is
 *                                          128 characters.
 *
 *                                          The query can not be empty for most of the suggestion types. If it is
 *                                          empty, an `INVALID_ARGUMENT` error is returned. The exception is when the
 *                                          suggestion_types contains only the type `RECENT_SEARCH`, the query can
 *                                          be an empty string. The is called "zero prefix" feature, which returns
 *                                          user's recently searched queries given the empty query.
 */
function advanced_complete_query_sample(string $formattedCompletionConfig, string $query): void
{
    // Create a client.
    $completionServiceClient = new CompletionServiceClient();

    // Prepare the request message.
    $request = (new AdvancedCompleteQueryRequest())
        ->setCompletionConfig($formattedCompletionConfig)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var AdvancedCompleteQueryResponse $response */
        $response = $completionServiceClient->advancedCompleteQuery($request);
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
    $formattedCompletionConfig = CompletionServiceClient::completionConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $query = '[QUERY]';

    advanced_complete_query_sample($formattedCompletionConfig, $query);
}
// [END discoveryengine_v1_generated_CompletionService_AdvancedCompleteQuery_sync]
