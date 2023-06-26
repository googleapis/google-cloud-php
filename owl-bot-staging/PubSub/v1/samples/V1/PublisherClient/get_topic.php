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

// [START pubsub_v1_generated_Publisher_GetTopic_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\Topic;

/**
 * Gets the configuration of a topic.
 *
 * @param string $formattedTopic The name of the topic to get.
 *                               Format is `projects/{project}/topics/{topic}`. Please see
 *                               {@see PublisherClient::topicName()} for help formatting this field.
 */
function get_topic_sample(string $formattedTopic): void
{
    // Create a client.
    $publisherClient = new PublisherClient();

    // Call the API and handle any network failures.
    try {
        /** @var Topic $response */
        $response = $publisherClient->getTopic($formattedTopic);
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

    get_topic_sample($formattedTopic);
}
// [END pubsub_v1_generated_Publisher_GetTopic_sync]
