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

// [START appengine_v1_generated_Instances_DebugInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppEngine\V1\Instance;
use Google\Cloud\AppEngine\V1\InstancesClient;
use Google\Rpc\Status;

/**
 * Enables debugging on a VM instance. This allows you to use the SSH
 * command to connect to the virtual machine where the instance lives.
 * While in "debug mode", the instance continues to serve live traffic.
 * You should delete the instance when you are done debugging and then
 * allow the system to take over and determine if another instance
 * should be started.
 *
 * Only applicable for instances in App Engine flexible environment.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function debug_instance_sample(): void
{
    // Create a client.
    $instancesClient = new InstancesClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instancesClient->debugInstance();
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
// [END appengine_v1_generated_Instances_DebugInstance_sync]
