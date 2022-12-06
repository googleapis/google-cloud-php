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

// [START monitoring_v3_generated_NotificationChannelService_ListNotificationChannels_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Monitoring\V3\NotificationChannel;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;

/**
 * Lists the notification channels that have been created for the project.
 *
 * @param string $name The [project](https://cloud.google.com/monitoring/api/v3#project_name) on
 *                     which to execute the request. The format is:
 *
 *                     projects/[PROJECT_ID_OR_NUMBER]
 *
 *                     This names the container
 *                     in which to look for the notification channels; it does not name a
 *                     specific channel. To query a specific channel by REST resource name, use
 *                     the
 *                     [`GetNotificationChannel`][google.monitoring.v3.NotificationChannelService.GetNotificationChannel]
 *                     operation.
 */
function list_notification_channels_sample(string $name): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $notificationChannelServiceClient->listNotificationChannels($name);

        /** @var NotificationChannel $element */
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
    $name = '[NAME]';

    list_notification_channels_sample($name);
}
// [END monitoring_v3_generated_NotificationChannelService_ListNotificationChannels_sync]
