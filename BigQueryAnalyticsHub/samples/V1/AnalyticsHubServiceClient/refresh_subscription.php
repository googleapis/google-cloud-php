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

// [START analyticshub_v1_generated_AnalyticsHubService_RefreshSubscription_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BigQuery\AnalyticsHub\V1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\AnalyticsHub\V1\RefreshSubscriptionRequest;
use Google\Cloud\BigQuery\AnalyticsHub\V1\RefreshSubscriptionResponse;
use Google\Rpc\Status;

/**
 * Refreshes a Subscription to a Data Exchange. A Data Exchange can become
 * stale when a publisher adds or removes data. This is a long-running
 * operation as it may create many linked datasets.
 *
 * @param string $formattedName Resource name of the Subscription to refresh.
 *                              e.g. `projects/subscriberproject/locations/US/subscriptions/123`
 *                              Please see {@see AnalyticsHubServiceClient::subscriptionName()} for help formatting this field.
 */
function refresh_subscription_sample(string $formattedName): void
{
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $request = (new RefreshSubscriptionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $analyticsHubServiceClient->refreshSubscription($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RefreshSubscriptionResponse $result */
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
    $formattedName = AnalyticsHubServiceClient::subscriptionName(
        '[PROJECT]',
        '[LOCATION]',
        '[SUBSCRIPTION]'
    );

    refresh_subscription_sample($formattedName);
}
// [END analyticshub_v1_generated_AnalyticsHubService_RefreshSubscription_sync]
