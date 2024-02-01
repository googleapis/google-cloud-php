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

// [START cloudiot_v1_generated_DeviceManager_SendCommandToDevice_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iot\V1\Client\DeviceManagerClient;
use Google\Cloud\Iot\V1\SendCommandToDeviceRequest;
use Google\Cloud\Iot\V1\SendCommandToDeviceResponse;

/**
 * Sends a command to the specified device. In order for a device to be able
 * to receive commands, it must:
 * 1) be connected to Cloud IoT Core using the MQTT protocol, and
 * 2) be subscribed to the group of MQTT topics specified by
 * /devices/{device-id}/commands/#. This subscription will receive commands
 * at the top-level topic /devices/{device-id}/commands as well as commands
 * for subfolders, like /devices/{device-id}/commands/subfolder.
 * Note that subscribing to specific subfolders is not supported.
 * If the command could not be delivered to the device, this method will
 * return an error; in particular, if the device is not subscribed, this
 * method will return FAILED_PRECONDITION. Otherwise, this method will
 * return OK. If the subscription is QoS 1, at least once delivery will be
 * guaranteed; for QoS 0, no acknowledgment will be expected from the device.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function send_command_to_device_sample(): void
{
    // Create a client.
    $deviceManagerClient = new DeviceManagerClient();

    // Prepare the request message.
    $request = new SendCommandToDeviceRequest();

    // Call the API and handle any network failures.
    try {
        /** @var SendCommandToDeviceResponse $response */
        $response = $deviceManagerClient->sendCommandToDevice($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudiot_v1_generated_DeviceManager_SendCommandToDevice_sync]
