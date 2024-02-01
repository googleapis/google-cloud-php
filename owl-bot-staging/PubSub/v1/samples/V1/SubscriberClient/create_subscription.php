<?php
/*
 * Copyright 2024 Google LLC
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

// [START pubsub_v1_generated_Subscriber_CreateSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\Subscription;

/**
 * Creates a subscription to a given topic. See the [resource name rules]
 * (https://cloud.google.com/pubsub/docs/pubsub-basics#resource_names).
 * If the subscription already exists, returns `ALREADY_EXISTS`.
 * If the corresponding topic doesn't exist, returns `NOT_FOUND`.
 *
 * If the name is not provided in the request, the server will assign a random
 * name for this subscription on the same project as the topic, conforming
 * to the [resource name format]
 * (https://cloud.google.com/pubsub/docs/pubsub-basics#resource_names). The
 * generated name is populated in the returned Subscription object. Note that
 * for REST API requests, you must specify a name in the request.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_subscription_sample(): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare the request message.
    $request = new Subscription();

    // Call the API and handle any network failures.
    try {
        /** @var Subscription $response */
        $response = $subscriberClient->createSubscription($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END pubsub_v1_generated_Subscriber_CreateSubscription_sync]
