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

// [START file_v1_generated_CloudFilestoreManager_RestoreInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Filestore\V1\Client\CloudFilestoreManagerClient;
use Google\Cloud\Filestore\V1\Instance;
use Google\Cloud\Filestore\V1\RestoreInstanceRequest;
use Google\Rpc\Status;

/**
 * Restores an existing instance's file share from a backup.
 *
 * The capacity of the instance needs to be equal to or larger than the
 * capacity of the backup (and also equal to or larger than the minimum
 * capacity of the tier).
 *
 * @param string $formattedName The resource name of the instance, in the format
 *                              `projects/{project_number}/locations/{location_id}/instances/{instance_id}`. Please see
 *                              {@see CloudFilestoreManagerClient::instanceName()} for help formatting this field.
 * @param string $fileShare     Name of the file share in the Filestore instance that the backup
 *                              is being restored to.
 */
function restore_instance_sample(string $formattedName, string $fileShare): void
{
    // Create a client.
    $cloudFilestoreManagerClient = new CloudFilestoreManagerClient();

    // Prepare the request message.
    $request = (new RestoreInstanceRequest())
        ->setName($formattedName)
        ->setFileShare($fileShare);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFilestoreManagerClient->restoreInstance($request);
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
    $formattedName = CloudFilestoreManagerClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $fileShare = '[FILE_SHARE]';

    restore_instance_sample($formattedName, $fileShare);
}
// [END file_v1_generated_CloudFilestoreManager_RestoreInstance_sync]
