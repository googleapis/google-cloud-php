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

// [START pubsub_v1_generated_Subscriber_Pull_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\PullResponse;
use Google\Cloud\PubSub\V1\SubscriberClient;

/**
 * Pulls messages from the server. The server may return `UNAVAILABLE` if
 * there are too many concurrent pull requests pending for the given
 * subscription.
 *
 * @param string $formattedSubscription The subscription from which messages should be pulled.
 *                                      Format is `projects/{project}/subscriptions/{sub}`. Please see
 *                                      {@see SubscriberClient::subscriptionName()} for help formatting this field.
 * @param int    $maxMessages           The maximum number of messages to return for this request. Must
 *                                      be a positive integer. The Pub/Sub system may return fewer than the number
 *                                      specified.
 */
function pull_sample(string $formattedSubscription, int $maxMessages): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Call the API and handle any network failures.
    try {
        /** @var PullResponse $response */
        $response = $subscriberClient->pull($formattedSubscription, $maxMessages);
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
    $formattedSubscription = SubscriberClient::subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
    $maxMessages = 0;

    pull_sample($formattedSubscription, $maxMessages);
}
// [END pubsub_v1_generated_Subscriber_Pull_sync]
