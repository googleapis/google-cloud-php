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

// [START admanager_v1_generated_UserService_UpdateUser_sync]
use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\Ads\AdManager\V1\UpdateUserRequest;
use Google\Ads\AdManager\V1\User;
use Google\ApiCore\ApiException;

/**
 * Updates a `User` object.
 *
 * @param string $userDisplayName   The name of the User. It has a maximum length of 128 characters.
 * @param string $userEmail         The email or login of the User. In order to create a new user,
 *                                  you must already have a Google Account.
 * @param string $formattedUserRole The unique Role ID of the User. Roles that are created by Google
 *                                  will have negative IDs. Please see
 *                                  {@see UserServiceClient::roleName()} for help formatting this field.
 */
function update_user_sample(
    string $userDisplayName,
    string $userEmail,
    string $formattedUserRole
): void {
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $user = (new User())
        ->setDisplayName($userDisplayName)
        ->setEmail($userEmail)
        ->setRole($formattedUserRole);
    $request = (new UpdateUserRequest())
        ->setUser($user);

    // Call the API and handle any network failures.
    try {
        /** @var User $response */
        $response = $userServiceClient->updateUser($request);
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
    $userDisplayName = '[DISPLAY_NAME]';
    $userEmail = '[EMAIL]';
    $formattedUserRole = UserServiceClient::roleName('[NETWORK_CODE]', '[ROLE]');

    update_user_sample($userDisplayName, $userEmail, $formattedUserRole);
}
// [END admanager_v1_generated_UserService_UpdateUser_sync]
