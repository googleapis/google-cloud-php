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

// [START chat_v1_generated_ChatService_FindDirectMessage_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\FindDirectMessageRequest;
use Google\Apps\Chat\V1\Space;

/**
 * Returns the existing direct message with the specified user. If no direct
 * message space is found, returns a `404 NOT_FOUND` error. For an example,
 * see
 * [Find a direct message](/chat/api/guides/v1/spaces/find-direct-message).
 *
 * With [app
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app),
 * returns the direct message space between the specified user and the calling
 * Chat app.
 *
 * With [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
 * returns the direct message space between the specified user and the
 * authenticated user.
 *
 * // Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 *
 * @param string $name Resource name of the user to find direct message with.
 *
 *                     Format: `users/{user}`, where `{user}` is either the `id` for the
 *                     [person](https://developers.google.com/people/api/rest/v1/people) from the
 *                     People API, or the `id` for the
 *                     [user](https://developers.google.com/admin-sdk/directory/reference/rest/v1/users)
 *                     in the Directory API. For example, if the People API profile ID is
 *                     `123456789`, you can find a direct message with that person by using
 *                     `users/123456789` as the `name`. When [authenticated as a
 *                     user](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
 *                     you can use the email as an alias for `{user}`. For example,
 *                     `users/example&#64;gmail.com` where `example&#64;gmail.com` is the email of the
 *                     Google Chat user.
 */
function find_direct_message_sample(string $name): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new FindDirectMessageRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $chatServiceClient->findDirectMessage($request);
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
    $name = '[NAME]';

    find_direct_message_sample($name);
}
// [END chat_v1_generated_ChatService_FindDirectMessage_sync]
