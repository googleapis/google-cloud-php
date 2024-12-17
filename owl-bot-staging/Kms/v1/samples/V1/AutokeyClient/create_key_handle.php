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

// [START cloudkms_v1_generated_Autokey_CreateKeyHandle_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Kms\V1\Client\AutokeyClient;
use Google\Cloud\Kms\V1\CreateKeyHandleRequest;
use Google\Cloud\Kms\V1\KeyHandle;
use Google\Rpc\Status;

/**
 * Creates a new [KeyHandle][google.cloud.kms.v1.KeyHandle], triggering the
 * provisioning of a new [CryptoKey][google.cloud.kms.v1.CryptoKey] for CMEK
 * use with the given resource type in the configured key project and the same
 * location. [GetOperation][google.longrunning.Operations.GetOperation] should
 * be used to resolve the resulting long-running operation and get the
 * resulting [KeyHandle][google.cloud.kms.v1.KeyHandle] and
 * [CryptoKey][google.cloud.kms.v1.CryptoKey].
 *
 * @param string $formattedParent               Name of the resource project and location to create the
 *                                              [KeyHandle][google.cloud.kms.v1.KeyHandle] in, e.g.
 *                                              `projects/{PROJECT_ID}/locations/{LOCATION}`. Please see
 *                                              {@see AutokeyClient::locationName()} for help formatting this field.
 * @param string $keyHandleResourceTypeSelector Indicates the resource type that the resulting
 *                                              [CryptoKey][google.cloud.kms.v1.CryptoKey] is meant to protect, e.g.
 *                                              `{SERVICE}.googleapis.com/{TYPE}`. See documentation for supported resource
 *                                              types.
 */
function create_key_handle_sample(
    string $formattedParent,
    string $keyHandleResourceTypeSelector
): void {
    // Create a client.
    $autokeyClient = new AutokeyClient();

    // Prepare the request message.
    $keyHandle = (new KeyHandle())
        ->setResourceTypeSelector($keyHandleResourceTypeSelector);
    $request = (new CreateKeyHandleRequest())
        ->setParent($formattedParent)
        ->setKeyHandle($keyHandle);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autokeyClient->createKeyHandle($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var KeyHandle $result */
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
    $formattedParent = AutokeyClient::locationName('[PROJECT]', '[LOCATION]');
    $keyHandleResourceTypeSelector = '[RESOURCE_TYPE_SELECTOR]';

    create_key_handle_sample($formattedParent, $keyHandleResourceTypeSelector);
}
// [END cloudkms_v1_generated_Autokey_CreateKeyHandle_sync]
