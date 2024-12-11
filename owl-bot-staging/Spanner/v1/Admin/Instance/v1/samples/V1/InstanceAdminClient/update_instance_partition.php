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

// [START spanner_v1_generated_InstanceAdmin_UpdateInstancePartition_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstancePartition;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstancePartitionRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an instance partition, and begins allocating or releasing resources
 * as requested. The returned [long-running
 * operation][google.longrunning.Operation] can be used to track the
 * progress of updating the instance partition. If the named instance
 * partition does not exist, returns `NOT_FOUND`.
 *
 * Immediately upon completion of this request:
 *
 * * For resource types for which a decrease in the instance partition's
 * allocation has been requested, billing is based on the newly-requested
 * level.
 *
 * Until completion of the returned operation:
 *
 * * Cancelling the operation sets its metadata's
 * [cancel_time][google.spanner.admin.instance.v1.UpdateInstancePartitionMetadata.cancel_time],
 * and begins restoring resources to their pre-request values. The
 * operation is guaranteed to succeed at undoing all resource changes,
 * after which point it terminates with a `CANCELLED` status.
 * * All other attempts to modify the instance partition are rejected.
 * * Reading the instance partition via the API continues to give the
 * pre-request resource levels.
 *
 * Upon completion of the returned operation:
 *
 * * Billing begins for all successfully-allocated resources (some types
 * may have lower than the requested levels).
 * * All newly-reserved resources are available for serving the instance
 * partition's tables.
 * * The instance partition's new resource levels are readable via the API.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format
 * `<instance_partition_name>/operations/<operation_id>` and can be used to
 * track the instance partition modification. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [UpdateInstancePartitionMetadata][google.spanner.admin.instance.v1.UpdateInstancePartitionMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [InstancePartition][google.spanner.admin.instance.v1.InstancePartition], if
 * successful.
 *
 * Authorization requires `spanner.instancePartitions.update` permission on
 * the resource
 * [name][google.spanner.admin.instance.v1.InstancePartition.name].
 *
 * @param string $instancePartitionName            A unique identifier for the instance partition. Values are of the
 *                                                 form
 *                                                 `projects/<project>/instances/<instance>/instancePartitions/[a-z][-a-z0-9]*[a-z0-9]`.
 *                                                 The final segment of the name must be between 2 and 64 characters in
 *                                                 length. An instance partition's name cannot be changed after the instance
 *                                                 partition is created.
 * @param string $formattedInstancePartitionConfig The name of the instance partition's configuration. Values are of
 *                                                 the form `projects/<project>/instanceConfigs/<configuration>`. See also
 *                                                 [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig] and
 *                                                 [ListInstanceConfigs][google.spanner.admin.instance.v1.InstanceAdmin.ListInstanceConfigs]. Please see
 *                                                 {@see InstanceAdminClient::instanceConfigName()} for help formatting this field.
 * @param string $instancePartitionDisplayName     The descriptive name for this instance partition as it appears in
 *                                                 UIs. Must be unique per project and between 4 and 30 characters in length.
 */
function update_instance_partition_sample(
    string $instancePartitionName,
    string $formattedInstancePartitionConfig,
    string $instancePartitionDisplayName
): void {
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare the request message.
    $instancePartition = (new InstancePartition())
        ->setName($instancePartitionName)
        ->setConfig($formattedInstancePartitionConfig)
        ->setDisplayName($instancePartitionDisplayName);
    $fieldMask = new FieldMask();
    $request = (new UpdateInstancePartitionRequest())
        ->setInstancePartition($instancePartition)
        ->setFieldMask($fieldMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->updateInstancePartition($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InstancePartition $result */
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
    $instancePartitionName = '[NAME]';
    $formattedInstancePartitionConfig = InstanceAdminClient::instanceConfigName(
        '[PROJECT]',
        '[INSTANCE_CONFIG]'
    );
    $instancePartitionDisplayName = '[DISPLAY_NAME]';

    update_instance_partition_sample(
        $instancePartitionName,
        $formattedInstancePartitionConfig,
        $instancePartitionDisplayName
    );
}
// [END spanner_v1_generated_InstanceAdmin_UpdateInstancePartition_sync]
