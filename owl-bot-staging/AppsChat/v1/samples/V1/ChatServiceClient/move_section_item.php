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

// [START chat_v1_generated_ChatService_MoveSectionItem_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\MoveSectionItemRequest;
use Google\Apps\Chat\V1\MoveSectionItemResponse;

/**
 * Moves an item from one section to another. For example, if a section
 * contains spaces, this method can be used to move a space to a different
 * section. For details, see [Create and organize sections in Google
 * Chat](https://support.google.com/chat/answer/16059854).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with the [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.sections`
 *
 * @param string $formattedName          The resource name of the section item to move.
 *
 *                                       Format: `users/{user}/sections/{section}/items/{item}`
 *                                       Please see {@see ChatServiceClient::sectionItemName()} for help formatting this field.
 * @param string $formattedTargetSection The resource name of the section to move the section item to.
 *
 *                                       Format: `users/{user}/sections/{section}`
 *                                       Please see {@see ChatServiceClient::sectionName()} for help formatting this field.
 */
function move_section_item_sample(string $formattedName, string $formattedTargetSection): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new MoveSectionItemRequest())
        ->setName($formattedName)
        ->setTargetSection($formattedTargetSection);

    // Call the API and handle any network failures.
    try {
        /** @var MoveSectionItemResponse $response */
        $response = $chatServiceClient->moveSectionItem($request);
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
    $formattedName = ChatServiceClient::sectionItemName('[USER]', '[SECTION]', '[ITEM]');
    $formattedTargetSection = ChatServiceClient::sectionName('[USER]', '[SECTION]');

    move_section_item_sample($formattedName, $formattedTargetSection);
}
// [END chat_v1_generated_ChatService_MoveSectionItem_sync]
