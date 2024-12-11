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

// [START spanner_v1_generated_InstanceAdmin_MoveInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\MoveInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\MoveInstanceResponse;
use Google\Rpc\Status;

/**
 * Moves an instance to the target instance configuration. You can use the
 * returned [long-running operation][google.longrunning.Operation] to track
 * the progress of moving the instance.
 *
 * `MoveInstance` returns `FAILED_PRECONDITION` if the instance meets any of
 * the following criteria:
 *
 * * Is undergoing a move to a different instance configuration
 * * Has backups
 * * Has an ongoing update
 * * Contains any CMEK-enabled databases
 * * Is a free trial instance
 *
 * While the operation is pending:
 *
 * * All other attempts to modify the instance, including changes to its
 * compute capacity, are rejected.
 * * The following database and backup admin operations are rejected:
 *
 * * `DatabaseAdmin.CreateDatabase`
 * * `DatabaseAdmin.UpdateDatabaseDdl` (disabled if default_leader is
 * specified in the request.)
 * * `DatabaseAdmin.RestoreDatabase`
 * * `DatabaseAdmin.CreateBackup`
 * * `DatabaseAdmin.CopyBackup`
 *
 * * Both the source and target instance configurations are subject to
 * hourly compute and storage charges.
 * * The instance might experience higher read-write latencies and a higher
 * transaction abort rate. However, moving an instance doesn't cause any
 * downtime.
 *
 * The returned [long-running operation][google.longrunning.Operation] has
 * a name of the format
 * `<instance_name>/operations/<operation_id>` and can be used to track
 * the move instance operation. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [MoveInstanceMetadata][google.spanner.admin.instance.v1.MoveInstanceMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [Instance][google.spanner.admin.instance.v1.Instance],
 * if successful.
 * Cancelling the operation sets its metadata's
 * [cancel_time][google.spanner.admin.instance.v1.MoveInstanceMetadata.cancel_time].
 * Cancellation is not immediate because it involves moving any data
 * previously moved to the target instance configuration back to the original
 * instance configuration. You can use this operation to track the progress of
 * the cancellation. Upon successful completion of the cancellation, the
 * operation terminates with `CANCELLED` status.
 *
 * If not cancelled, upon completion of the returned operation:
 *
 * * The instance successfully moves to the target instance
 * configuration.
 * * You are billed for compute and storage in target instance
 * configuration.
 *
 * Authorization requires the `spanner.instances.update` permission on
 * the resource [instance][google.spanner.admin.instance.v1.Instance].
 *
 * For more details, see
 * [Move an instance](https://cloud.google.com/spanner/docs/move-instance).
 *
 * @param string $formattedName         The instance to move.
 *                                      Values are of the form `projects/<project>/instances/<instance>`. Please see
 *                                      {@see InstanceAdminClient::instanceName()} for help formatting this field.
 * @param string $formattedTargetConfig The target instance configuration where to move the instance.
 *                                      Values are of the form `projects/<project>/instanceConfigs/<config>`. Please see
 *                                      {@see InstanceAdminClient::instanceConfigName()} for help formatting this field.
 */
function move_instance_sample(string $formattedName, string $formattedTargetConfig): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare the request message.
    $request = (new MoveInstanceRequest())
        ->setName($formattedName)
        ->setTargetConfig($formattedTargetConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->moveInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MoveInstanceResponse $result */
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
    $formattedName = InstanceAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $formattedTargetConfig = InstanceAdminClient::instanceConfigName('[PROJECT]', '[INSTANCE_CONFIG]');

    move_instance_sample($formattedName, $formattedTargetConfig);
}
// [END spanner_v1_generated_InstanceAdmin_MoveInstance_sync]
