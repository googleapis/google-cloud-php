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

// [START chat_v1_generated_ChatService_UpdateSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\Space;
use Google\Apps\Chat\V1\UpdateSpaceRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a space. For an example, see
 * [Update a
 * space](https://developers.google.com/workspace/chat/update-spaces).
 *
 * If you're updating the `displayName` field and receive the error message
 * `ALREADY_EXISTS`, try a different display name.. An existing space within
 * the Google Workspace organization might already use this display name.
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * with [administrator approval](https://support.google.com/a?p=chat-app-auth)
 * and one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.app.spaces`
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.spaces`
 * - `https://www.googleapis.com/auth/chat.import` (import mode spaces
 * only)
 * - User authentication grants administrator privileges when an
 * administrator account authenticates, `use_admin_access` is `true`, and
 * the following authorization scopes is used:
 * - `https://www.googleapis.com/auth/chat.admin.spaces`
 *
 * App authentication has the following limitations:
 *
 * - To update either `space.predefined_permission_settings` or
 * `space.permission_settings`, the app must be the space creator.
 * - Updating the `space.access_settings.audience` is not supported for app
 * authentication.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_space_sample(): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $space = new Space();
    $updateMask = new FieldMask();
    $request = (new UpdateSpaceRequest())
        ->setSpace($space)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $chatServiceClient->updateSpace($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END chat_v1_generated_ChatService_UpdateSpace_sync]
