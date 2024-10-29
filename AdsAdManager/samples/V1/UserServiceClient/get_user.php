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

// [START admanager_v1_generated_UserService_GetUser_sync]
use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\Ads\AdManager\V1\GetUserRequest;
use Google\Ads\AdManager\V1\User;
use Google\ApiCore\ApiException;

/**
 * API to retrieve a User object.
 *
 * To get the current user, the resource name
 * `networks/{networkCode}/users/me` can be used.
 *
 * @param string $formattedName The resource name of the User.
 *                              Format: `networks/{network_code}/users/{user_id}`
 *                              Please see {@see UserServiceClient::userName()} for help formatting this field.
 */
function get_user_sample(string $formattedName): void
{
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $request = (new GetUserRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var User $response */
        $response = $userServiceClient->getUser($request);
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
    $formattedName = UserServiceClient::userName('[NETWORK_CODE]', '[USER]');

    get_user_sample($formattedName);
}
// [END admanager_v1_generated_UserService_GetUser_sync]
