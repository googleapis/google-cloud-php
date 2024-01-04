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

// [START oslogin_v1_generated_OsLoginService_UpdateSshPublicKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsLogin\Common\SshPublicKey;
use Google\Cloud\OsLogin\V1\Client\OsLoginServiceClient;
use Google\Cloud\OsLogin\V1\UpdateSshPublicKeyRequest;

/**
 * Updates an SSH public key and returns the profile information. This method
 * supports patch semantics.
 *
 * @param string $formattedName The fingerprint of the public key to update. Public keys are
 *                              identified by their SHA-256 fingerprint. The fingerprint of the public key
 *                              is in format `users/{user}/sshPublicKeys/{fingerprint}`. Please see
 *                              {@see OsLoginServiceClient::sshPublicKeyName()} for help formatting this field.
 */
function update_ssh_public_key_sample(string $formattedName): void
{
    // Create a client.
    $osLoginServiceClient = new OsLoginServiceClient();

    // Prepare the request message.
    $sshPublicKey = new SshPublicKey();
    $request = (new UpdateSshPublicKeyRequest())
        ->setName($formattedName)
        ->setSshPublicKey($sshPublicKey);

    // Call the API and handle any network failures.
    try {
        /** @var SshPublicKey $response */
        $response = $osLoginServiceClient->updateSshPublicKey($request);
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
    $formattedName = OsLoginServiceClient::sshPublicKeyName('[USER]', '[FINGERPRINT]');

    update_ssh_public_key_sample($formattedName);
}
// [END oslogin_v1_generated_OsLoginService_UpdateSshPublicKey_sync]
