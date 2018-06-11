<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2017 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\PubSub\V1;

/**
 * The service that an application uses to manipulate subscriptions and to
 * consume messages from a subscription via the `Pull` method.
 */
class SubscriberGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a subscription to a given topic.
     * If the subscription already exists, returns `ALREADY_EXISTS`.
     * If the corresponding topic doesn't exist, returns `NOT_FOUND`.
     *
     * If the name is not provided in the request, the server will assign a random
     * name for this subscription on the same project as the topic, conforming
     * to the
     * [resource name format](https://cloud.google.com/pubsub/docs/overview#names).
     * The generated name is populated in the returned Subscription object.
     * Note that for REST API requests, you must specify a name in the request.
     * @param \Google\Cloud\PubSub\V1\Subscription $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSubscription(\Google\Cloud\PubSub\V1\Subscription $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/CreateSubscription',
        $argument,
        ['\Google\Cloud\PubSub\V1\Subscription', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the configuration details of a subscription.
     * @param \Google\Cloud\PubSub\V1\GetSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSubscription(\Google\Cloud\PubSub\V1\GetSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/GetSubscription',
        $argument,
        ['\Google\Cloud\PubSub\V1\Subscription', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing subscription. Note that certain properties of a
     * subscription, such as its topic, are not modifiable.
     * NOTE:  The style guide requires body: "subscription" instead of body: "*".
     * Keeping the latter for internal consistency in V1, however it should be
     * corrected in V2.  See
     * https://cloud.google.com/apis/design/standard_methods#update for details.
     * @param \Google\Cloud\PubSub\V1\UpdateSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateSubscription(\Google\Cloud\PubSub\V1\UpdateSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/UpdateSubscription',
        $argument,
        ['\Google\Cloud\PubSub\V1\Subscription', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists matching subscriptions.
     * @param \Google\Cloud\PubSub\V1\ListSubscriptionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSubscriptions(\Google\Cloud\PubSub\V1\ListSubscriptionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/ListSubscriptions',
        $argument,
        ['\Google\Cloud\PubSub\V1\ListSubscriptionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing subscription. All messages retained in the subscription
     * are immediately dropped. Calls to `Pull` after deletion will return
     * `NOT_FOUND`. After a subscription is deleted, a new one may be created with
     * the same name, but the new one has no association with the old
     * subscription or its topic unless the same topic is specified.
     * @param \Google\Cloud\PubSub\V1\DeleteSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSubscription(\Google\Cloud\PubSub\V1\DeleteSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/DeleteSubscription',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies the ack deadline for a specific message. This method is useful
     * to indicate that more time is needed to process a message by the
     * subscriber, or to make the message available for redelivery if the
     * processing was interrupted. Note that this does not modify the
     * subscription-level `ackDeadlineSeconds` used for subsequent messages.
     * @param \Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ModifyAckDeadline(\Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/ModifyAckDeadline',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Acknowledges the messages associated with the `ack_ids` in the
     * `AcknowledgeRequest`. The Pub/Sub system can remove the relevant messages
     * from the subscription.
     *
     * Acknowledging a message whose ack deadline has expired may succeed,
     * but such a message may be redelivered later. Acknowledging a message more
     * than once will not result in an error.
     * @param \Google\Cloud\PubSub\V1\AcknowledgeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Acknowledge(\Google\Cloud\PubSub\V1\AcknowledgeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/Acknowledge',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Pulls messages from the server. Returns an empty list if there are no
     * messages available in the backlog. The server may return `UNAVAILABLE` if
     * there are too many concurrent pull requests pending for the given
     * subscription.
     * @param \Google\Cloud\PubSub\V1\PullRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Pull(\Google\Cloud\PubSub\V1\PullRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/Pull',
        $argument,
        ['\Google\Cloud\PubSub\V1\PullResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * (EXPERIMENTAL) StreamingPull is an experimental feature. This RPC will
     * respond with UNIMPLEMENTED errors unless you have been invited to test
     * this feature. Contact cloud-pubsub@google.com with any questions.
     *
     * Establishes a stream with the server, which sends messages down to the
     * client. The client streams acknowledgements and ack deadline modifications
     * back to the server. The server will close the stream and return the status
     * on any error. The server may close the stream with status `OK` to reassign
     * server-side resources, in which case, the client should re-establish the
     * stream. `UNAVAILABLE` may also be returned in the case of a transient error
     * (e.g., a server restart). These should also be retried by the client. Flow
     * control can be achieved by configuring the underlying RPC channel.
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StreamingPull($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.pubsub.v1.Subscriber/StreamingPull',
        ['\Google\Cloud\PubSub\V1\StreamingPullResponse','decode'],
        $metadata, $options);
    }

    /**
     * Modifies the `PushConfig` for a specified subscription.
     *
     * This may be used to change a push subscription to a pull one (signified by
     * an empty `PushConfig`) or vice versa, or change the endpoint URL and other
     * attributes of a push subscription. Messages will accumulate for delivery
     * continuously through the call regardless of changes to the `PushConfig`.
     * @param \Google\Cloud\PubSub\V1\ModifyPushConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ModifyPushConfig(\Google\Cloud\PubSub\V1\ModifyPushConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/ModifyPushConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the existing snapshots.
     * @param \Google\Cloud\PubSub\V1\ListSnapshotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSnapshots(\Google\Cloud\PubSub\V1\ListSnapshotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/ListSnapshots',
        $argument,
        ['\Google\Cloud\PubSub\V1\ListSnapshotsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a snapshot from the requested subscription.
     * If the snapshot already exists, returns `ALREADY_EXISTS`.
     * If the requested subscription doesn't exist, returns `NOT_FOUND`.
     *
     * If the name is not provided in the request, the server will assign a random
     * name for this snapshot on the same project as the subscription, conforming
     * to the
     * [resource name format](https://cloud.google.com/pubsub/docs/overview#names).
     * The generated name is populated in the returned Snapshot object.
     * Note that for REST API requests, you must specify a name in the request.
     * @param \Google\Cloud\PubSub\V1\CreateSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSnapshot(\Google\Cloud\PubSub\V1\CreateSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/CreateSnapshot',
        $argument,
        ['\Google\Cloud\PubSub\V1\Snapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing snapshot. Note that certain properties of a snapshot
     * are not modifiable.
     * NOTE:  The style guide requires body: "snapshot" instead of body: "*".
     * Keeping the latter for internal consistency in V1, however it should be
     * corrected in V2.  See
     * https://cloud.google.com/apis/design/standard_methods#update for details.
     * @param \Google\Cloud\PubSub\V1\UpdateSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateSnapshot(\Google\Cloud\PubSub\V1\UpdateSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/UpdateSnapshot',
        $argument,
        ['\Google\Cloud\PubSub\V1\Snapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes an existing snapshot. All messages retained in the snapshot
     * are immediately dropped. After a snapshot is deleted, a new one may be
     * created with the same name, but the new one has no association with the old
     * snapshot or its subscription, unless the same subscription is specified.
     * @param \Google\Cloud\PubSub\V1\DeleteSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSnapshot(\Google\Cloud\PubSub\V1\DeleteSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/DeleteSnapshot',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Seeks an existing subscription to a point in time or to a given snapshot,
     * whichever is provided in the request.
     * @param \Google\Cloud\PubSub\V1\SeekRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Seek(\Google\Cloud\PubSub\V1\SeekRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Subscriber/Seek',
        $argument,
        ['\Google\Cloud\PubSub\V1\SeekResponse', 'decode'],
        $metadata, $options);
    }

}
