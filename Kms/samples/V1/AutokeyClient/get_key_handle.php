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

// [START cloudkms_v1_generated_Autokey_GetKeyHandle_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\AutokeyClient;
use Google\Cloud\Kms\V1\GetKeyHandleRequest;
use Google\Cloud\Kms\V1\KeyHandle;

/**
 * Returns the [KeyHandle][google.cloud.kms.v1.KeyHandle].
 *
 * @param string $formattedName Name of the [KeyHandle][google.cloud.kms.v1.KeyHandle] resource,
 *                              e.g.
 *                              `projects/{PROJECT_ID}/locations/{LOCATION}/keyHandles/{KEY_HANDLE_ID}`. Please see
 *                              {@see AutokeyClient::keyHandleName()} for help formatting this field.
 */
function get_key_handle_sample(string $formattedName): void
{
    // Create a client.
    $autokeyClient = new AutokeyClient();

    // Prepare the request message.
    $request = (new GetKeyHandleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var KeyHandle $response */
        $response = $autokeyClient->getKeyHandle($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = AutokeyClient::keyHandleName('[PROJECT]', '[LOCATION]', '[KEY_HANDLE]');

    get_key_handle_sample($formattedName);
}
// [END cloudkms_v1_generated_Autokey_GetKeyHandle_sync]
