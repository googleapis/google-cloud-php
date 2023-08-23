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

// [START analyticshub_v1beta1_generated_AnalyticsHubService_GetDataExchange_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataExchange\V1beta1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\DataExchange\V1beta1\DataExchange;
use Google\Cloud\BigQuery\DataExchange\V1beta1\GetDataExchangeRequest;

/**
 * Gets the details of a data exchange.
 *
 * @param string $formattedName The resource name of the data exchange.
 *                              e.g. `projects/myproject/locations/US/dataExchanges/123`. Please see
 *                              {@see AnalyticsHubServiceClient::dataExchangeName()} for help formatting this field.
 */
function get_data_exchange_sample(string $formattedName): void
{
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $request = (new GetDataExchangeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DataExchange $response */
        $response = $analyticsHubServiceClient->getDataExchange($request);
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
    $formattedName = AnalyticsHubServiceClient::dataExchangeName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]'
    );

    get_data_exchange_sample($formattedName);
}
// [END analyticshub_v1beta1_generated_AnalyticsHubService_GetDataExchange_sync]
