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

// [START pubsub_v1_generated_Publisher_CreateTopic_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\Topic;

/**
 * Creates the given topic with the given name. See the [resource name rules]
 * (https://cloud.google.com/pubsub/docs/admin#resource_names).
 *
 * @param string $name The name of the topic. It must have the format
 *                     `"projects/{project}/topics/{topic}"`. `{topic}` must start with a letter,
 *                     and contain only letters (`[A-Za-z]`), numbers (`[0-9]`), dashes (`-`),
 *                     underscores (`_`), periods (`.`), tildes (`~`), plus (`+`) or percent
 *                     signs (`%`). It must be between 3 and 255 characters in length, and it
 *                     must not start with `"goog"`.
 */
function create_topic_sample(string $name): void
{
    // Create a client.
    $publisherClient = new PublisherClient();

    // Call the API and handle any network failures.
    try {
        /** @var Topic $response */
        $response = $publisherClient->createTopic($name);
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
    $name = '[NAME]';

    create_topic_sample($name);
}
// [END pubsub_v1_generated_Publisher_CreateTopic_sync]
