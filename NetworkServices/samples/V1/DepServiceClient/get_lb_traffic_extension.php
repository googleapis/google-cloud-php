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

// [START networkservices_v1_generated_DepService_GetLbTrafficExtension_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkServices\V1\DepServiceClient;
use Google\Cloud\NetworkServices\V1\LbTrafficExtension;

/**
 * Gets details of the specified `LbTrafficExtension` resource.
 *
 * @param string $formattedName A name of the `LbTrafficExtension` resource to get. Must be in
 *                              the format
 *                              `projects/{project}/locations/{location}/lbTrafficExtensions/{lb_traffic_extension}`. Please see
 *                              {@see DepServiceClient::lbTrafficExtensionName()} for help formatting this field.
 */
function get_lb_traffic_extension_sample(string $formattedName): void
{
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var LbTrafficExtension $response */
        $response = $depServiceClient->getLbTrafficExtension($formattedName);
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
    $formattedName = DepServiceClient::lbTrafficExtensionName(
        '[PROJECT]',
        '[LOCATION]',
        '[LB_TRAFFIC_EXTENSION]'
    );

    get_lb_traffic_extension_sample($formattedName);
}
// [END networkservices_v1_generated_DepService_GetLbTrafficExtension_sync]
