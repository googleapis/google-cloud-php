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

// [START parallelstore_v1beta_generated_Parallelstore_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Parallelstore\V1beta\Client\ParallelstoreClient;
use Google\Cloud\Parallelstore\V1beta\CreateInstanceRequest;
use Google\Cloud\Parallelstore\V1beta\Instance;
use Google\Rpc\Status;

/**
 * Creates a Parallelstore instance in a given project and location.
 *
 * @param string $formattedParent     The instance's project and location, in the format
 *                                    `projects/{project}/locations/{location}`.
 *                                    Locations map to Google Cloud zones; for example, `us-west1-b`. Please see
 *                                    {@see ParallelstoreClient::locationName()} for help formatting this field.
 * @param string $instanceId          The name of the Parallelstore instance.
 *
 *                                    * Must contain only lowercase letters, numbers, and hyphens.
 *                                    * Must start with a letter.
 *                                    * Must be between 1-63 characters.
 *                                    * Must end with a number or a letter.
 *                                    * Must be unique within the customer project / location
 * @param int    $instanceCapacityGib Immutable. The instance's storage capacity in Gibibytes (GiB).
 *                                    Allowed values are between 12000 and 100000, in multiples of 4000; e.g.,
 *                                    12000, 16000, 20000, ...
 */
function create_instance_sample(
    string $formattedParent,
    string $instanceId,
    int $instanceCapacityGib
): void {
    // Create a client.
    $parallelstoreClient = new ParallelstoreClient();

    // Prepare the request message.
    $instance = (new Instance())
        ->setCapacityGib($instanceCapacityGib);
    $request = (new CreateInstanceRequest())
        ->setParent($formattedParent)
        ->setInstanceId($instanceId)
        ->setInstance($instance);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $parallelstoreClient->createInstance($request);
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
    $formattedParent = ParallelstoreClient::locationName('[PROJECT]', '[LOCATION]');
    $instanceId = '[INSTANCE_ID]';
    $instanceCapacityGib = 0;

    create_instance_sample($formattedParent, $instanceId, $instanceCapacityGib);
}
// [END parallelstore_v1beta_generated_Parallelstore_CreateInstance_sync]
