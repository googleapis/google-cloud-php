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

// [START chat_v1_generated_ChatService_UpdateAvailability_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Availability;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\UpdateAvailabilityRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates availability information for a human user. Only the `custom_status`
 * field can be updated through this method.
 *
 * This method only updates the authenticated user's availability.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following [authorization
 * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.availability`
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_availability_sample(): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $availability = new Availability();
    $updateMask = new FieldMask();
    $request = (new UpdateAvailabilityRequest())
        ->setAvailability($availability)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Availability $response */
        $response = $chatServiceClient->updateAvailability($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END chat_v1_generated_ChatService_UpdateAvailability_sync]
