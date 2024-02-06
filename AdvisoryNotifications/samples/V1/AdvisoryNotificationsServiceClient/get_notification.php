<?php
/*
 * Copyright 2023 Google LLC
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

// [START advisorynotifications_v1_generated_AdvisoryNotificationsService_GetNotification_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AdvisoryNotifications\V1\Client\AdvisoryNotificationsServiceClient;
use Google\Cloud\AdvisoryNotifications\V1\GetNotificationRequest;
use Google\Cloud\AdvisoryNotifications\V1\Notification;

/**
 * Gets a notification.
 *
 * @param string $formattedName A name of the notification to retrieve.
 *                              Format:
 *                              organizations/{organization}/locations/{location}/notifications/{notification}
 *                              or projects/{projects}/locations/{location}/notifications/{notification}. Please see
 *                              {@see AdvisoryNotificationsServiceClient::notificationName()} for help formatting this field.
 */
function get_notification_sample(string $formattedName): void
{
    // Create a client.
    $advisoryNotificationsServiceClient = new AdvisoryNotificationsServiceClient();

    // Prepare the request message.
    $request = (new GetNotificationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Notification $response */
        $response = $advisoryNotificationsServiceClient->getNotification($request);
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
    $formattedName = AdvisoryNotificationsServiceClient::notificationName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[NOTIFICATION]'
    );

    get_notification_sample($formattedName);
}
// [END advisorynotifications_v1_generated_AdvisoryNotificationsService_GetNotification_sync]
