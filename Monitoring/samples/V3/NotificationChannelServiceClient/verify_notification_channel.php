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

// [START monitoring_v3_generated_NotificationChannelService_VerifyNotificationChannel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\Client\NotificationChannelServiceClient;
use Google\Cloud\Monitoring\V3\NotificationChannel;
use Google\Cloud\Monitoring\V3\VerifyNotificationChannelRequest;

/**
 * Verifies a `NotificationChannel` by proving receipt of the code
 * delivered to the channel as a result of calling
 * `SendNotificationChannelVerificationCode`.
 *
 * @param string $formattedName The notification channel to verify. Please see
 *                              {@see NotificationChannelServiceClient::notificationChannelName()} for help formatting this field.
 * @param string $code          The verification code that was delivered to the channel as
 *                              a result of invoking the `SendNotificationChannelVerificationCode` API
 *                              method or that was retrieved from a verified channel via
 *                              `GetNotificationChannelVerificationCode`. For example, one might have
 *                              "G-123456" or "TKNZGhhd2EyN3I1MnRnMjRv" (in general, one is only
 *                              guaranteed that the code is valid UTF-8; one should not
 *                              make any assumptions regarding the structure or format of the code).
 */
function verify_notification_channel_sample(string $formattedName, string $code): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Prepare the request message.
    $request = (new VerifyNotificationChannelRequest())
        ->setName($formattedName)
        ->setCode($code);

    // Call the API and handle any network failures.
    try {
        /** @var NotificationChannel $response */
        $response = $notificationChannelServiceClient->verifyNotificationChannel($request);
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
    $formattedName = NotificationChannelServiceClient::notificationChannelName(
        '[PROJECT]',
        '[NOTIFICATION_CHANNEL]'
    );
    $code = '[CODE]';

    verify_notification_channel_sample($formattedName, $code);
}
// [END monitoring_v3_generated_NotificationChannelService_VerifyNotificationChannel_sync]
