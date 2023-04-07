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

// [START pubsub_v1_generated_Publisher_Publish_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\PublishResponse;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\PubsubMessage;

/**
 * Adds one or more messages to the topic. Returns `NOT_FOUND` if the topic
 * does not exist.
 *
 * @param string $formattedTopic The messages in the request will be published on this topic.
 *                               Format is `projects/{project}/topics/{topic}`. Please see
 *                               {@see PublisherClient::topicName()} for help formatting this field.
 */
function publish_sample(string $formattedTopic): void
{
    // Create a client.
    $publisherClient = new PublisherClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $messages = [new PubsubMessage()];

    // Call the API and handle any network failures.
    try {
        /** @var PublishResponse $response */
        $response = $publisherClient->publish($formattedTopic, $messages);
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
    $formattedTopic = PublisherClient::topicName('[PROJECT]', '[TOPIC]');

    publish_sample($formattedTopic);
}
// [END pubsub_v1_generated_Publisher_Publish_sync]
