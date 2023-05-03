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

// [START monitoring_v3_generated_NotificationChannelService_CreateNotificationChannel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\NotificationChannel;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;

/**
 * Creates a new notification channel, representing a single notification
 * endpoint such as an email address, SMS number, or PagerDuty service.
 *
 * @param string $name The [project](https://cloud.google.com/monitoring/api/v3#project_name) on
 *                     which to execute the request. The format is:
 *
 *                     projects/[PROJECT_ID_OR_NUMBER]
 *
 *                     This names the container into which the channel will be
 *                     written, this does not name the newly created channel. The resulting
 *                     channel's name will have a normalized version of this field as a prefix,
 *                     but will add `/notificationChannels/[CHANNEL_ID]` to identify the channel.
 */
function create_notification_channel_sample(string $name): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Prepare the request message.
    $notificationChannel = new NotificationChannel();

    // Call the API and handle any network failures.
    try {
        /** @var NotificationChannel $response */
        $response = $notificationChannelServiceClient->createNotificationChannel(
            $name,
            $notificationChannel
        );
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
    $name = '[NAME]';

    create_notification_channel_sample($name);
}
// [END monitoring_v3_generated_NotificationChannelService_CreateNotificationChannel_sync]
