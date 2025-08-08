<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_UserService_UpdateUser_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\AccessRight;
use Google\Shopping\Merchant\Accounts\V1\Client\UserServiceClient;
use Google\Shopping\Merchant\Accounts\V1\UpdateUserRequest;
use Google\Shopping\Merchant\Accounts\V1\User;

/**
 * Updates a Merchant Center account user. Executing this method requires
 * admin access.
 *
 * @param int $userAccessRightsElement The [access
 *                                     rights](https://support.google.com/merchants/answer/12160472?sjid=6789834943175119429-EU#accesstypes)
 *                                     the user has.
 */
function update_user_sample(int $userAccessRightsElement): void
{
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $userAccessRights = [$userAccessRightsElement,];
    $user = (new User())
        ->setAccessRights($userAccessRights);
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
    $userAccessRightsElement = AccessRight::ACCESS_RIGHT_UNSPECIFIED;

    update_user_sample($userAccessRightsElement);
}
// [END merchantapi_v1_generated_UserService_UpdateUser_sync]
