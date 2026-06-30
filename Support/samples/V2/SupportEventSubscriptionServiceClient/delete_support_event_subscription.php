<?php
/*
 * Copyright 2026 Google LLC
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

// [START cloudsupport_v2_generated_SupportEventSubscriptionService_DeleteSupportEventSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\SupportEventSubscriptionServiceClient;
use Google\Cloud\Support\V2\DeleteSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\SupportEventSubscription;

/**
 * Soft deletes a support event subscription.
 *
 * @param string $formattedName The name of the support event subscription to delete.
 *                              Format:
 *                              organizations/{organization_id}/supportEventSubscriptions/{subscription_id}
 *                              Please see {@see SupportEventSubscriptionServiceClient::supportEventSubscriptionName()} for help formatting this field.
 */
function delete_support_event_subscription_sample(string $formattedName): void
{
    // Create a client.
    $supportEventSubscriptionServiceClient = new SupportEventSubscriptionServiceClient();

    // Prepare the request message.
    $request = (new DeleteSupportEventSubscriptionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SupportEventSubscription $response */
        $response = $supportEventSubscriptionServiceClient->deleteSupportEventSubscription($request);
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
    $formattedName = SupportEventSubscriptionServiceClient::supportEventSubscriptionName(
        '[ORGANIZATION]',
        '[SUPPORT_EVENT_SUBSCRIPTION]'
    );

    delete_support_event_subscription_sample($formattedName);
}
// [END cloudsupport_v2_generated_SupportEventSubscriptionService_DeleteSupportEventSubscription_sync]
