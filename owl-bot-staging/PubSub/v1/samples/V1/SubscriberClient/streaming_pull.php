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

// [START pubsub_v1_generated_Subscriber_StreamingPull_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\PubSub\V1\StreamingPullRequest;
use Google\Cloud\PubSub\V1\StreamingPullResponse;
use Google\Cloud\PubSub\V1\SubscriberClient;

/**
 * Establishes a stream with the server, which sends messages down to the
 * client. The client streams acknowledgements and ack deadline modifications
 * back to the server. The server will close the stream and return the status
 * on any error. The server may close the stream with status `UNAVAILABLE` to
 * reassign server-side resources, in which case, the client should
 * re-establish the stream. Flow control can be achieved by configuring the
 * underlying RPC channel.
 *
 * @param string $formattedSubscription    The subscription for which to initialize the new stream. This
 *                                         must be provided in the first request on the stream, and must not be set in
 *                                         subsequent requests from client to server.
 *                                         Format is `projects/{project}/subscriptions/{sub}`. Please see
 *                                         {@see SubscriberClient::subscriptionName()} for help formatting this field.
 * @param int    $streamAckDeadlineSeconds The ack deadline to use for the stream. This must be provided in
 *                                         the first request on the stream, but it can also be updated on subsequent
 *                                         requests from client to server. The minimum deadline you can specify is 10
 *                                         seconds. The maximum deadline you can specify is 600 seconds (10 minutes).
 */
function streaming_pull_sample(string $formattedSubscription, int $streamAckDeadlineSeconds): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $request = (new StreamingPullRequest())
        ->setSubscription($formattedSubscription)
        ->setStreamAckDeadlineSeconds($streamAckDeadlineSeconds);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $subscriberClient->streamingPull();
        $stream->writeAll([$request,]);

        /** @var StreamingPullResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
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
    $formattedSubscription = SubscriberClient::subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
    $streamAckDeadlineSeconds = 0;

    streaming_pull_sample($formattedSubscription, $streamAckDeadlineSeconds);
}
// [END pubsub_v1_generated_Subscriber_StreamingPull_sync]
