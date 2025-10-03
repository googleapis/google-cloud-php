<?php
/*
 * Copyright 2025 Google LLC
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

// [START cloudlocationfinder_v1_generated_CloudLocationFinder_SearchCloudLocations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\LocationFinder\V1\Client\CloudLocationFinderClient;
use Google\Cloud\LocationFinder\V1\CloudLocation;
use Google\Cloud\LocationFinder\V1\SearchCloudLocationsRequest;

/**
 * Searches for cloud locations from a given source location.
 *
 * @param string $formattedParent              The parent, which owns this collection of cloud locations.
 *                                             Format: projects/{project}/locations/{location}
 *                                             Please see {@see CloudLocationFinderClient::locationName()} for help formatting this field.
 * @param string $formattedSourceCloudLocation The source cloud location to search from.
 *                                             Example search can be searching nearby cloud locations from the source
 *                                             cloud location by latency. Please see
 *                                             {@see CloudLocationFinderClient::cloudLocationName()} for help formatting this field.
 */
function search_cloud_locations_sample(
    string $formattedParent,
    string $formattedSourceCloudLocation
): void {
    // Create a client.
    $cloudLocationFinderClient = new CloudLocationFinderClient();

    // Prepare the request message.
    $request = (new SearchCloudLocationsRequest())
        ->setParent($formattedParent)
        ->setSourceCloudLocation($formattedSourceCloudLocation);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudLocationFinderClient->searchCloudLocations($request);

        /** @var CloudLocation $element */
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
    $formattedParent = CloudLocationFinderClient::locationName('[PROJECT]', '[LOCATION]');
    $formattedSourceCloudLocation = CloudLocationFinderClient::cloudLocationName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLOUD_LOCATION]'
    );

    search_cloud_locations_sample($formattedParent, $formattedSourceCloudLocation);
}
// [END cloudlocationfinder_v1_generated_CloudLocationFinder_SearchCloudLocations_sync]
