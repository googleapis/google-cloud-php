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
 * Calling this method requires
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize)
 * and supports the following authentication types:
 *
 * - For text messages, user authentication or app authentication are
 * supported.
 * - For card messages, only app authentication is supported. (Only Chat apps
 * can create card messages.)
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
