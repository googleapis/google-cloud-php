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

// [START alloydb_v1_generated_AlloyDBAdmin_UpdateUser_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AlloyDb\V1\Client\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\UpdateUserRequest;
use Google\Cloud\AlloyDb\V1\User;

/**
 * Updates the parameters of a single User.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_user_sample(): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare the request message.
    $user = new User();
    $request = (new UpdateUserRequest())
        ->setUser($user);

    // Call the API and handle any network failures.
    try {
        /** @var User $response */
        $response = $alloyDBAdminClient->updateUser($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END alloydb_v1_generated_AlloyDBAdmin_UpdateUser_sync]
