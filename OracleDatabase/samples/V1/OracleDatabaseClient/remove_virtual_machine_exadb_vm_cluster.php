<?php
/*
 * Copyright 2025 Google LLC
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

// [START oracledatabase_v1_generated_OracleDatabase_RemoveVirtualMachineExadbVmCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\ExadbVmCluster;
use Google\Cloud\OracleDatabase\V1\RemoveVirtualMachineExadbVmClusterRequest;
use Google\Rpc\Status;

/**
 * Removes virtual machines from an existing exadb vm cluster.
 *
 * @param string $formattedName    The name of the ExadbVmCluster in the following format:
 *                                 projects/{project}/locations/{location}/exadbVmClusters/{exadb_vm_cluster}. Please see
 *                                 {@see OracleDatabaseClient::exadbVmClusterName()} for help formatting this field.
 * @param string $hostnamesElement The list of host names of db nodes to be removed from the
 *                                 ExadbVmCluster.
 */
function remove_virtual_machine_exadb_vm_cluster_sample(
    string $formattedName,
    string $hostnamesElement
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $hostnames = [$hostnamesElement,];
    $request = (new RemoveVirtualMachineExadbVmClusterRequest())
        ->setName($formattedName)
        ->setHostnames($hostnames);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->removeVirtualMachineExadbVmCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExadbVmCluster $result */
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
    $formattedName = OracleDatabaseClient::exadbVmClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[EXADB_VM_CLUSTER]'
    );
    $hostnamesElement = '[HOSTNAMES]';

    remove_virtual_machine_exadb_vm_cluster_sample($formattedName, $hostnamesElement);
}
// [END oracledatabase_v1_generated_OracleDatabase_RemoveVirtualMachineExadbVmCluster_sync]
