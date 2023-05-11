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

// [START analyticshub_v1beta1_generated_AnalyticsHubService_ListDataExchanges_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BigQuery\DataExchange\V1beta1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\DataExchange\V1beta1\DataExchange;
use Google\Cloud\BigQuery\DataExchange\V1beta1\ListDataExchangesRequest;

/**
 * Lists all data exchanges in a given project and location.
 *
 * @param string $formattedParent The parent resource path of the data exchanges.
 *                                e.g. `projects/myproject/locations/US`. Please see
 *                                {@see AnalyticsHubServiceClient::locationName()} for help formatting this field.
 */
function list_data_exchanges_sample(string $formattedParent): void
{
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $request = (new ListDataExchangesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $analyticsHubServiceClient->listDataExchanges($request);

        /** @var DataExchange $element */
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
    $formattedParent = AnalyticsHubServiceClient::locationName('[PROJECT]', '[LOCATION]');

    list_data_exchanges_sample($formattedParent);
}
// [END analyticshub_v1beta1_generated_AnalyticsHubService_ListDataExchanges_sync]
