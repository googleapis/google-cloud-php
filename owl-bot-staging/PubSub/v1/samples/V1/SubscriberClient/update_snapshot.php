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

// [START pubsub_v1_generated_Subscriber_UpdateSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Snapshot;
use Google\Cloud\PubSub\V1\SubscriberClient;
use Google\Protobuf\FieldMask;

/**
 * Updates an existing snapshot. Snapshots are used in
 * [Seek](https://cloud.google.com/pubsub/docs/replay-overview) operations,
 * which allow you to manage message acknowledgments in bulk. That is, you can
 * set the acknowledgment state of messages in an existing subscription to the
 * state captured by a snapshot.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_snapshot_sample(): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $snapshot = new Snapshot();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Snapshot $response */
        $response = $subscriberClient->updateSnapshot($snapshot, $updateMask);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END pubsub_v1_generated_Subscriber_UpdateSnapshot_sync]
