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

// [START pubsub_v1_generated_Publisher_DetachSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\DetachSubscriptionResponse;
use Google\Cloud\PubSub\V1\PublisherClient;

/**
 * Detaches a subscription from this topic. All messages retained in the
 * subscription are dropped. Subsequent `Pull` and `StreamingPull` requests
 * will return FAILED_PRECONDITION. If the subscription is a push
 * subscription, pushes to the endpoint will stop.
 *
 * @param string $formattedSubscription The subscription to detach.
 *                                      Format is `projects/{project}/subscriptions/{subscription}`. Please see
 *                                      {@see PublisherClient::subscriptionName()} for help formatting this field.
 */
function detach_subscription_sample(string $formattedSubscription): void
{
    // Create a client.
    $publisherClient = new PublisherClient();

    // Call the API and handle any network failures.
    try {
        /** @var DetachSubscriptionResponse $response */
        $response = $publisherClient->detachSubscription($formattedSubscription);
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
    $formattedSubscription = PublisherClient::subscriptionName('[PROJECT]', '[SUBSCRIPTION]');

    detach_subscription_sample($formattedSubscription);
}
// [END pubsub_v1_generated_Publisher_DetachSubscription_sync]
