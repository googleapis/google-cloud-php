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

// [START apphub_v1_generated_AppHub_LookupDiscoveredWorkload_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\LookupDiscoveredWorkloadRequest;
use Google\Cloud\AppHub\V1\LookupDiscoveredWorkloadResponse;

/**
 * Lists a Discovered Workload in a host project and location, with a
 * given resource URI.
 *
 * @param string $formattedParent Host project ID and location to lookup Discovered Workload in.
 *                                Expected format: `projects/{project}/locations/{location}`. Please see
 *                                {@see AppHubClient::locationName()} for help formatting this field.
 * @param string $uri             Resource URI to find Discovered Workload for.
 *                                Accepts both project number and project ID and does translation when
 *                                needed.
 */
function lookup_discovered_workload_sample(string $formattedParent, string $uri): void
{
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $request = (new LookupDiscoveredWorkloadRequest())
        ->setParent($formattedParent)
        ->setUri($uri);

    // Call the API and handle any network failures.
    try {
        /** @var LookupDiscoveredWorkloadResponse $response */
        $response = $appHubClient->lookupDiscoveredWorkload($request);
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
    $formattedParent = AppHubClient::locationName('[PROJECT]', '[LOCATION]');
    $uri = '[URI]';

    lookup_discovered_workload_sample($formattedParent, $uri);
}
// [END apphub_v1_generated_AppHub_LookupDiscoveredWorkload_sync]
