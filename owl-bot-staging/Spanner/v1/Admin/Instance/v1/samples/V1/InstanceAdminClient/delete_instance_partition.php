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

// [START spanner_v1_generated_InstanceAdmin_DeleteInstancePartition_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstancePartitionRequest;

/**
 * Deletes an existing instance partition. Requires that the
 * instance partition is not used by any database or backup and is not the
 * default instance partition of an instance.
 *
 * Authorization requires `spanner.instancePartitions.delete` permission on
 * the resource
 * [name][google.spanner.admin.instance.v1.InstancePartition.name].
 *
 * @param string $formattedName The name of the instance partition to be deleted.
 *                              Values are of the form
 *                              `projects/{project}/instances/{instance}/instancePartitions/{instance_partition}`
 *                              Please see {@see InstanceAdminClient::instancePartitionName()} for help formatting this field.
 */
function delete_instance_partition_sample(string $formattedName): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Prepare the request message.
    $request = (new DeleteInstancePartitionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $instanceAdminClient->deleteInstancePartition($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = InstanceAdminClient::instancePartitionName(
        '[PROJECT]',
        '[INSTANCE]',
        '[INSTANCE_PARTITION]'
    );

    delete_instance_partition_sample($formattedName);
}
// [END spanner_v1_generated_InstanceAdmin_DeleteInstancePartition_sync]
