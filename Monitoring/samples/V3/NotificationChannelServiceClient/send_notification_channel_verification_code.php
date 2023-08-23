<?php
/*
 * Copyright 2022 Google LLC
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

// [START monitoring_v3_generated_NotificationChannelService_SendNotificationChannelVerificationCode_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;

/**
 * Causes a verification code to be delivered to the channel. The code
 * can then be supplied in `VerifyNotificationChannel` to verify the channel.
 *
 * @param string $formattedName The notification channel to which to send a verification code. Please see
 *                              {@see NotificationChannelServiceClient::notificationChannelName()} for help formatting this field.
 */
function send_notification_channel_verification_code_sample(string $formattedName): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        $notificationChannelServiceClient->sendNotificationChannelVerificationCode($formattedName);
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
    $formattedName = NotificationChannelServiceClient::notificationChannelName(
        '[PROJECT]',
        '[NOTIFICATION_CHANNEL]'
    );

    send_notification_channel_verification_code_sample($formattedName);
}
// [END monitoring_v3_generated_NotificationChannelService_SendNotificationChannelVerificationCode_sync]
