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

// [START monitoring_v3_generated_NotificationChannelService_GetNotificationChannelVerificationCode_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\GetNotificationChannelVerificationCodeResponse;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;

/**
 * Requests a verification code for an already verified channel that can then
 * be used in a call to VerifyNotificationChannel() on a different channel
 * with an equivalent identity in the same or in a different project. This
 * makes it possible to copy a channel between projects without requiring
 * manual reverification of the channel. If the channel is not in the
 * verified state, this method will fail (in other words, this may only be
 * used if the SendNotificationChannelVerificationCode and
 * VerifyNotificationChannel paths have already been used to put the given
 * channel into the verified state).
 *
 * There is no guarantee that the verification codes returned by this method
 * will be of a similar structure or form as the ones that are delivered
 * to the channel via SendNotificationChannelVerificationCode; while
 * VerifyNotificationChannel() will recognize both the codes delivered via
 * SendNotificationChannelVerificationCode() and returned from
 * GetNotificationChannelVerificationCode(), it is typically the case that
 * the verification codes delivered via
 * SendNotificationChannelVerificationCode() will be shorter and also
 * have a shorter expiration (e.g. codes such as "G-123456") whereas
 * GetVerificationCode() will typically return a much longer, websafe base
 * 64 encoded string that has a longer expiration time.
 *
 * @param string $formattedName The notification channel for which a verification code is to be
 *                              generated and retrieved. This must name a channel that is already verified;
 *                              if the specified channel is not verified, the request will fail. Please see
 *                              {@see NotificationChannelServiceClient::notificationChannelName()} for help formatting this field.
 */
function get_notification_channel_verification_code_sample(string $formattedName): void
{
    // Create a client.
    $notificationChannelServiceClient = new NotificationChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var GetNotificationChannelVerificationCodeResponse $response */
        $response = $notificationChannelServiceClient->getNotificationChannelVerificationCode(
            $formattedName
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
    $formattedName = NotificationChannelServiceClient::notificationChannelName(
        '[PROJECT]',
        '[NOTIFICATION_CHANNEL]'
    );

    get_notification_channel_verification_code_sample($formattedName);
}
// [END monitoring_v3_generated_NotificationChannelService_GetNotificationChannelVerificationCode_sync]
