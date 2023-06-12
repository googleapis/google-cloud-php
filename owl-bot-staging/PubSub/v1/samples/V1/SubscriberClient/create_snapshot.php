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

// [START pubsub_v1_generated_Subscriber_CreateSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Snapshot;
use Google\Cloud\PubSub\V1\SubscriberClient;

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
 * (https://cloud.google.com/pubsub/docs/admin#resource_names). The
 * generated name is populated in the returned Snapshot object. Note that for
 * REST API requests, you must specify a name in the request.
 *
 * @param string $formattedName         User-provided name for this snapshot. If the name is not provided
 *                                      in the request, the server will assign a random name for this snapshot on
 *                                      the same project as the subscription. Note that for REST API requests, you
 *                                      must specify a name.  See the [resource name
 *                                      rules](https://cloud.google.com/pubsub/docs/admin#resource_names). Format
 *                                      is `projects/{project}/snapshots/{snap}`. Please see
 *                                      {@see SubscriberClient::snapshotName()} for help formatting this field.
 * @param string $formattedSubscription The subscription whose backlog the snapshot retains.
 *                                      Specifically, the created snapshot is guaranteed to retain:
 *                                      (a) The existing backlog on the subscription. More precisely, this is
 *                                      defined as the messages in the subscription's backlog that are
 *                                      unacknowledged upon the successful completion of the
 *                                      `CreateSnapshot` request; as well as:
 *                                      (b) Any messages published to the subscription's topic following the
 *                                      successful completion of the CreateSnapshot request.
 *                                      Format is `projects/{project}/subscriptions/{sub}`. Please see
 *                                      {@see SubscriberClient::subscriptionName()} for help formatting this field.
 */
function create_snapshot_sample(string $formattedName, string $formattedSubscription): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Call the API and handle any network failures.
    try {
        /** @var Snapshot $response */
        $response = $subscriberClient->createSnapshot($formattedName, $formattedSubscription);
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
    $formattedName = SubscriberClient::snapshotName('[PROJECT]', '[SNAPSHOT]');
    $formattedSubscription = SubscriberClient::subscriptionName('[PROJECT]', '[SUBSCRIPTION]');

    create_snapshot_sample($formattedName, $formattedSubscription);
}
// [END pubsub_v1_generated_Subscriber_CreateSnapshot_sync]
