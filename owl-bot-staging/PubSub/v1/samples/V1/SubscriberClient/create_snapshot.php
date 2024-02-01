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

// [START pubsub_v1_generated_Subscriber_CreateSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\CreateSnapshotRequest;
use Google\Cloud\PubSub\V1\Snapshot;

/**
 * Creates a snapshot from the requested subscription. Snapshots are used in
 * [Seek](https://cloud.google.com/pubsub/docs/replay-overview) operations,
 * which allow you to manage message acknowledgments in bulk. That is, you can
 * set the acknowledgment state of messages in an existing subscription to the
 * state captured by a snapshot.
 * If the snapshot already exists, returns `ALREADY_EXISTS`.
 * If the requested subscription doesn't exist, returns `NOT_FOUND`.
 * If the backlog in the subscription is too old -- and the resulting snapshot
 * would expire in less than 1 hour -- then `FAILED_PRECONDITION` is returned.
 * See also the `Snapshot.expire_time` field. If the name is not provided in
 * the request, the server will assign a random
 * name for this snapshot on the same project as the subscription, conforming
 * to the [resource name format]
 * (https://cloud.google.com/pubsub/docs/pubsub-basics#resource_names). The
 * generated name is populated in the returned Snapshot object. Note that for
 * REST API requests, you must specify a name in the request.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_snapshot_sample(): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare the request message.
    $request = new CreateSnapshotRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Snapshot $response */
        $response = $subscriberClient->createSnapshot($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END pubsub_v1_generated_Subscriber_CreateSnapshot_sync]
