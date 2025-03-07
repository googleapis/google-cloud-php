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

// [START chat_v1_generated_ChatService_UpdateSpaceNotificationSetting_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\SpaceNotificationSetting;
use Google\Apps\Chat\V1\UpdateSpaceNotificationSettingRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates the space notification setting. For an example, see [Update
 * the caller's space notification
 * setting](https://developers.google.com/workspace/chat/update-space-notification-setting).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_space_notification_setting_sample(): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $spaceNotificationSetting = new SpaceNotificationSetting();
    $updateMask = new FieldMask();
    $request = (new UpdateSpaceNotificationSettingRequest())
        ->setSpaceNotificationSetting($spaceNotificationSetting)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var SpaceNotificationSetting $response */
        $response = $chatServiceClient->updateSpaceNotificationSetting($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END chat_v1_generated_ChatService_UpdateSpaceNotificationSetting_sync]
