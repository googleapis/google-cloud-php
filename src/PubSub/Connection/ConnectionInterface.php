<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\PubSub\Connection;

/**
 * Represents a connection to
 * [Pub/Sub](https://cloud.google.com/pubsub).
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function createTopic(array $args);

    /**
     * @param array $args
     */
    public function getTopic(array $args);

    /**
     * @param array $args
     */
    public function deleteTopic(array $args);

    /**
     * @param array $args
     */
    public function listTopics(array $args);

    /**
     * @param array $args
     */
    public function publishMessage(array $args);

    /**
     * @param array $args
     */
    public function listSubscriptionsByTopic(array $args);

    /**
     * @param array $args
     */
    public function getTopicIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function setTopicIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function testTopicIamPermissions(array $args);

    /**
     * @param array $args
     */
    public function createSubscription(array $args);

    /**
     * @param array $args
     */
    public function updateSubscription(array $args);

    /**
     * @param array $args
     */
    public function getSubscription(array $args);

    /**
     * @param array $args
     */
    public function listSubscriptions(array $args);

    /**
     * @param array $args
     */
    public function deleteSubscription(array $args);

    /**
     * @param array $args
     */
    public function modifyPushConfig(array $args);

    /**
     * @param array $args
     */
    public function pull(array $args);

    /**
     * @param array $args
     */
    public function modifyAckDeadline(array $args);

    /**
     * @param array $args
     */
    public function acknowledge(array $args);

    /**
     * @param array $args
     */
    public function listSnapshots(array $args);

    /**
     * @param array $args
     */
    public function createSnapshot(array $args);

    /**
     * @param array $args
     */
    public function deleteSnapshot(array $args);

    /**
     * @param array $args
     */
    public function seek(array $args);

    /**
     * @param array $args
     */
    public function getSubscriptionIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function setSubscriptionIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function testSubscriptionIamPermissions(array $args);
}
