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

// [START spanner_v1_generated_InstanceAdmin_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an instance, and begins allocating or releasing resources
 * as requested. The returned [long-running
 * operation][google.longrunning.Operation] can be used to track the
 * progress of updating the instance. If the named instance does not
 * exist, returns `NOT_FOUND`.
 *
 * Immediately upon completion of this request:
 *
 * * For resource types for which a decrease in the instance's allocation
 * has been requested, billing is based on the newly-requested level.
 *
 * Until completion of the returned operation:
 *
 * * Cancelling the operation sets its metadata's
 * [cancel_time][google.spanner.admin.instance.v1.UpdateInstanceMetadata.cancel_time],
 * and begins restoring resources to their pre-request values. The
 * operation is guaranteed to succeed at undoing all resource changes,
 * after which point it terminates with a `CANCELLED` status.
 * * All other attempts to modify the instance are rejected.
 * * Reading the instance via the API continues to give the pre-request
 * resource levels.
 *
 * Upon completion of the returned operation:
 *
 * * Billing begins for all successfully-allocated resources (some types
 * may have lower than the requested levels).
 * * All newly-reserved resources are available for serving the instance's
 * tables.
 * * The instance's new resource levels are readable via the API.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format `<instance_name>/operations/<operation_id>` and
 * can be used to track the instance modification.  The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [UpdateInstanceMetadata][google.spanner.admin.instance.v1.UpdateInstanceMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [Instance][google.spanner.admin.instance.v1.Instance], if successful.
 *
 * Authorization requires `spanner.instances.update` permission on
 * the resource [name][google.spanner.admin.instance.v1.Instance.name].
 *
 * @param string $instanceName            A unique identifier for the instance, which cannot be changed
 *                                        after the instance is created. Values are of the form
 *                                        `projects/<project>/instances/[a-z][-a-z0-9]*[a-z0-9]`. The final
 *                                        segment of the name must be between 2 and 64 characters in length.
 * @param string $formattedInstanceConfig The name of the instance's configuration. Values are of the form
 *                                        `projects/<project>/instanceConfigs/<configuration>`. See
 *                                        also [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig] and
 *                                        [ListInstanceConfigs][google.spanner.admin.instance.v1.InstanceAdmin.ListInstanceConfigs]. Please see
 *                                        {@see InstanceAdminClient::instanceConfigName()} for help formatting this field.
 * @param string $instanceDisplayName     The descriptive name for this instance as it appears in UIs.
 *                                        Must be unique per project and between 4 and 30 characters in length.
 */
function update_instance_sample(
    string $instanceName,
    string $formattedInstanceConfig,
    string $instanceDisplayName
): void {
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $instance = (new Instance())
        ->setName($instanceName)
        ->setConfig($formattedInstanceConfig)
        ->setDisplayName($instanceDisplayName);
    $fieldMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->updateInstance($instance, $fieldMask);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $instanceName = '[NAME]';
    $formattedInstanceConfig = InstanceAdminClient::instanceConfigName(
        '[PROJECT]',
        '[INSTANCE_CONFIG]'
    );
    $instanceDisplayName = '[DISPLAY_NAME]';

    update_instance_sample($instanceName, $formattedInstanceConfig, $instanceDisplayName);
}
// [END spanner_v1_generated_InstanceAdmin_UpdateInstance_sync]
