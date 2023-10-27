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

// [START spanner_v1_generated_InstanceAdmin_UpdateInstanceConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an instance config. The returned
 * [long-running operation][google.longrunning.Operation] can be used to track
 * the progress of updating the instance. If the named instance config does
 * not exist, returns `NOT_FOUND`.
 *
 * Only user managed configurations can be updated.
 *
 * Immediately after the request returns:
 *
 * * The instance config's
 * [reconciling][google.spanner.admin.instance.v1.InstanceConfig.reconciling]
 * field is set to true.
 *
 * While the operation is pending:
 *
 * * Cancelling the operation sets its metadata's
 * [cancel_time][google.spanner.admin.instance.v1.UpdateInstanceConfigMetadata.cancel_time].
 * The operation is guaranteed to succeed at undoing all changes, after
 * which point it terminates with a `CANCELLED` status.
 * * All other attempts to modify the instance config are rejected.
 * * Reading the instance config via the API continues to give the
 * pre-request values.
 *
 * Upon completion of the returned operation:
 *
 * * Creating instances using the instance configuration uses the new
 * values.
 * * The instance config's new values are readable via the API.
 * * The instance config's
 * [reconciling][google.spanner.admin.instance.v1.InstanceConfig.reconciling]
 * field becomes false.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format
 * `<instance_config_name>/operations/<operation_id>` and can be used to track
 * the instance config modification.  The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [UpdateInstanceConfigMetadata][google.spanner.admin.instance.v1.UpdateInstanceConfigMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig], if
 * successful.
 *
 * Authorization requires `spanner.instanceConfigs.update` permission on
 * the resource [name][google.spanner.admin.instance.v1.InstanceConfig.name].
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_instance_config_sample(): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $instanceConfig = new InstanceConfig();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->updateInstanceConfig($instanceConfig, $updateMask);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InstanceConfig $result */
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
// [END spanner_v1_generated_InstanceAdmin_UpdateInstanceConfig_sync]
