<?php
/*
 * Copyright 2026 Google LLC
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

// [START netapp_v1_generated_NetApp_StartSplit_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\StartSplitRequest;
use Google\Cloud\NetApp\V1\Volume;
use Google\Rpc\Status;

/**
 * Splits a clone volume from its source volume.
 * This operation will only work for volumes which have clone_details
 * set(clones).
 * For volumes that are not clones, this operation will return an error.
 *
 * @param string $formattedName The full name of the clone volume to be split from its source.
 *                              Format: projects/{project_number}/locations/{location}/volumes/{volume_id}
 *                              Please see {@see NetAppClient::volumeName()} for help formatting this field.
 */
function start_split_sample(string $formattedName): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $request = (new StartSplitRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->startSplit($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Volume $result */
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
    $formattedName = NetAppClient::volumeName('[PROJECT]', '[LOCATION]', '[VOLUME]');

    start_split_sample($formattedName);
}
// [END netapp_v1_generated_NetApp_StartSplit_sync]
