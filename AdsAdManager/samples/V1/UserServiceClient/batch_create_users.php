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

// [START admanager_v1_generated_UserService_BatchCreateUsers_sync]
use Google\Ads\AdManager\V1\BatchCreateUsersRequest;
use Google\Ads\AdManager\V1\BatchCreateUsersResponse;
use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\Ads\AdManager\V1\CreateUserRequest;
use Google\Ads\AdManager\V1\User;
use Google\ApiCore\ApiException;

/**
 * Creates `User` objects.
 *
 * @param string $formattedParent           The parent resource where `Users` will be created.
 *                                          Format: `networks/{network_code}`
 *                                          The parent field in the CreateUserRequest must match this
 *                                          field. Please see
 *                                          {@see UserServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent   The parent resource where this `User` will be created.
 *                                          Format: `networks/{network_code}`
 *                                          Please see {@see UserServiceClient::networkName()} for help formatting this field.
 * @param string $requestsUserDisplayName   The name of the User. It has a maximum length of 128 characters.
 * @param string $requestsUserEmail         The email or login of the User. In order to create a new user,
 *                                          you must already have a Google Account.
 * @param string $formattedRequestsUserRole The unique Role ID of the User. Roles that are created by Google
 *                                          will have negative IDs. Please see
 *                                          {@see UserServiceClient::roleName()} for help formatting this field.
 */
function batch_create_users_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsUserDisplayName,
    string $requestsUserEmail,
    string $formattedRequestsUserRole
): void {
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $requestsUser = (new User())
        ->setDisplayName($requestsUserDisplayName)
        ->setEmail($requestsUserEmail)
        ->setRole($formattedRequestsUserRole);
    $createUserRequest = (new CreateUserRequest())
        ->setParent($formattedRequestsParent)
        ->setUser($requestsUser);
    $requests = [$createUserRequest,];
    $request = (new BatchCreateUsersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateUsersResponse $response */
        $response = $userServiceClient->batchCreateUsers($request);
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
    $formattedParent = UserServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = UserServiceClient::networkName('[NETWORK_CODE]');
    $requestsUserDisplayName = '[DISPLAY_NAME]';
    $requestsUserEmail = '[EMAIL]';
    $formattedRequestsUserRole = UserServiceClient::roleName('[NETWORK_CODE]', '[ROLE]');

    batch_create_users_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsUserDisplayName,
        $requestsUserEmail,
        $formattedRequestsUserRole
    );
}
// [END admanager_v1_generated_UserService_BatchCreateUsers_sync]
