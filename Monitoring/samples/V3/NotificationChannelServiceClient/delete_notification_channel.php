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

// [START monitoring_v3_generated_NotificationChannelService_DeleteNotificationChannel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\Client\NotificationChannelServiceClient;
use Google\Cloud\Monitoring\V3\DeleteNotificationChannelRequest;

/**
 * Deletes a notification channel.
 *
 * Design your application to single-thread API calls that modify the state of
 * notification channels in a single project. This includes calls to
 * CreateNotificationChannel, DeleteNotificationChannel and
 * UpdateNotificationChannel.
 *
 * @param string $formattedName The channel for which to execute the request. The format is:
 *
 *                              projects/[PROJECT_ID_OR_NUMBER]/notificationChannels/[CHANNEL_ID]
 *                              Please see {@see NotificationChannelServiceClient::notificationChannelName()} for help formatting this field.
 */
function delete_notification_channel_sample(string $formattedName): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Prepare the request message.
    $request = (new DeleteNotificationChannelRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $notificationChannelServiceClient->deleteNotificationChannel($request);
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

    delete_notification_channel_sample($formattedName);
}
// [END monitoring_v3_generated_NotificationChannelService_DeleteNotificationChannel_sync]
