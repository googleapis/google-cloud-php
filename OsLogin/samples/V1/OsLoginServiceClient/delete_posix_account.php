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

// [START oslogin_v1_generated_OsLoginService_DeletePosixAccount_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsLogin\V1\Client\OsLoginServiceClient;
use Google\Cloud\OsLogin\V1\DeletePosixAccountRequest;

/**
 * Deletes a POSIX account.
 *
 * @param string $formattedName A reference to the POSIX account to update. POSIX accounts are
 *                              identified by the project ID they are associated with. A reference to the
 *                              POSIX account is in format `users/{user}/projects/{project}`. Please see
 *                              {@see OsLoginServiceClient::posixAccountName()} for help formatting this field.
 */
function delete_posix_account_sample(string $formattedName): void
{
    // Create a client.
    $osLoginServiceClient = new OsLoginServiceClient();

    // Prepare the request message.
    $request = (new DeletePosixAccountRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $osLoginServiceClient->deletePosixAccount($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = OsLoginServiceClient::posixAccountName('[USER]', '[PROJECT]');

    delete_posix_account_sample($formattedName);
}
// [END oslogin_v1_generated_OsLoginService_DeletePosixAccount_sync]
