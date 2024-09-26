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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_UpdateHardware_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\Hardware;
use Google\Cloud\GdcHardwareManagement\V1alpha\HardwareConfig;
use Google\Cloud\GdcHardwareManagement\V1alpha\PowerSupply;
use Google\Cloud\GdcHardwareManagement\V1alpha\UpdateHardwareRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates hardware parameters.
 *
 * @param string $formattedHardwareOrder     Name of the order that this hardware belongs to.
 *                                           Format: `projects/{project}/locations/{location}/orders/{order}`
 *                                           Please see {@see GDCHardwareManagementClient::orderName()} for help formatting this field.
 * @param string $formattedHardwareSite      Name for the site that this hardware belongs to.
 *                                           Format: `projects/{project}/locations/{location}/sites/{site}`
 *                                           Please see {@see GDCHardwareManagementClient::siteName()} for help formatting this field.
 * @param string $formattedHardwareConfigSku Reference to the SKU for this hardware. This can point to a
 *                                           specific SKU revision in the form of `resource_name&#64;revision_id` as defined
 *                                           in [AIP-162](https://google.aip.dev/162). If no revision_id is specified,
 *                                           it refers to the latest revision. Please see
 *                                           {@see GDCHardwareManagementClient::skuName()} for help formatting this field.
 * @param int    $hardwareConfigPowerSupply  Power supply type for this hardware.
 * @param string $formattedHardwareZone      Name for the zone that this hardware belongs to.
 *                                           Format: `projects/{project}/locations/{location}/zones/{zone}`
 *                                           Please see {@see GDCHardwareManagementClient::zoneName()} for help formatting this field.
 */
function update_hardware_sample(
    string $formattedHardwareOrder,
    string $formattedHardwareSite,
    string $formattedHardwareConfigSku,
    int $hardwareConfigPowerSupply,
    string $formattedHardwareZone
): void {
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $hardwareConfig = (new HardwareConfig())
        ->setSku($formattedHardwareConfigSku)
        ->setPowerSupply($hardwareConfigPowerSupply);
    $hardware = (new Hardware())
        ->setOrder($formattedHardwareOrder)
        ->setSite($formattedHardwareSite)
        ->setConfig($hardwareConfig)
        ->setZone($formattedHardwareZone);
    $request = (new UpdateHardwareRequest())
        ->setUpdateMask($updateMask)
        ->setHardware($hardware);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gDCHardwareManagementClient->updateHardware($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Hardware $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedHardwareOrder = GDCHardwareManagementClient::orderName(
        '[PROJECT]',
        '[LOCATION]',
        '[ORDER]'
    );
    $formattedHardwareSite = GDCHardwareManagementClient::siteName('[PROJECT]', '[LOCATION]', '[SITE]');
    $formattedHardwareConfigSku = GDCHardwareManagementClient::skuName(
        '[PROJECT]',
        '[LOCATION]',
        '[SKU]'
    );
    $hardwareConfigPowerSupply = PowerSupply::POWER_SUPPLY_UNSPECIFIED;
    $formattedHardwareZone = GDCHardwareManagementClient::zoneName('[PROJECT]', '[LOCATION]', '[ZONE]');

    update_hardware_sample(
        $formattedHardwareOrder,
        $formattedHardwareSite,
        $formattedHardwareConfigSku,
        $hardwareConfigPowerSupply,
        $formattedHardwareZone
    );
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_UpdateHardware_sync]
