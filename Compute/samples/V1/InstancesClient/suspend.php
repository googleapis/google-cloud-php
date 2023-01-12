<?php
/*
 * Copyright 2022 Google LLC
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

// [START compute_v1_generated_Instances_Suspend_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\InstancesClient;
use Google\Rpc\Status;

/**
 * This method suspends a running instance, saving its state to persistent storage, and allows you to resume the instance at a later time. Suspended instances have no compute costs (cores or RAM), and incur only storage charges for the saved VM memory and localSSD data. Any charged resources the virtual machine was using, such as persistent disks and static IP addresses, will continue to be charged while the instance is suspended. For more information, see Suspending and resuming an instance.
 *
 * @param string $instance Name of the instance resource to suspend.
 * @param string $project  Project ID for this request.
 * @param string $zone     The name of the zone for this request.
 */
function suspend_sample(string $instance, string $project, string $zone): void
{
    // Create a client.
    $instancesClient = new InstancesClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instancesClient->suspend($instance, $project, $zone);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $instance = '[INSTANCE]';
    $project = '[PROJECT]';
    $zone = '[ZONE]';

    suspend_sample($instance, $project, $zone);
}
// [END compute_v1_generated_Instances_Suspend_sync]
