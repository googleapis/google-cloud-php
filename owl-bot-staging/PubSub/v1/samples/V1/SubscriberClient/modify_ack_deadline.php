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

// [START pubsub_v1_generated_Subscriber_ModifyAckDeadline_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\SubscriberClient;

/**
 * Modifies the ack deadline for a specific message. This method is useful
 * to indicate that more time is needed to process a message by the
 * subscriber, or to make the message available for redelivery if the
 * processing was interrupted. Note that this does not modify the
 * subscription-level `ackDeadlineSeconds` used for subsequent messages.
 *
 * @param string $formattedSubscription The name of the subscription.
 *                                      Format is `projects/{project}/subscriptions/{sub}`. Please see
 *                                      {@see SubscriberClient::subscriptionName()} for help formatting this field.
 * @param string $ackIdsElement         List of acknowledgment IDs.
 * @param int    $ackDeadlineSeconds    The new ack deadline with respect to the time this request was
 *                                      sent to the Pub/Sub system. For example, if the value is 10, the new ack
 *                                      deadline will expire 10 seconds after the `ModifyAckDeadline` call was
 *                                      made. Specifying zero might immediately make the message available for
 *                                      delivery to another subscriber client. This typically results in an
 *                                      increase in the rate of message redeliveries (that is, duplicates).
 *                                      The minimum deadline you can specify is 0 seconds.
 *                                      The maximum deadline you can specify is 600 seconds (10 minutes).
 */
function modify_ack_deadline_sample(
    string $formattedSubscription,
    string $ackIdsElement,
    int $ackDeadlineSeconds
): void {
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $ackIds = [$ackIdsElement,];

    // Call the API and handle any network failures.
    try {
        $subscriberClient->modifyAckDeadline($formattedSubscription, $ackIds, $ackDeadlineSeconds);
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
    $ackDeadlineSeconds = 0;

    modify_ack_deadline_sample($formattedSubscription, $ackIdsElement, $ackDeadlineSeconds);
}
// [END pubsub_v1_generated_Subscriber_ModifyAckDeadline_sync]
