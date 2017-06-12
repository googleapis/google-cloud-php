<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\PubSub;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\RegisterJobTrait;

/**
 * Publishes messages to Google Cloud Pub\Sub with background batching.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubSub = new PubSubClient();
 * $batchPublisher = $pubSub->topic('my_topic')
 *     ->batchPublisher();
 *
 * $batchPublisher->publish([
 *     'data' => 'An important message.'
 * ]);
 * ```
 */
class BatchPublisher
{
    use RegisterJobTrait;

    const ID_TEMPLATE = 'pubsub-topic-%s';

    /**
     * @param string $topicName
     * @param array $options [optional] Please see
     *        {@see Google\Cloud\PubSub\Topic::batchPublisher()} for
     *        configuration details.
     */
    public function __construct($topicName, array $options = [])
    {
        $this->setJobProperties($options + [
            'identifier' => sprintf(self::ID_TEMPLATE, $topicName)
        ]);

        $container = new BatchPublishContainer(
            $topicName,
            $this->clientConfig,
            $this->debugOutput
        );

        $this->batchRunner->registerJob(
            $this->identifier,
            [$container, 'send'],
            $this->batchOptions
        );
    }

    /**
     * Send messages to a batch queue.
     *
     * Example:
     * ```
     * $batchPublisher->publish([
     *     'data' => 'An important message.'
     * ]);
     * ```
     *
     * @param array $message [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     * @return bool
     */
    public function publish(array $message)
    {
        return $this->batchRunner->submitItem($this->identifier, $message);
    }
}
