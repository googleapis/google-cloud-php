<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_DeviceManufacturerService_GetDeviceManufacturer_sync]
use Google\Ads\AdManager\V1\Client\DeviceManufacturerServiceClient;
use Google\Ads\AdManager\V1\DeviceManufacturer;
use Google\Ads\AdManager\V1\GetDeviceManufacturerRequest;
use Google\ApiCore\ApiException;

/**
 * API to retrieve a `DeviceManufacturer` object.
 *
 * @param string $formattedName The resource name of the DeviceManufacturer.
 *                              Format:
 *                              `networks/{network_code}/deviceManufacturers/{device_manufacturer_id}`
 *                              Please see {@see DeviceManufacturerServiceClient::deviceManufacturerName()} for help formatting this field.
 */
function get_device_manufacturer_sample(string $formattedName): void
{
    // Create a client.
    $deviceManufacturerServiceClient = new DeviceManufacturerServiceClient();

    // Prepare the request message.
    $request = (new GetDeviceManufacturerRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DeviceManufacturer $response */
        $response = $deviceManufacturerServiceClient->getDeviceManufacturer($request);
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
    $formattedName = DeviceManufacturerServiceClient::deviceManufacturerName(
        '[NETWORK_CODE]',
        '[DEVICE_MANUFACTURER]'
    );

    get_device_manufacturer_sample($formattedName);
}
// [END admanager_v1_generated_DeviceManufacturerService_GetDeviceManufacturer_sync]
