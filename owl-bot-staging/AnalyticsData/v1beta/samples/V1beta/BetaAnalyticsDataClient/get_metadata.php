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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_GetMetadata_sync]
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\GetMetadataRequest;
use Google\Analytics\Data\V1beta\Metadata;
use Google\ApiCore\ApiException;

/**
 * Returns metadata for dimensions and metrics available in reporting methods.
 * Used to explore the dimensions and metrics. In this method, a Google
 * Analytics GA4 Property Identifier is specified in the request, and
 * the metadata response includes Custom dimensions and metrics as well as
 * Universal metadata.
 *
 * For example if a custom metric with parameter name `levels_unlocked` is
 * registered to a property, the Metadata response will contain
 * `customEvent:levels_unlocked`. Universal metadata are dimensions and
 * metrics applicable to any property such as `country` and `totalUsers`.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function get_metadata_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $request = new GetMetadataRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Metadata $response */
        $response = $betaAnalyticsDataClient->getMetadata($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_GetMetadata_sync]
