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

// [START dialogflow_v2_generated_EncryptionSpecService_InitializeEncryptionSpec_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\EncryptionSpecServiceClient;
use Google\Cloud\Dialogflow\V2\EncryptionSpec;
use Google\Cloud\Dialogflow\V2\InitializeEncryptionSpecRequest;
use Google\Cloud\Dialogflow\V2\InitializeEncryptionSpecResponse;
use Google\Rpc\Status;

/**
 * Initializes a location-level encryption key specification.  An error will
 * be thrown if the location has resources already created before the
 * initialization. Once the encryption specification is initialized at a
 * location, it is immutable and all newly created resources under the
 * location will be encrypted with the existing specification.
 *
 * @param string $encryptionSpecKmsKey The name of customer-managed encryption key that is used to
 *                                     secure a resource and its sub-resources. If empty, the resource is secured
 *                                     by the default Google encryption key. Only the key in the same location as
 *                                     this resource is allowed to be used for encryption. Format:
 *                                     `projects/{project}/locations/{location}/keyRings/{keyRing}/cryptoKeys/{key}`
 */
function initialize_encryption_spec_sample(string $encryptionSpecKmsKey): void
{
    // Create a client.
    $encryptionSpecServiceClient = new EncryptionSpecServiceClient();

    // Prepare the request message.
    $encryptionSpec = (new EncryptionSpec())
        ->setKmsKey($encryptionSpecKmsKey);
    $request = (new InitializeEncryptionSpecRequest())
        ->setEncryptionSpec($encryptionSpec);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $encryptionSpecServiceClient->initializeEncryptionSpec($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InitializeEncryptionSpecResponse $result */
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
    $encryptionSpecKmsKey = '[KMS_KEY]';

    initialize_encryption_spec_sample($encryptionSpecKmsKey);
}
// [END dialogflow_v2_generated_EncryptionSpecService_InitializeEncryptionSpec_sync]
