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

// [START discoveryengine_v1_generated_UserStoreService_UpdateUserStore_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\UserStoreServiceClient;
use Google\Cloud\DiscoveryEngine\V1\UpdateUserStoreRequest;
use Google\Cloud\DiscoveryEngine\V1\UserStore;

/**
 * Updates the User Store.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_user_store_sample(): void
{
    // Create a client.
    $userStoreServiceClient = new UserStoreServiceClient();

    // Prepare the request message.
    $userStore = new UserStore();
    $request = (new UpdateUserStoreRequest())
        ->setUserStore($userStore);

    // Call the API and handle any network failures.
    try {
        /** @var UserStore $response */
        $response = $userStoreServiceClient->updateUserStore($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END discoveryengine_v1_generated_UserStoreService_UpdateUserStore_sync]
