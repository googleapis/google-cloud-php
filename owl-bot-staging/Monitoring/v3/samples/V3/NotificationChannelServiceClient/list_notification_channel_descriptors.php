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

// [START monitoring_v3_generated_NotificationChannelService_ListNotificationChannelDescriptors_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Monitoring\V3\NotificationChannelDescriptor;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;

/**
 * Lists the descriptors for supported channel types. The use of descriptors
 * makes it possible for new channel types to be dynamically added.
 *
 * @param string $name The REST resource name of the parent from which to retrieve
 *                     the notification channel descriptors. The expected syntax is:
 *
 *                     projects/[PROJECT_ID_OR_NUMBER]
 *
 *                     Note that this
 *                     [names](https://cloud.google.com/monitoring/api/v3#project_name) the parent
 *                     container in which to look for the descriptors; to retrieve a single
 *                     descriptor by name, use the
 *                     [GetNotificationChannelDescriptor][google.monitoring.v3.NotificationChannelService.GetNotificationChannelDescriptor]
 *                     operation, instead.
 */
function list_notification_channel_descriptors_sample(string $name): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $notificationChannelServiceClient->listNotificationChannelDescriptors($name);

        /** @var NotificationChannelDescriptor $element */
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

    list_notification_channel_descriptors_sample($name);
}
// [END monitoring_v3_generated_NotificationChannelService_ListNotificationChannelDescriptors_sync]
