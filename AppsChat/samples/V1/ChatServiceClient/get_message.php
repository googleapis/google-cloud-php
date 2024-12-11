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

// [START chat_v1_generated_ChatService_GetMessage_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetMessageRequest;
use Google\Apps\Chat\V1\Message;

/**
 * Returns details about a message.
 * For an example, see [Get details about a
 * message](https://developers.google.com/workspace/chat/get-messages).
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 *
 * Note: Might return a message from a blocked member or space.
 *
 * @param string $formattedName Resource name of the message.
 *
 *                              Format: `spaces/{space}/messages/{message}`
 *
 *                              If you've set a custom ID for your message, you can use the value from the
 *                              `clientAssignedMessageId` field for `{message}`. For details, see [Name a
 *                              message]
 *                              (https://developers.google.com/workspace/chat/create-messages#name_a_created_message). Please see
 *                              {@see ChatServiceClient::messageName()} for help formatting this field.
 */
function get_message_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetMessageRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Message $response */
        $response = $chatServiceClient->getMessage($request);
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
    $formattedName = ChatServiceClient::messageName('[SPACE]', '[MESSAGE]');

    get_message_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetMessage_sync]
