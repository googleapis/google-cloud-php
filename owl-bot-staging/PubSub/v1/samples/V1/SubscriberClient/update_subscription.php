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

// [START pubsub_v1_generated_Subscriber_UpdateSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\SubscriberClient;
use Google\Cloud\PubSub\V1\Subscription;
use Google\Protobuf\FieldMask;

/**
 * Updates an existing subscription. Note that certain properties of a
 * subscription, such as its topic, are not modifiable.
 *
 * @param string $subscriptionName           The name of the subscription. It must have the format
 *                                           `"projects/{project}/subscriptions/{subscription}"`. `{subscription}` must
 *                                           start with a letter, and contain only letters (`[A-Za-z]`), numbers
 *                                           (`[0-9]`), dashes (`-`), underscores (`_`), periods (`.`), tildes (`~`),
 *                                           plus (`+`) or percent signs (`%`). It must be between 3 and 255 characters
 *                                           in length, and it must not start with `"goog"`.
 * @param string $formattedSubscriptionTopic The name of the topic from which this subscription is receiving
 *                                           messages. Format is `projects/{project}/topics/{topic}`. The value of this
 *                                           field will be `_deleted-topic_` if the topic has been deleted. Please see
 *                                           {@see SubscriberClient::topicName()} for help formatting this field.
 */
function update_subscription_sample(
    string $subscriptionName,
    string $formattedSubscriptionTopic
): void {
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $subscription = (new Subscription())
        ->setName($subscriptionName)
        ->setTopic($formattedSubscriptionTopic);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Subscription $response */
        $response = $subscriberClient->updateSubscription($subscription, $updateMask);
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
    $subscriptionName = '[NAME]';
    $formattedSubscriptionTopic = SubscriberClient::topicName('[PROJECT]', '[TOPIC]');

    update_subscription_sample($subscriptionName, $formattedSubscriptionTopic);
}
// [END pubsub_v1_generated_Subscriber_UpdateSubscription_sync]
