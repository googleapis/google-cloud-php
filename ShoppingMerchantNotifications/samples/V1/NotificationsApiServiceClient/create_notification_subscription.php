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

// [START merchantapi_v1_generated_NotificationsApiService_CreateNotificationSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Notifications\V1\Client\NotificationsApiServiceClient;
use Google\Shopping\Merchant\Notifications\V1\CreateNotificationSubscriptionRequest;
use Google\Shopping\Merchant\Notifications\V1\NotificationSubscription;

/**
 * Creates a notification subscription for a business.
 * For standalone or subaccounts accounts, the business can create a
 * subscription for self. For MCAs, the business can create a
 * subscription for all managed accounts or for a specific subaccount.
 *
 * We will allow the following types of notification subscriptions to exist
 * together (per business as a subscriber per event type):
 *
 * 1. Subscription for all managed accounts + subscription for self.
 *
 * 2. Multiple "partial" subscriptions for managed accounts + subscription
 * for self.
 *
 * we will not allow (per business as a subscriber per event type):
 *
 * 1. Multiple self subscriptions.
 *
 * 2. Multiple "all managed accounts" subscriptions.
 *
 * 3. "All managed accounts" subscription and partial subscriptions at the
 * same time.
 *
 * 4. Multiple partial subscriptions for the same target account.
 *
 * @param string $formattedParent The merchant account that owns the new notification subscription.
 *                                Format: `accounts/{account}`
 *                                Please see {@see NotificationsApiServiceClient::accountName()} for help formatting this field.
 */
function create_notification_subscription_sample(string $formattedParent): void
{
    // Create a client.
    $notificationsApiServiceClient = new NotificationsApiServiceClient();

    // Prepare the request message.
    $notificationSubscription = new NotificationSubscription();
    $request = (new CreateNotificationSubscriptionRequest())
        ->setParent($formattedParent)
        ->setNotificationSubscription($notificationSubscription);

    // Call the API and handle any network failures.
    try {
        /** @var NotificationSubscription $response */
        $response = $notificationsApiServiceClient->createNotificationSubscription($request);
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
    $formattedParent = NotificationsApiServiceClient::accountName('[ACCOUNT]');

    create_notification_subscription_sample($formattedParent);
}
// [END merchantapi_v1_generated_NotificationsApiService_CreateNotificationSubscription_sync]
