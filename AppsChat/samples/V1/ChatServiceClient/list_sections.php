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

// [START chat_v1_generated_ChatService_ListSections_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\ListSectionsRequest;
use Google\Apps\Chat\V1\Section;

/**
 * Lists sections available to the Chat user. Sections help users group their
 * conversations and customize the list of spaces displayed in Chat
 * navigation panel. For details, see [Create and organize sections in Google
 * Chat](https://support.google.com/chat/answer/16059854).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with the [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.sections`
 * - `https://www.googleapis.com/auth/chat.users.sections.readonly`
 *
 * @param string $formattedParent The parent, which is the user resource name that owns this
 *                                collection of sections. Only supports listing sections for the calling
 *                                user. To refer to the calling user, set one of the following:
 *
 *                                - The `me` alias. For example, `users/me`.
 *
 *                                - Their Workspace email address. For example, `users/user&#64;example.com`.
 *
 *                                - Their user id. For example, `users/123456789`.
 *
 *                                Format: `users/{user}`
 *                                Please see {@see ChatServiceClient::userName()} for help formatting this field.
 */
function list_sections_sample(string $formattedParent): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new ListSectionsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $chatServiceClient->listSections($request);

        /** @var Section $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = ChatServiceClient::userName('[USER]');

    list_sections_sample($formattedParent);
}
// [END chat_v1_generated_ChatService_ListSections_sync]
