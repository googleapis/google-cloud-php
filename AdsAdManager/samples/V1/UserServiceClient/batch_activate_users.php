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

// [START admanager_v1_generated_UserService_BatchActivateUsers_sync]
use Google\Ads\AdManager\V1\BatchActivateUsersRequest;
use Google\Ads\AdManager\V1\BatchActivateUsersResponse;
use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\ApiCore\ApiException;

/**
 * Activates a list of `User` objects.
 *
 * @param string $formattedParent Format: `networks/{network_code}`
 *                                Please see {@see UserServiceClient::networkName()} for help formatting this field.
 * @param string $namesElement    The resource names of the `User` objects to activate.
 */
function batch_activate_users_sample(string $formattedParent, string $namesElement): void
{
    // Create a client.
    $userServiceClient = new UserServiceClient();

    // Prepare the request message.
    $names = [$namesElement,];
    $request = (new BatchActivateUsersRequest())
        ->setParent($formattedParent)
        ->setNames($names);

    // Call the API and handle any network failures.
    try {
        /** @var BatchActivateUsersResponse $response */
        $response = $userServiceClient->batchActivateUsers($request);
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
    $namesElement = '[NAMES]';

    batch_activate_users_sample($formattedParent, $namesElement);
}
// [END admanager_v1_generated_UserService_BatchActivateUsers_sync]
