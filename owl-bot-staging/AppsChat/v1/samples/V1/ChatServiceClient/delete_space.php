<?php
/*
 * Copyright 2025 Google LLC
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

// [START chat_v1_generated_ChatService_DeleteSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\DeleteSpaceRequest;

/**
 * Deletes a named space. Always performs a cascading delete, which means
 * that the space's child resources—like messages posted in the space and
 * memberships in the space—are also deleted. For an example, see
 * [Delete a
 * space](https://developers.google.com/workspace/chat/delete-spaces).
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * with [administrator
 * approval](https://support.google.com/a?p=chat-app-auth) and the
 * authorization scope:
 * - `https://www.googleapis.com/auth/chat.app.delete` (only in
 * spaces the app created)
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.delete`
 * - `https://www.googleapis.com/auth/chat.import` (import mode spaces
 * only)
 * - User authentication grants administrator privileges when an
 * administrator account authenticates, `use_admin_access` is `true`, and
 * the following authorization scope is used:
 * - `https://www.googleapis.com/auth/chat.admin.delete`
 *
 * @param string $formattedName Resource name of the space to delete.
 *
 *                              Format: `spaces/{space}`
 *                              Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function delete_space_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new DeleteSpaceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $chatServiceClient->deleteSpace($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = ChatServiceClient::spaceName('[SPACE]');

    delete_space_sample($formattedName);
}
// [END chat_v1_generated_ChatService_DeleteSpace_sync]
