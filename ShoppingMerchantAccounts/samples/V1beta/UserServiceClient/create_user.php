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

// [START merchantapi_v1beta_generated_UserService_CreateUser_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\Client\UserServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\CreateUserRequest;
use Google\Shopping\Merchant\Accounts\V1beta\User;

/**
 * Creates a Merchant Center account user. Executing this method requires
 * admin access.
 *
 * @param string $formattedParent The resource name of the account for which a user will be
 *                                created. Format: `accounts/{account}`
 *                                Please see {@see UserServiceClient::accountName()} for help formatting this field.
 * @param string $userId          The email address of the user (for example,
 *                                `john.doe&#64;gmail.com`).
 */
function create_user_sample(string $formattedParent, string $userId): void
{
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $user = new User();
    $request = (new CreateUserRequest())
        ->setParent($formattedParent)
        ->setUserId($userId)
        ->setUser($user);

    // Call the API and handle any network failures.
    try {
        /** @var User $response */
        $response = $userServiceClient->createUser($request);
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
    $formattedParent = UserServiceClient::accountName('[ACCOUNT]');
    $userId = '[USER_ID]';

    create_user_sample($formattedParent, $userId);
}
// [END merchantapi_v1beta_generated_UserService_CreateUser_sync]
