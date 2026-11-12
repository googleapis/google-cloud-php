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

// [START chat_v1_generated_ChatService_ReplaceMessageCards_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\ReplaceMessageCardsRequest;
use Google\Apps\Chat\V1\ReplaceMessageCardsResponse;

/**
 * Replaces the cards included in a message.
 *
 * A Chat app can only replace cards on a human-created message if the message
 * already contains cards, and the cards were created by the app.
 *
 * If the app replaces the cards with an empty list, the cards are removed.
 * After removing the cards, the app cannot add cards back to the message.
 *
 * Requires [app
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * with the [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 * - `https://www.googleapis.com/auth/chat.bot`
 *
 * @param string $formattedName The resource name of the message.
 *
 *                              Format: `spaces/{space}/messages/{message}`
 *                              Please see {@see ChatServiceClient::messageName()} for help formatting this field.
 */
function replace_message_cards_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new ReplaceMessageCardsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ReplaceMessageCardsResponse $response */
        $response = $chatServiceClient->replaceMessageCards($request);
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

    replace_message_cards_sample($formattedName);
}
// [END chat_v1_generated_ChatService_ReplaceMessageCards_sync]
