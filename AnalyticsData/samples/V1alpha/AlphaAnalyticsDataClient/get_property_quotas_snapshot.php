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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetPropertyQuotasSnapshot_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\GetPropertyQuotasSnapshotRequest;
use Google\Analytics\Data\V1alpha\PropertyQuotasSnapshot;
use Google\ApiCore\ApiException;

/**
 * Get all property quotas organized by quota category for a given property.
 * This will charge 1 property quota from the category with the most quota.
 *
 * @param string $formattedName Quotas from this property will be listed in the response.
 *                              Format: `properties/{property}/propertyQuotasSnapshot`
 *                              Please see {@see AlphaAnalyticsDataClient::propertyQuotasSnapshotName()} for help formatting this field.
 */
function get_property_quotas_snapshot_sample(string $formattedName): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new GetPropertyQuotasSnapshotRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PropertyQuotasSnapshot $response */
        $response = $alphaAnalyticsDataClient->getPropertyQuotasSnapshot($request);
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
    $formattedName = AlphaAnalyticsDataClient::propertyQuotasSnapshotName('[PROPERTY]');

    get_property_quotas_snapshot_sample($formattedName);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetPropertyQuotasSnapshot_sync]
