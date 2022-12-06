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

// [START file_v1_generated_CloudFilestoreManager_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Filestore\V1\CloudFilestoreManagerClient;
use Google\Cloud\Filestore\V1\Instance;
use Google\Rpc\Status;

/**
 * Creates an instance.
 * When creating from a backup, the capacity of the new instance needs to be
 * equal to or larger than the capacity of the backup (and also equal to or
 * larger than the minimum capacity of the tier).
 *
 * @param string $formattedParent The instance's project and location, in the format
 *                                `projects/{project_id}/locations/{location}`. In Cloud Filestore,
 *                                locations map to GCP zones, for example **us-west1-b**. Please see
 *                                {@see CloudFilestoreManagerClient::locationName()} for help formatting this field.
 * @param string $instanceId      The name of the instance to create.
 *                                The name must be unique for the specified project and location.
 */
function create_instance_sample(string $formattedParent, string $instanceId): void
{
    // Create a client.
    $cloudFilestoreManagerClient = new CloudFilestoreManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $instance = new Instance();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFilestoreManagerClient->createInstance($formattedParent, $instanceId, $instance);
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
    $formattedParent = CloudFilestoreManagerClient::locationName('[PROJECT]', '[LOCATION]');
    $instanceId = '[INSTANCE_ID]';

    create_instance_sample($formattedParent, $instanceId);
}
// [END file_v1_generated_CloudFilestoreManager_CreateInstance_sync]
