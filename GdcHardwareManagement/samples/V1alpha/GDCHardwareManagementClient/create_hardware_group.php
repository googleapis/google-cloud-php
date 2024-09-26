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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateHardwareGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\CreateHardwareGroupRequest;
use Google\Cloud\GdcHardwareManagement\V1alpha\HardwareConfig;
use Google\Cloud\GdcHardwareManagement\V1alpha\HardwareGroup;
use Google\Cloud\GdcHardwareManagement\V1alpha\PowerSupply;
use Google\Rpc\Status;

/**
 * Creates a new hardware group in a given order.
 *
 * @param string $formattedParent                 The order to create the hardware group in.
 *                                                Format: `projects/{project}/locations/{location}/orders/{order}`
 *                                                Please see {@see GDCHardwareManagementClient::orderName()} for help formatting this field.
 * @param int    $hardwareGroupHardwareCount      Number of hardware in this HardwareGroup.
 * @param string $formattedHardwareGroupConfigSku Reference to the SKU for this hardware. This can point to a
 *                                                specific SKU revision in the form of `resource_name&#64;revision_id` as defined
 *                                                in [AIP-162](https://google.aip.dev/162). If no revision_id is specified,
 *                                                it refers to the latest revision. Please see
 *                                                {@see GDCHardwareManagementClient::skuName()} for help formatting this field.
 * @param int    $hardwareGroupConfigPowerSupply  Power supply type for this hardware.
 * @param string $formattedHardwareGroupSite      Name of the site where the hardware in this HardwareGroup will be
 *                                                delivered.
 *                                                Format: `projects/{project}/locations/{location}/sites/{site}`
 *                                                Please see {@see GDCHardwareManagementClient::siteName()} for help formatting this field.
 */
function create_hardware_group_sample(
    string $formattedParent,
    int $hardwareGroupHardwareCount,
    string $formattedHardwareGroupConfigSku,
    int $hardwareGroupConfigPowerSupply,
    string $formattedHardwareGroupSite
): void {
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $hardwareGroupConfig = (new HardwareConfig())
        ->setSku($formattedHardwareGroupConfigSku)
        ->setPowerSupply($hardwareGroupConfigPowerSupply);
    $hardwareGroup = (new HardwareGroup())
        ->setHardwareCount($hardwareGroupHardwareCount)
        ->setConfig($hardwareGroupConfig)
        ->setSite($formattedHardwareGroupSite);
    $request = (new CreateHardwareGroupRequest())
        ->setParent($formattedParent)
        ->setHardwareGroup($hardwareGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gDCHardwareManagementClient->createHardwareGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var HardwareGroup $result */
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
    $formattedParent = GDCHardwareManagementClient::orderName('[PROJECT]', '[LOCATION]', '[ORDER]');
    $hardwareGroupHardwareCount = 0;
    $formattedHardwareGroupConfigSku = GDCHardwareManagementClient::skuName(
        '[PROJECT]',
        '[LOCATION]',
        '[SKU]'
    );
    $hardwareGroupConfigPowerSupply = PowerSupply::POWER_SUPPLY_UNSPECIFIED;
    $formattedHardwareGroupSite = GDCHardwareManagementClient::siteName(
        '[PROJECT]',
        '[LOCATION]',
        '[SITE]'
    );

    create_hardware_group_sample(
        $formattedParent,
        $hardwareGroupHardwareCount,
        $formattedHardwareGroupConfigSku,
        $hardwareGroupConfigPowerSupply,
        $formattedHardwareGroupSite
    );
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateHardwareGroup_sync]
