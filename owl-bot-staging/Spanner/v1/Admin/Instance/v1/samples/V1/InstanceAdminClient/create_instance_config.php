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

// [START spanner_v1_generated_InstanceAdmin_CreateInstanceConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Rpc\Status;

/**
 * Creates an instance config and begins preparing it to be used. The
 * returned [long-running operation][google.longrunning.Operation]
 * can be used to track the progress of preparing the new
 * instance config. The instance config name is assigned by the caller. If the
 * named instance config already exists, `CreateInstanceConfig` returns
 * `ALREADY_EXISTS`.
 *
 * Immediately after the request returns:
 *
 * * The instance config is readable via the API, with all requested
 * attributes. The instance config's
 * [reconciling][google.spanner.admin.instance.v1.InstanceConfig.reconciling]
 * field is set to true. Its state is `CREATING`.
 *
 * While the operation is pending:
 *
 * * Cancelling the operation renders the instance config immediately
 * unreadable via the API.
 * * Except for deleting the creating resource, all other attempts to modify
 * the instance config are rejected.
 *
 * Upon completion of the returned operation:
 *
 * * Instances can be created using the instance configuration.
 * * The instance config's
 * [reconciling][google.spanner.admin.instance.v1.InstanceConfig.reconciling]
 * field becomes false. Its state becomes `READY`.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format
 * `<instance_config_name>/operations/<operation_id>` and can be used to track
 * creation of the instance config. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [CreateInstanceConfigMetadata][google.spanner.admin.instance.v1.CreateInstanceConfigMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig], if
 * successful.
 *
 * Authorization requires `spanner.instanceConfigs.create` permission on
 * the resource
 * [parent][google.spanner.admin.instance.v1.CreateInstanceConfigRequest.parent].
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_instance_config_sample(): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare the request message.
    $request = new CreateInstanceConfigRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->createInstanceConfig($request);
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
// [END spanner_v1_generated_InstanceAdmin_CreateInstanceConfig_sync]
