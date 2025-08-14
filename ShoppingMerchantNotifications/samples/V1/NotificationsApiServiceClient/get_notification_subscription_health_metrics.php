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

// [START merchantapi_v1_generated_NotificationsApiService_GetNotificationSubscriptionHealthMetrics_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Notifications\V1\Client\NotificationsApiServiceClient;
use Google\Shopping\Merchant\Notifications\V1\GetNotificationSubscriptionHealthMetricsRequest;
use Google\Shopping\Merchant\Notifications\V1\NotificationSubscriptionHealthMetrics;

/**
 * Retrieves notification subscription health metrics for a merchant.
 * We recommend calling this periodically (hourly or daily) to monitor health
 * of your callback endpoint.
 *
 * @param string $formattedName The `name` of the notification subscription for which metrics are
 *                              retrieved.
 *                              Format:
 *                              `accounts/{account}/notificationsubscriptions/{notification_subscription}`
 *                              Please see {@see NotificationsApiServiceClient::notificationSubscriptionHealthMetricsName()} for help formatting this field.
 */
function get_notification_subscription_health_metrics_sample(string $formattedName): void
{
    // Create a client.
    $notificationsApiServiceClient = new NotificationsApiServiceClient();

    // Prepare the request message.
    $request = (new GetNotificationSubscriptionHealthMetricsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var NotificationSubscriptionHealthMetrics $response */
        $response = $notificationsApiServiceClient->getNotificationSubscriptionHealthMetrics($request);
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
    $formattedName = NotificationsApiServiceClient::notificationSubscriptionHealthMetricsName(
        '[ACCOUNT]',
        '[NOTIFICATION_SUBSCRIPTION]'
    );

    get_notification_subscription_health_metrics_sample($formattedName);
}
// [END merchantapi_v1_generated_NotificationsApiService_GetNotificationSubscriptionHealthMetrics_sync]
