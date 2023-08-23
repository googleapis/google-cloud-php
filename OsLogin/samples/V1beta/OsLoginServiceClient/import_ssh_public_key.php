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

// [START oslogin_v1beta_generated_OsLoginService_ImportSshPublicKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsLogin\Common\SshPublicKey;
use Google\Cloud\OsLogin\V1beta\ImportSshPublicKeyResponse;
use Google\Cloud\OsLogin\V1beta\OsLoginServiceClient;

/**
 * Adds an SSH public key and returns the profile information. Default POSIX
 * account information is set when no username and UID exist as part of the
 * login profile.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function import_ssh_public_key_sample(): void
{
    // Create a client.
    $osLoginServiceClient = new OsLoginServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $sshPublicKey = new SshPublicKey();

    // Call the API and handle any network failures.
    try {
        /** @var ImportSshPublicKeyResponse $response */
        $response = $osLoginServiceClient->importSshPublicKey($sshPublicKey);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END oslogin_v1beta_generated_OsLoginService_ImportSshPublicKey_sync]
