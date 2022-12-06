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

// [START analyticshub_v1beta1_generated_AnalyticsHubService_SubscribeListing_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataExchange\V1beta1\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\DataExchange\V1beta1\SubscribeListingResponse;

/**
 * Subscribes to a listing.
 *
 * Currently, with Analytics Hub, you can create listings that
 * reference only BigQuery datasets.
 * Upon subscription to a listing for a BigQuery dataset, Analytics Hub
 * creates a linked dataset in the subscriber's project.
 *
 * @param string $formattedName Resource name of the listing that you want to subscribe to.
 *                              e.g. `projects/myproject/locations/US/dataExchanges/123/listings/456`. Please see
 *                              {@see AnalyticsHubServiceClient::listingName()} for help formatting this field.
 */
function subscribe_listing_sample(string $formattedName): void
{
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var SubscribeListingResponse $response */
        $response = $analyticsHubServiceClient->subscribeListing($formattedName);
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
    $formattedName = AnalyticsHubServiceClient::listingName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]',
        '[LISTING]'
    );

    subscribe_listing_sample($formattedName);
}
// [END analyticshub_v1beta1_generated_AnalyticsHubService_SubscribeListing_sync]
