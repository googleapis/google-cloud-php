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

// [START pubsub_v1_generated_Publisher_DeleteTopic_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\PublisherClient;

/**
 * Deletes the topic with the given name. Returns `NOT_FOUND` if the topic
 * does not exist. After a topic is deleted, a new topic may be created with
 * the same name; this is an entirely new topic with none of the old
 * configuration or subscriptions. Existing subscriptions to this topic are
 * not deleted, but their `topic` field is set to `_deleted-topic_`.
 *
 * @param string $formattedTopic Name of the topic to delete.
 *                               Format is `projects/{project}/topics/{topic}`. Please see
 *                               {@see PublisherClient::topicName()} for help formatting this field.
 */
function delete_topic_sample(string $formattedTopic): void
{
    // Create a client.
    $publisherClient = new PublisherClient();

    // Call the API and handle any network failures.
    try {
        $publisherClient->deleteTopic($formattedTopic);
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
    $formattedTopic = PublisherClient::topicName('[PROJECT]', '[TOPIC]');

    delete_topic_sample($formattedTopic);
}
// [END pubsub_v1_generated_Publisher_DeleteTopic_sync]
