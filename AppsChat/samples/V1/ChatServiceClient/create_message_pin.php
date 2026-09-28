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

// [START chat_v1_generated_ChatService_CreateMessagePin_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\CreateMessagePinRequest;
use Google\Apps\Chat\V1\MessagePin;

/**
 * Creates a message pin.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following [authorization
 * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.spaces.pins`
 * - `https://www.googleapis.com/auth/chat.spaces`
 *
 * @param string $formattedParent            The parent space in which to create the message pin.
 *                                           Format: spaces/{space}
 *                                           Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 * @param string $formattedMessagePinMessage Immutable. The resource name of the message that is pinned.
 *                                           Format: `spaces/{space}/messages/{message}`
 *                                           Please see {@see ChatServiceClient::messageName()} for help formatting this field.
 */
function create_message_pin_sample(
    string $formattedParent,
    string $formattedMessagePinMessage
): void {
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $messagePin = (new MessagePin())
        ->setMessage($formattedMessagePinMessage);
    $request = (new CreateMessagePinRequest())
        ->setParent($formattedParent)
        ->setMessagePin($messagePin);

    // Call the API and handle any network failures.
    try {
        /** @var MessagePin $response */
        $response = $chatServiceClient->createMessagePin($request);
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
    $formattedMessagePinMessage = ChatServiceClient::messageName('[SPACE]', '[MESSAGE]');

    create_message_pin_sample($formattedParent, $formattedMessagePinMessage);
}
// [END chat_v1_generated_ChatService_CreateMessagePin_sync]
