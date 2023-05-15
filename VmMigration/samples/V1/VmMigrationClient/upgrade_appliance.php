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

// [START vmmigration_v1_generated_VmMigration_UpgradeAppliance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\UpgradeApplianceRequest;
use Google\Cloud\VMMigration\V1\UpgradeApplianceResponse;
use Google\Rpc\Status;

/**
 * Upgrades the appliance relate to this DatacenterConnector to the in-place
 * updateable version.
 *
 * @param string $formattedDatacenterConnector The DatacenterConnector name. Please see
 *                                             {@see VmMigrationClient::datacenterConnectorName()} for help formatting this field.
 */
function upgrade_appliance_sample(string $formattedDatacenterConnector): void
{
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $request = (new UpgradeApplianceRequest())
        ->setDatacenterConnector($formattedDatacenterConnector);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmMigrationClient->upgradeAppliance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var UpgradeApplianceResponse $result */
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
    $formattedDatacenterConnector = VmMigrationClient::datacenterConnectorName(
        '[PROJECT]',
        '[LOCATION]',
        '[SOURCE]',
        '[DATACENTER_CONNECTOR]'
    );

    upgrade_appliance_sample($formattedDatacenterConnector);
}
// [END vmmigration_v1_generated_VmMigration_UpgradeAppliance_sync]
