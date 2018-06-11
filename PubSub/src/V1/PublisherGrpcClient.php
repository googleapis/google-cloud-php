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
 * The service that an application uses to manipulate topics, and to send
 * messages to a topic.
 */
class PublisherGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates the given topic with the given name.
     * @param \Google\Cloud\PubSub\V1\Topic $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTopic(\Google\Cloud\PubSub\V1\Topic $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/CreateTopic',
        $argument,
        ['\Google\Cloud\PubSub\V1\Topic', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing topic. Note that certain properties of a topic are not
     * modifiable.  Options settings follow the style guide:
     * NOTE:  The style guide requires body: "topic" instead of body: "*".
     * Keeping the latter for internal consistency in V1, however it should be
     * corrected in V2.  See
     * https://cloud.google.com/apis/design/standard_methods#update for details.
     * @param \Google\Cloud\PubSub\V1\UpdateTopicRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateTopic(\Google\Cloud\PubSub\V1\UpdateTopicRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/UpdateTopic',
        $argument,
        ['\Google\Cloud\PubSub\V1\Topic', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds one or more messages to the topic. Returns `NOT_FOUND` if the topic
     * does not exist. The message payload must not be empty; it must contain
     *  either a non-empty data field, or at least one attribute.
     * @param \Google\Cloud\PubSub\V1\PublishRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Publish(\Google\Cloud\PubSub\V1\PublishRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/Publish',
        $argument,
        ['\Google\Cloud\PubSub\V1\PublishResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the configuration of a topic.
     * @param \Google\Cloud\PubSub\V1\GetTopicRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTopic(\Google\Cloud\PubSub\V1\GetTopicRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/GetTopic',
        $argument,
        ['\Google\Cloud\PubSub\V1\Topic', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists matching topics.
     * @param \Google\Cloud\PubSub\V1\ListTopicsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTopics(\Google\Cloud\PubSub\V1\ListTopicsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/ListTopics',
        $argument,
        ['\Google\Cloud\PubSub\V1\ListTopicsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the name of the subscriptions for this topic.
     * @param \Google\Cloud\PubSub\V1\ListTopicSubscriptionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTopicSubscriptions(\Google\Cloud\PubSub\V1\ListTopicSubscriptionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/ListTopicSubscriptions',
        $argument,
        ['\Google\Cloud\PubSub\V1\ListTopicSubscriptionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the topic with the given name. Returns `NOT_FOUND` if the topic
     * does not exist. After a topic is deleted, a new topic may be created with
     * the same name; this is an entirely new topic with none of the old
     * configuration or subscriptions. Existing subscriptions to this topic are
     * not deleted, but their `topic` field is set to `_deleted-topic_`.
     * @param \Google\Cloud\PubSub\V1\DeleteTopicRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteTopic(\Google\Cloud\PubSub\V1\DeleteTopicRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.Publisher/DeleteTopic',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
