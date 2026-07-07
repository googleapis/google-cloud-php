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

// [START chat_v1_generated_ChatService_MarkAsDoNotDisturb_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Availability;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\MarkAsDoNotDisturbRequest;

/**
 * Marks user as `DO_NOT_DISTURB` in Google Chat.
 *
 * Sets a user's availability state to `DO_NOT_DISTURB` until a specified
 * expiration time.
 * When in `DO_NOT_DISTURB`, users typically won't receive notifications.
 *
 * This method only updates the authenticated user's availability.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.availability`
 *
 * @param string $formattedName The resource name of the availability to mark as Do Not Disturb.
 *                              Format: users/{user}/availability
 *
 *                              `{user}` is the id for the Person in the People API or Admin SDK directory
 *                              API. For example, `users/123456789`.
 *
 *                              The user's email address or `me` can also be used as an alias to refer to
 *                              the caller.  For example, `users/user&#64;example.com` or `users/me`. Please see
 *                              {@see ChatServiceClient::availabilityName()} for help formatting this field.
 */
function mark_as_do_not_disturb_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new MarkAsDoNotDisturbRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Availability $response */
        $response = $chatServiceClient->markAsDoNotDisturb($request);
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
    $formattedName = ChatServiceClient::availabilityName('[USER]');

    mark_as_do_not_disturb_sample($formattedName);
}
// [END chat_v1_generated_ChatService_MarkAsDoNotDisturb_sync]
