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

// [START datamanager_v1_generated_UserListService_GetUserList_sync]
use Google\Ads\DataManager\V1\Client\UserListServiceClient;
use Google\Ads\DataManager\V1\GetUserListRequest;
use Google\Ads\DataManager\V1\UserList;
use Google\ApiCore\ApiException;

/**
 * Gets a UserList.
 *
 * Authorization Headers:
 *
 * This method supports the following optional headers to define how the API
 * authorizes access for the request:
 *
 * * `login-account`: (Optional) The resource name of the account where the
 * Google Account of the credentials is a user. If not set, defaults to the
 * account of the request. Format:
 * `accountTypes/{loginAccountType}/accounts/{loginAccountId}`
 * * `linked-account`: (Optional) The resource name of the account with an
 * established product link to the `login-account`. Format:
 * `accountTypes/{linkedAccountType}/accounts/{linkedAccountId}`
 *
 * @param string $formattedName The resource name of the UserList to retrieve.
 *                              Format:
 *                              accountTypes/{account_type}/accounts/{account}/userLists/{user_list}
 *                              Please see {@see UserListServiceClient::userListName()} for help formatting this field.
 */
function get_user_list_sample(string $formattedName): void
{
    // Create a client.
    $userListServiceClient = new UserListServiceClient();

    // Prepare the request message.
    $request = (new GetUserListRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var UserList $response */
        $response = $userListServiceClient->getUserList($request);
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
    $formattedName = UserListServiceClient::userListName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST]');

    get_user_list_sample($formattedName);
}
// [END datamanager_v1_generated_UserListService_GetUserList_sync]
