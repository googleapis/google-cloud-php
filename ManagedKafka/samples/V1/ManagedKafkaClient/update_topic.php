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

// [START managedkafka_v1_generated_ManagedKafka_UpdateTopic_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\Topic;
use Google\Cloud\ManagedKafka\V1\UpdateTopicRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates the properties of a single topic.
 *
 * @param int $topicPartitionCount    The number of partitions this topic has. The partition count can
 *                                    only be increased, not decreased. Please note that if partitions are
 *                                    increased for a topic that has a key, the partitioning logic or the
 *                                    ordering of the messages will be affected.
 * @param int $topicReplicationFactor Immutable. The number of replicas of each partition. A
 *                                    replication factor of 3 is recommended for high availability.
 */
function update_topic_sample(int $topicPartitionCount, int $topicReplicationFactor): void
{
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $topic = (new Topic())
        ->setPartitionCount($topicPartitionCount)
        ->setReplicationFactor($topicReplicationFactor);
    $request = (new UpdateTopicRequest())
        ->setUpdateMask($updateMask)
        ->setTopic($topic);

    // Call the API and handle any network failures.
    try {
        /** @var Topic $response */
        $response = $managedKafkaClient->updateTopic($request);
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
    $topicPartitionCount = 0;
    $topicReplicationFactor = 0;

    update_topic_sample($topicPartitionCount, $topicReplicationFactor);
}
// [END managedkafka_v1_generated_ManagedKafka_UpdateTopic_sync]
