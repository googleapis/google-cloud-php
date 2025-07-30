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

// [START chat_v1_generated_ChatService_GetSpaceNotificationSetting_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetSpaceNotificationSettingRequest;
use Google\Apps\Chat\V1\SpaceNotificationSetting;

/**
 * Gets the space notification setting. For an example, see [Get the
 * caller's space notification
 * setting](https://developers.google.com/workspace/chat/get-space-notification-setting).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with the [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.spacesettings`
 *
 * @param string $formattedName Format: users/{user}/spaces/{space}/spaceNotificationSetting
 *
 *                              - `users/me/spaces/{space}/spaceNotificationSetting`, OR
 *                              - `users/user&#64;example.com/spaces/{space}/spaceNotificationSetting`, OR
 *                              - `users/123456789/spaces/{space}/spaceNotificationSetting`.
 *                              Note: Only the caller's user id or email is allowed in the path. Please see
 *                              {@see ChatServiceClient::spaceNotificationSettingName()} for help formatting this field.
 */
function get_space_notification_setting_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetSpaceNotificationSettingRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SpaceNotificationSetting $response */
        $response = $chatServiceClient->getSpaceNotificationSetting($request);
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
    $formattedName = ChatServiceClient::spaceNotificationSettingName('[USER]', '[SPACE]');

    get_space_notification_setting_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetSpaceNotificationSetting_sync]
