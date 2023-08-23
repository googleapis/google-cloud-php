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

// [START analyticshub_v1beta1_generated_AnalyticsHubService_CreateListing_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataExchange\V1beta1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\DataExchange\V1beta1\CreateListingRequest;
use Google\Cloud\BigQuery\DataExchange\V1beta1\Listing;
use Google\Cloud\BigQuery\DataExchange\V1beta1\Listing\BigQueryDatasetSource;

/**
 * Creates a new listing.
 *
 * @param string $formattedParent    The parent resource path of the listing.
 *                                   e.g. `projects/myproject/locations/US/dataExchanges/123`. Please see
 *                                   {@see AnalyticsHubServiceClient::dataExchangeName()} for help formatting this field.
 * @param string $listingId          The ID of the listing to create.
 *                                   Must contain only Unicode letters, numbers (0-9), underscores (_).
 *                                   Should not use characters that require URL-escaping, or characters
 *                                   outside of ASCII, spaces.
 *                                   Max length: 100 bytes.
 * @param string $listingDisplayName Human-readable display name of the listing. The display name must contain
 *                                   only Unicode letters, numbers (0-9), underscores (_), dashes (-), spaces
 *                                   ( ), ampersands (&) and can't start or end with spaces.
 *                                   Default value is an empty string.
 *                                   Max length: 63 bytes.
 */
function create_listing_sample(
    string $formattedParent,
    string $listingId,
    string $listingDisplayName
): void {
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $listingBigqueryDataset = new BigQueryDatasetSource();
    $listing = (new Listing())
        ->setBigqueryDataset($listingBigqueryDataset)
        ->setDisplayName($listingDisplayName);
    $request = (new CreateListingRequest())
        ->setParent($formattedParent)
        ->setListingId($listingId)
        ->setListing($listing);

    // Call the API and handle any network failures.
    try {
        /** @var Listing $response */
        $response = $analyticsHubServiceClient->createListing($request);
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
    $formattedParent = AnalyticsHubServiceClient::dataExchangeName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]'
    );
    $listingId = '[LISTING_ID]';
    $listingDisplayName = '[DISPLAY_NAME]';

    create_listing_sample($formattedParent, $listingId, $listingDisplayName);
}
// [END analyticshub_v1beta1_generated_AnalyticsHubService_CreateListing_sync]
