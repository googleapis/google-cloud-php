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

// [START analyticshub_v1_generated_AnalyticsHubService_SubscribeDataExchange_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BigQuery\AnalyticsHub\V1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\AnalyticsHub\V1\SubscribeDataExchangeRequest;
use Google\Cloud\BigQuery\AnalyticsHub\V1\SubscribeDataExchangeResponse;
use Google\Rpc\Status;

/**
 * Creates a Subscription to a Data Exchange. This is a long-running operation
 * as it will create one or more linked datasets.
 *
 * @param string $formattedName        Resource name of the Data Exchange.
 *                                     e.g. `projects/publisherproject/locations/US/dataExchanges/123`
 *                                     Please see {@see AnalyticsHubServiceClient::dataExchangeName()} for help formatting this field.
 * @param string $formattedDestination The parent resource path of the Subscription.
 *                                     e.g. `projects/subscriberproject/locations/US`
 *                                     Please see {@see AnalyticsHubServiceClient::locationName()} for help formatting this field.
 * @param string $subscription         Name of the subscription to create.
 *                                     e.g. `subscription1`
 */
function subscribe_data_exchange_sample(
    string $formattedName,
    string $formattedDestination,
    string $subscription
): void {
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $request = (new SubscribeDataExchangeRequest())
        ->setName($formattedName)
        ->setDestination($formattedDestination)
        ->setSubscription($subscription);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $analyticsHubServiceClient->subscribeDataExchange($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SubscribeDataExchangeResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedName = AnalyticsHubServiceClient::dataExchangeName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]'
    );
    $formattedDestination = AnalyticsHubServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $subscription = '[SUBSCRIPTION]';

    subscribe_data_exchange_sample($formattedName, $formattedDestination, $subscription);
}
// [END analyticshub_v1_generated_AnalyticsHubService_SubscribeDataExchange_sync]
