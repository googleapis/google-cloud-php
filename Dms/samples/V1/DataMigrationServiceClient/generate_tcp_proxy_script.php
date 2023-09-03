<?php
/*
 * Copyright 2023 Google LLC
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

// [START datamigration_v1_generated_DataMigrationService_GenerateTcpProxyScript_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\TcpProxyScript;

/**
 * Generate a TCP Proxy configuration script to configure a cloud-hosted VM
 * running a TCP Proxy.
 *
 * @param string $vmName        The name of the Compute instance that will host the proxy.
 * @param string $vmMachineType The type of the Compute instance that will host the proxy.
 * @param string $vmSubnet      The name of the subnet the Compute instance will use for private
 *                              connectivity. Must be supplied in the form of
 *                              projects/{project}/regions/{region}/subnetworks/{subnetwork}.
 *                              Note: the region for the subnet must match the Compute instance region.
 */
function generate_tcp_proxy_script_sample(
    string $vmName,
    string $vmMachineType,
    string $vmSubnet
): void {
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var TcpProxyScript $response */
        $response = $dataMigrationServiceClient->generateTcpProxyScript($vmName, $vmMachineType, $vmSubnet);
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
    $vmName = '[VM_NAME]';
    $vmMachineType = '[VM_MACHINE_TYPE]';
    $vmSubnet = '[VM_SUBNET]';

    generate_tcp_proxy_script_sample($vmName, $vmMachineType, $vmSubnet);
}
// [END datamigration_v1_generated_DataMigrationService_GenerateTcpProxyScript_sync]
