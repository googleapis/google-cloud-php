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

// [START spanner_v1_generated_InstanceAdmin_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Rpc\Status;

/**
 * Creates an instance and begins preparing it to begin serving. The
 * returned [long-running operation][google.longrunning.Operation]
 * can be used to track the progress of preparing the new
 * instance. The instance name is assigned by the caller. If the
 * named instance already exists, `CreateInstance` returns
 * `ALREADY_EXISTS`.
 *
 * Immediately upon completion of this request:
 *
 * * The instance is readable via the API, with all requested attributes
 * but no allocated resources. Its state is `CREATING`.
 *
 * Until completion of the returned operation:
 *
 * * Cancelling the operation renders the instance immediately unreadable
 * via the API.
 * * The instance can be deleted.
 * * All other attempts to modify the instance are rejected.
 *
 * Upon completion of the returned operation:
 *
 * * Billing for all successfully-allocated resources begins (some types
 * may have lower than the requested levels).
 * * Databases can be created in the instance.
 * * The instance's allocated resource levels are readable via the API.
 * * The instance's state becomes `READY`.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format `<instance_name>/operations/<operation_id>` and
 * can be used to track creation of the instance.  The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [CreateInstanceMetadata][google.spanner.admin.instance.v1.CreateInstanceMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [Instance][google.spanner.admin.instance.v1.Instance], if successful.
 *
 * @param string $formattedParent         The name of the project in which to create the instance. Values
 *                                        are of the form `projects/<project>`. Please see
 *                                        {@see InstanceAdminClient::projectName()} for help formatting this field.
 * @param string $instanceId              The ID of the instance to create.  Valid identifiers are of the
 *                                        form `[a-z][-a-z0-9]*[a-z0-9]` and must be between 2 and 64 characters in
 *                                        length.
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
function create_instance_sample(
    string $formattedParent,
    string $instanceId,
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

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceAdminClient->createInstance($formattedParent, $instanceId, $instance);
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
    $formattedParent = InstanceAdminClient::projectName('[PROJECT]');
    $instanceId = '[INSTANCE_ID]';
    $instanceName = '[NAME]';
    $formattedInstanceConfig = InstanceAdminClient::instanceConfigName(
        '[PROJECT]',
        '[INSTANCE_CONFIG]'
    );
    $instanceDisplayName = '[DISPLAY_NAME]';

    create_instance_sample(
        $formattedParent,
        $instanceId,
        $instanceName,
        $formattedInstanceConfig,
        $instanceDisplayName
    );
}
// [END spanner_v1_generated_InstanceAdmin_CreateInstance_sync]
