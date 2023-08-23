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

// [START oslogin_v1beta_generated_OsLoginService_SignSshPublicKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsLogin\V1beta\OsLoginServiceClient;
use Google\Cloud\OsLogin\V1beta\SignSshPublicKeyResponse;

/**
 * Signs an SSH public key for a user to authenticate to an instance.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function sign_ssh_public_key_sample(): void
{
    // Create a client.
    $osLoginServiceClient = new OsLoginServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var SignSshPublicKeyResponse $response */
        $response = $osLoginServiceClient->signSshPublicKey();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END oslogin_v1beta_generated_OsLoginService_SignSshPublicKey_sync]
