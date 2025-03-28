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

// [START discoveryengine_v1_generated_ControlService_GetControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\ControlServiceClient;
use Google\Cloud\DiscoveryEngine\V1\Control;
use Google\Cloud\DiscoveryEngine\V1\GetControlRequest;

/**
 * Gets a Control.
 *
 * @param string $formattedName The resource name of the Control to get. Format:
 *                              `projects/{project}/locations/{location}/collections/{collection_id}/dataStores/{data_store_id}/controls/{control_id}`
 *                              Please see {@see ControlServiceClient::controlName()} for help formatting this field.
 */
function get_control_sample(string $formattedName): void
{
    // Create a client.
    $controlServiceClient = new ControlServiceClient();

    // Prepare the request message.
    $request = (new GetControlRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Control $response */
        $response = $controlServiceClient->getControl($request);
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
    $formattedName = ControlServiceClient::controlName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[CONTROL]'
    );

    get_control_sample($formattedName);
}
// [END discoveryengine_v1_generated_ControlService_GetControl_sync]
