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

// [START chat_v1_generated_ChatService_GetSpaceReadState_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetSpaceReadStateRequest;
use Google\Apps\Chat\V1\SpaceReadState;

/**
 * Returns details about a user's read state within a space, used to identify
 * read and unread messages. For an example, see [Get details about a user's
 * space read
 * state](https://developers.google.com/workspace/chat/get-space-read-state).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following [authorization
 * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.readstate.readonly`
 * - `https://www.googleapis.com/auth/chat.users.readstate`
 *
 * @param string $formattedName Resource name of the space read state to retrieve.
 *
 *                              Only supports getting read state for the calling user.
 *
 *                              To refer to the calling user, set one of the following:
 *
 *                              - The `me` alias. For example, `users/me/spaces/{space}/spaceReadState`.
 *
 *                              - Their Workspace email address. For example,
 *                              `users/user&#64;example.com/spaces/{space}/spaceReadState`.
 *
 *                              - Their user id. For example,
 *                              `users/123456789/spaces/{space}/spaceReadState`.
 *
 *                              Format: users/{user}/spaces/{space}/spaceReadState
 *                              Please see {@see ChatServiceClient::spaceReadStateName()} for help formatting this field.
 */
function get_space_read_state_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetSpaceReadStateRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SpaceReadState $response */
        $response = $chatServiceClient->getSpaceReadState($request);
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
    $formattedName = ChatServiceClient::spaceReadStateName('[USER]', '[SPACE]');

    get_space_read_state_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetSpaceReadState_sync]
