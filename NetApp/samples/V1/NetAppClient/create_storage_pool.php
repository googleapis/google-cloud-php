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

// [START netapp_v1_generated_NetApp_CreateStoragePool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateStoragePoolRequest;
use Google\Cloud\NetApp\V1\ServiceLevel;
use Google\Cloud\NetApp\V1\StoragePool;
use Google\Rpc\Status;

/**
 * Creates a new storage pool.
 *
 * @param string $formattedParent             Value for parent. Please see
 *                                            {@see NetAppClient::locationName()} for help formatting this field.
 * @param string $storagePoolId               Id of the requesting storage pool. Must be unique within the
 *                                            parent resource. Must contain only letters, numbers, underscore and hyphen,
 *                                            with the first character a letter or underscore, the last a letter or
 *                                            underscore or a number, and a 63 character maximum.
 * @param int    $storagePoolServiceLevel     Service level of the storage pool
 * @param int    $storagePoolCapacityGib      Capacity in GIB of the pool
 * @param string $formattedStoragePoolNetwork VPC Network name.
 *                                            Format: projects/{project}/global/networks/{network}
 *                                            Please see {@see NetAppClient::networkName()} for help formatting this field.
 */
function create_storage_pool_sample(
    string $formattedParent,
    string $storagePoolId,
    int $storagePoolServiceLevel,
    int $storagePoolCapacityGib,
    string $formattedStoragePoolNetwork
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $storagePool = (new StoragePool())
        ->setServiceLevel($storagePoolServiceLevel)
        ->setCapacityGib($storagePoolCapacityGib)
        ->setNetwork($formattedStoragePoolNetwork);
    $request = (new CreateStoragePoolRequest())
        ->setParent($formattedParent)
        ->setStoragePoolId($storagePoolId)
        ->setStoragePool($storagePool);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createStoragePool($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var StoragePool $result */
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
    $formattedParent = NetAppClient::locationName('[PROJECT]', '[LOCATION]');
    $storagePoolId = '[STORAGE_POOL_ID]';
    $storagePoolServiceLevel = ServiceLevel::SERVICE_LEVEL_UNSPECIFIED;
    $storagePoolCapacityGib = 0;
    $formattedStoragePoolNetwork = NetAppClient::networkName('[PROJECT]', '[NETWORK]');

    create_storage_pool_sample(
        $formattedParent,
        $storagePoolId,
        $storagePoolServiceLevel,
        $storagePoolCapacityGib,
        $formattedStoragePoolNetwork
    );
}
// [END netapp_v1_generated_NetApp_CreateStoragePool_sync]
