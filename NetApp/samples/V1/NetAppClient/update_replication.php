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

// [START netapp_v1_generated_NetApp_UpdateReplication_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\DestinationVolumeParameters;
use Google\Cloud\NetApp\V1\Replication;
use Google\Cloud\NetApp\V1\Replication\ReplicationSchedule;
use Google\Cloud\NetApp\V1\UpdateReplicationRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the settings of a specific replication.
 *
 * @param int    $replicationReplicationSchedule                             Indicates the schedule for replication.
 * @param string $formattedReplicationDestinationVolumeParametersStoragePool Existing destination StoragePool name. Please see
 *                                                                           {@see NetAppClient::storagePoolName()} for help formatting this field.
 */
function update_replication_sample(
    int $replicationReplicationSchedule,
    string $formattedReplicationDestinationVolumeParametersStoragePool
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $replicationDestinationVolumeParameters = (new DestinationVolumeParameters())
        ->setStoragePool($formattedReplicationDestinationVolumeParametersStoragePool);
    $replication = (new Replication())
        ->setReplicationSchedule($replicationReplicationSchedule)
        ->setDestinationVolumeParameters($replicationDestinationVolumeParameters);
    $request = (new UpdateReplicationRequest())
        ->setUpdateMask($updateMask)
        ->setReplication($replication);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->updateReplication($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Replication $result */
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
    $replicationReplicationSchedule = ReplicationSchedule::REPLICATION_SCHEDULE_UNSPECIFIED;
    $formattedReplicationDestinationVolumeParametersStoragePool = NetAppClient::storagePoolName(
        '[PROJECT]',
        '[LOCATION]',
        '[STORAGE_POOL]'
    );

    update_replication_sample(
        $replicationReplicationSchedule,
        $formattedReplicationDestinationVolumeParametersStoragePool
    );
}
// [END netapp_v1_generated_NetApp_UpdateReplication_sync]
