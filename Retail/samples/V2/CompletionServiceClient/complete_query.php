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

// [START retail_v2_generated_CompletionService_CompleteQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\CompleteQueryResponse;
use Google\Cloud\Retail\V2\CompletionServiceClient;

/**
 * Completes the specified prefix with keyword suggestions.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 *
 * @param string $formattedCatalog Catalog for which the completion is performed.
 *
 *                                 Full resource name of catalog, such as
 *                                 `projects/&#42;/locations/global/catalogs/default_catalog`. Please see
 *                                 {@see CompletionServiceClient::catalogName()} for help formatting this field.
 * @param string $query            The query used to generate suggestions.
 *
 *                                 The maximum number of allowed characters is 255.
 */
function complete_query_sample(string $formattedCatalog, string $query): void
{
    // Create a client.
    $completionServiceClient = new CompletionServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var CompleteQueryResponse $response */
        $response = $completionServiceClient->completeQuery($formattedCatalog, $query);
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
    $formattedCatalog = CompletionServiceClient::catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
    $query = '[QUERY]';

    complete_query_sample($formattedCatalog, $query);
}
// [END retail_v2_generated_CompletionService_CompleteQuery_sync]
