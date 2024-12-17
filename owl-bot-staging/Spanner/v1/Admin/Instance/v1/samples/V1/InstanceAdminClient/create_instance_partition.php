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

// [START spanner_v1_generated_InstanceAdmin_CreateInstancePartition_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstancePartitionRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstancePartition;
use Google\Rpc\Status;

/**
 * Creates an instance partition and begins preparing it to be used. The
 * returned long-running operation
 * can be used to track the progress of preparing the new instance partition.
 * The instance partition name is assigned by the caller. If the named
 * instance partition already exists, `CreateInstancePartition` returns
 * `ALREADY_EXISTS`.
 *
 * Immediately upon completion of this request:
 *
 * * The instance partition is readable via the API, with all requested
 * attributes but no allocated resources. Its state is `CREATING`.
 *
 * Until completion of the returned operation:
 *
 * * Cancelling the operation renders the instance partition immediately
 * unreadable via the API.
 * * The instance partition can be deleted.
 * * All other attempts to modify the instance partition are rejected.
 *
 * Upon completion of the returned operation:
 *
 * * Billing for all successfully-allocated resources begins (some types
 * may have lower than the requested levels).
 * * Databases can start using this instance partition.
 * * The instance partition's allocated resource levels are readable via the
 * API.
 * * The instance partition's state becomes `READY`.
 *
 * The returned long-running operation will
 * have a name of the format
 * `<instance_partition_name>/operations/<operation_id>` and can be used to
 * track creation of the instance partition.  The
 * metadata field type is
 * [CreateInstancePartitionMetadata][google.spanner.admin.instance.v1.CreateInstancePartitionMetadata].
 * The response field type is
 * [InstancePartition][google.spanner.admin.instance.v1.InstancePartition], if
 * successful.
 *
 * @param string $formattedParent                  The name of the instance in which to create the instance
 *                                                 partition. Values are of the form
 *                                                 `projects/<project>/instances/<instance>`. Please see
 *                                                 {@see InstanceAdminClient::instanceName()} for help formatting this field.
 * @param string $instancePartitionId              The ID of the instance partition to create. Valid identifiers are
 *                                                 of the form `[a-z][-a-z0-9]*[a-z0-9]` and must be between 2 and 64
 *                                                 characters in length.
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
function create_instance_partition_sample(
    string $formattedParent,
    string $instancePartitionId,
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
    $request = (new CreateInstancePartitionRequest())
        ->setParent($formattedParent)
        ->setInstancePartitionId($instancePartitionId)
        ->setInstancePartition($instancePartition);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->createInstancePartition($request);
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
    $formattedParent = InstanceAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $instancePartitionId = '[INSTANCE_PARTITION_ID]';
    $instancePartitionName = '[NAME]';
    $formattedInstancePartitionConfig = InstanceAdminClient::instanceConfigName(
        '[PROJECT]',
        '[INSTANCE_CONFIG]'
    );
    $instancePartitionDisplayName = '[DISPLAY_NAME]';

    create_instance_partition_sample(
        $formattedParent,
        $instancePartitionId,
        $instancePartitionName,
        $formattedInstancePartitionConfig,
        $instancePartitionDisplayName
    );
}
// [END spanner_v1_generated_InstanceAdmin_CreateInstancePartition_sync]
