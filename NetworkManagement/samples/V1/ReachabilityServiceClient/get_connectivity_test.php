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

// [START networkmanagement_v1_generated_ReachabilityService_GetConnectivityTest_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkManagement\V1\ConnectivityTest;
use Google\Cloud\NetworkManagement\V1\ReachabilityServiceClient;

/**
 * Gets the details of a specific Connectivity Test.
 *
 * @param string $name `ConnectivityTest` resource name using the form:
 *                     `projects/{project_id}/locations/global/connectivityTests/{test_id}`
 */
function get_connectivity_test_sample(string $name): void
{
    // Create a client.
    $reachabilityServiceClient = new ReachabilityServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ConnectivityTest $response */
        $response = $reachabilityServiceClient->getConnectivityTest($name);
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
    $name = '[NAME]';

    get_connectivity_test_sample($name);
}
// [END networkmanagement_v1_generated_ReachabilityService_GetConnectivityTest_sync]
