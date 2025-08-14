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

// [START chat_v1_generated_ChatService_CreateMessage_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\CreateMessageRequest;
use Google\Apps\Chat\V1\Message;

/**
 * Creates a message in a Google Chat space. For an example, see [Send a
 * message](https://developers.google.com/workspace/chat/create-messages).
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * with the authorization scope:
 * - `https://www.googleapis.com/auth/chat.bot`
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.messages.create`
 * - `https://www.googleapis.com/auth/chat.messages`
 * - `https://www.googleapis.com/auth/chat.import` (import mode spaces
 * only)
 *
 * Chat attributes the message sender differently depending on the type of
 * authentication that you use in your request.
 *
 * The following image shows how Chat attributes a message when you use app
 * authentication. Chat displays the Chat app as the message
 * sender. The content of the message can contain text (`text`), cards
 * (`cardsV2`), and accessory widgets (`accessoryWidgets`).
 *
 * ![Message sent with app
 * authentication](https://developers.google.com/workspace/chat/images/message-app-auth.svg)
 *
 * The following image shows how Chat attributes a message when you use user
 * authentication. Chat displays the user as the message sender and attributes
 * the Chat app to the message by displaying its name. The content of message
 * can only contain text (`text`).
 *
 * ![Message sent with user
 * authentication](https://developers.google.com/workspace/chat/images/message-user-auth.svg)
 *
 * The maximum message size, including the message contents, is 32,000 bytes.
 *
 * For
 * [webhook](https://developers.google.com/workspace/chat/quickstart/webhooks)
 * requests, the response doesn't contain the full message. The response only
 * populates the `name` and `thread.name` fields in addition to the
 * information that was in the request.
 *
 * @param string $formattedParent The resource name of the space in which to create a message.
 *
 *                                Format: `spaces/{space}`
 *                                Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function create_message_sample(string $formattedParent): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $message = new Message();
    $request = (new CreateMessageRequest())
        ->setParent($formattedParent)
        ->setMessage($message);

    // Call the API and handle any network failures.
    try {
        /** @var Message $response */
        $response = $chatServiceClient->createMessage($request);
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
    $formattedParent = ChatServiceClient::spaceName('[SPACE]');

    create_message_sample($formattedParent);
}
// [END chat_v1_generated_ChatService_CreateMessage_sync]
