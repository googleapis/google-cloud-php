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

// [START cloudiot_v1_generated_DeviceManager_BindDeviceToGateway_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iot\V1\BindDeviceToGatewayResponse;
use Google\Cloud\Iot\V1\DeviceManagerClient;

/**
 * Associates the device with the gateway.
 *
 * @param string $formattedParent The name of the registry. For example,
 *                                `projects/example-project/locations/us-central1/registries/my-registry`. Please see
 *                                {@see DeviceManagerClient::registryName()} for help formatting this field.
 * @param string $gatewayId       The value of `gateway_id` can be either the device numeric ID or the
 *                                user-defined device identifier.
 * @param string $deviceId        The device to associate with the specified gateway. The value of
 *                                `device_id` can be either the device numeric ID or the user-defined device
 *                                identifier.
 */
function bind_device_to_gateway_sample(
    string $formattedParent,
    string $gatewayId,
    string $deviceId
): void {
    // Create a client.
    $deviceManagerClient = new DeviceManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var BindDeviceToGatewayResponse $response */
        $response = $deviceManagerClient->bindDeviceToGateway($formattedParent, $gatewayId, $deviceId);
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
    $formattedParent = DeviceManagerClient::registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
    $gatewayId = '[GATEWAY_ID]';
    $deviceId = '[DEVICE_ID]';

    bind_device_to_gateway_sample($formattedParent, $gatewayId, $deviceId);
}
// [END cloudiot_v1_generated_DeviceManager_BindDeviceToGateway_sync]
