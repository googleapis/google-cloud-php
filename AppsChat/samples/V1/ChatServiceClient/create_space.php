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

// [START chat_v1_generated_ChatService_CreateSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\CreateSpaceRequest;
use Google\Apps\Chat\V1\Space;

/**
 * Creates a space. Can be used to create a named space, or a
 * group chat in `Import mode`. For an example, see [Create a
 * space](https://developers.google.com/workspace/chat/create-spaces).
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * with [administrator approval](https://support.google.com/a?p=chat-app-auth)
 * and one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.app.spaces.create`
 * - `https://www.googleapis.com/auth/chat.app.spaces`
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following authorization scopes:
 * - `https://www.googleapis.com/auth/chat.spaces.create`
 * - `https://www.googleapis.com/auth/chat.spaces`
 * - `https://www.googleapis.com/auth/chat.import` (import mode spaces
 * only)
 *
 * When authenticating as an app, the `space.customer` field must be set in
 * the request.
 *
 * When authenticating as an app, the Chat app is added as a member of the
 * space. However, unlike human authentication, the Chat app is not added as a
 * space manager. By default, the Chat app can be removed from the space by
 * all space members. To allow only space managers to remove the app from a
 * space, set `space.permission_settings.manage_apps` to `managers_allowed`.
 *
 * Space membership upon creation depends on whether the space is created in
 * `Import mode`:
 *
 * * **Import mode:** No members are created.
 * * **All other modes:**  The calling user is added as a member. This is:
 * * The app itself when using app authentication.
 * * The human user when using user authentication.
 *
 * If you receive the error message `ALREADY_EXISTS` when creating
 * a space, try a different `displayName`. An existing space within
 * the Google Workspace organization might already use this display name.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_space_sample(): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $space = new Space();
    $request = (new CreateSpaceRequest())
        ->setSpace($space);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $chatServiceClient->createSpace($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END chat_v1_generated_ChatService_CreateSpace_sync]
