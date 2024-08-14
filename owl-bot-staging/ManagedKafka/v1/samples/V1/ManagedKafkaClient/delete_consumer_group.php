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

// [START managedkafka_v1_generated_ManagedKafka_DeleteConsumerGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\DeleteConsumerGroupRequest;

/**
 * Deletes a single consumer group.
 *
 * @param string $formattedName The name of the consumer group to delete.
 *                              `projects/{project}/locations/{location}/clusters/{cluster}/consumerGroups/{consumerGroup}`. Please see
 *                              {@see ManagedKafkaClient::consumerGroupName()} for help formatting this field.
 */
function delete_consumer_group_sample(string $formattedName): void
{
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
    $request = (new DeleteConsumerGroupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $managedKafkaClient->deleteConsumerGroup($request);
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
    $formattedName = ManagedKafkaClient::consumerGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[CONSUMER_GROUP]'
    );

    delete_consumer_group_sample($formattedName);
}
// [END managedkafka_v1_generated_ManagedKafka_DeleteConsumerGroup_sync]
