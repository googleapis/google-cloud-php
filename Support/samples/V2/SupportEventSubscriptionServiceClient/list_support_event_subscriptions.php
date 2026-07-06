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

// [START cloudsupport_v2_generated_SupportEventSubscriptionService_ListSupportEventSubscriptions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Support\V2\Client\SupportEventSubscriptionServiceClient;
use Google\Cloud\Support\V2\ListSupportEventSubscriptionsRequest;
use Google\Cloud\Support\V2\SupportEventSubscription;

/**
 * Lists support event subscriptions.
 *
 * @param string $formattedParent The fully qualified name of the Cloud resource to list support
 *                                event subscriptions under. Format: organizations/{organization_id}
 *                                Please see {@see SupportEventSubscriptionServiceClient::organizationName()} for help formatting this field.
 */
function list_support_event_subscriptions_sample(string $formattedParent): void
{
    // Create a client.
    $supportEventSubscriptionServiceClient = new SupportEventSubscriptionServiceClient();

    // Prepare the request message.
    $request = (new ListSupportEventSubscriptionsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $supportEventSubscriptionServiceClient->listSupportEventSubscriptions($request);

        /** @var SupportEventSubscription $element */
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
    $formattedParent = SupportEventSubscriptionServiceClient::organizationName('[ORGANIZATION]');

    list_support_event_subscriptions_sample($formattedParent);
}
// [END cloudsupport_v2_generated_SupportEventSubscriptionService_ListSupportEventSubscriptions_sync]
