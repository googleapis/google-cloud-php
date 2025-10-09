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

// [START parallelstore_v1_generated_Parallelstore_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Parallelstore\V1\Client\ParallelstoreClient;
use Google\Cloud\Parallelstore\V1\Instance;
use Google\Cloud\Parallelstore\V1\UpdateInstanceRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single instance.
 *
 * @param int $instanceCapacityGib Immutable. The instance's storage capacity in Gibibytes (GiB).
 *                                 Allowed values are between 12000 and 100000, in multiples of 4000; e.g.,
 *                                 12000, 16000, 20000, ...
 */
function update_instance_sample(int $instanceCapacityGib): void
{
    // Create a client.
    $parallelstoreClient = new ParallelstoreClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $instance = (new Instance())
        ->setCapacityGib($instanceCapacityGib);
    $request = (new UpdateInstanceRequest())
        ->setUpdateMask($updateMask)
        ->setInstance($instance);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $parallelstoreClient->updateInstance($request);
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
    $instanceCapacityGib = 0;

    update_instance_sample($instanceCapacityGib);
}
// [END parallelstore_v1_generated_Parallelstore_UpdateInstance_sync]
