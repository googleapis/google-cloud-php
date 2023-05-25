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

// [START pubsub_v1_generated_Subscriber_Acknowledge_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\SubscriberClient;

/**
 * Acknowledges the messages associated with the `ack_ids` in the
 * `AcknowledgeRequest`. The Pub/Sub system can remove the relevant messages
 * from the subscription.
 *
 * Acknowledging a message whose ack deadline has expired may succeed,
 * but such a message may be redelivered later. Acknowledging a message more
 * than once will not result in an error.
 *
 * @param string $formattedSubscription The subscription whose message is being acknowledged.
 *                                      Format is `projects/{project}/subscriptions/{sub}`. Please see
 *                                      {@see SubscriberClient::subscriptionName()} for help formatting this field.
 * @param string $ackIdsElement         The acknowledgment ID for the messages being acknowledged that
 *                                      was returned by the Pub/Sub system in the `Pull` response. Must not be
 *                                      empty.
 */
function acknowledge_sample(string $formattedSubscription, string $ackIdsElement): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $ackIds = [$ackIdsElement,];

    // Call the API and handle any network failures.
    try {
        $subscriberClient->acknowledge($formattedSubscription, $ackIds);
        printf('Call completed successfully.' . PHP_EOL);
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
    $ackIdsElement = '[ACK_IDS]';

    acknowledge_sample($formattedSubscription, $ackIdsElement);
}
// [END pubsub_v1_generated_Subscriber_Acknowledge_sync]
