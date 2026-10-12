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

// [START admanager_v1_generated_UserService_BatchUpdateUsers_sync]
use Google\Ads\AdManager\V1\BatchUpdateUsersRequest;
use Google\Ads\AdManager\V1\BatchUpdateUsersResponse;
use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\Ads\AdManager\V1\UpdateUserRequest;
use Google\Ads\AdManager\V1\User;
use Google\ApiCore\ApiException;

/**
 * Batch updates `User` objects.
 *
 * @param string $formattedParent           The parent resource where `Users` will be updated.
 *                                          Format: `networks/{network_code}`
 *                                          The parent field in the UpdateUserRequest must match this
 *                                          field. Please see
 *                                          {@see UserServiceClient::networkName()} for help formatting this field.
 * @param string $requestsUserDisplayName   The name of the User. It has a maximum length of 128 characters.
 * @param string $requestsUserEmail         The email or login of the User. In order to create a new user,
 *                                          you must already have a Google Account.
 * @param string $formattedRequestsUserRole The unique Role ID of the User. Roles that are created by Google
 *                                          will have negative IDs. Please see
 *                                          {@see UserServiceClient::roleName()} for help formatting this field.
 */
function batch_update_users_sample(
    string $formattedParent,
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
    $updateUserRequest = (new UpdateUserRequest())
        ->setUser($requestsUser);
    $requests = [$updateUserRequest,];
    $request = (new BatchUpdateUsersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateUsersResponse $response */
        $response = $userServiceClient->batchUpdateUsers($request);
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
    $requestsUserDisplayName = '[DISPLAY_NAME]';
    $requestsUserEmail = '[EMAIL]';
    $formattedRequestsUserRole = UserServiceClient::roleName('[NETWORK_CODE]', '[ROLE]');

    batch_update_users_sample(
        $formattedParent,
        $requestsUserDisplayName,
        $requestsUserEmail,
        $formattedRequestsUserRole
    );
}
// [END admanager_v1_generated_UserService_BatchUpdateUsers_sync]
