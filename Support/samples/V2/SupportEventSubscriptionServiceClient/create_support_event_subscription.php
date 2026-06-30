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

// [START cloudsupport_v2_generated_SupportEventSubscriptionService_CreateSupportEventSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\SupportEventSubscriptionServiceClient;
use Google\Cloud\Support\V2\CreateSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\SupportEventSubscription;

/**
 * Creates a support event subscription for an organization.
 *
 * @param string $formattedParent                     The parent resource name where the support event subscription
 *                                                    will be created. Format: organizations/{organization_id}
 *                                                    Please see {@see SupportEventSubscriptionServiceClient::organizationName()} for help formatting this field.
 * @param string $supportEventSubscriptionPubSubTopic The name of the Pub/Sub topic to publish notifications to.
 *                                                    Format: projects/{project}/topics/{topic}
 */
function create_support_event_subscription_sample(
    string $formattedParent,
    string $supportEventSubscriptionPubSubTopic
): void {
    // Create a client.
    $supportEventSubscriptionServiceClient = new SupportEventSubscriptionServiceClient();

    // Prepare the request message.
    $supportEventSubscription = (new SupportEventSubscription())
        ->setPubSubTopic($supportEventSubscriptionPubSubTopic);
    $request = (new CreateSupportEventSubscriptionRequest())
        ->setParent($formattedParent)
        ->setSupportEventSubscription($supportEventSubscription);

    // Call the API and handle any network failures.
    try {
        /** @var SupportEventSubscription $response */
        $response = $supportEventSubscriptionServiceClient->createSupportEventSubscription($request);
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
    $formattedParent = SupportEventSubscriptionServiceClient::organizationName('[ORGANIZATION]');
    $supportEventSubscriptionPubSubTopic = '[PUB_SUB_TOPIC]';

    create_support_event_subscription_sample($formattedParent, $supportEventSubscriptionPubSubTopic);
}
// [END cloudsupport_v2_generated_SupportEventSubscriptionService_CreateSupportEventSubscription_sync]
