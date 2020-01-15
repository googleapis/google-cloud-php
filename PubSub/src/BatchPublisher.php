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

/**
 * Publishes messages to Google Cloud Pub\Sub with background batching.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $batchPublisher = $pubsub->topic('my_topic')
 *     ->batchPublisher();
 *
 * $batchPublisher->publish([
 *     'data' => 'An important message.'
 * ]);
 * ```
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class BatchPublisher
{
    /**
     * @deprecated
     */
    const ID_TEMPLATE = 'pubsub-topic-%s';

    /**
     * @var array
     */
    private static $topics = [];

    /**
     * @var string
     */
    private $topicName;

    /**
     * @var PubSubClient
     */
    private $client;

    /**
     * @var OrderingKeyBatchJob[]
     */
    private $jobs;

    /**
     * @var array
     */
    private $publishOptions;

    /**
     * @var callable
     */
    private $batchMethod;

    /**
     * @var BatchRunner
     */
    private $batchRunner;

    /**
     * @param string $topicName The topic name.
     * @param array $options [optional] Please see
     *        {@see Google\Cloud\PubSub\Topic::batchPublisher()} for
     *        configuration details.
     */
    public function __construct($topicName, array $options = [])
    {
        $this->topicName = $topicName;
        $this->batchMethod = [$this, 'publishDeferred'];
        $this->publishOptions = $options;
        $this->batchRunner = isset($options['batchRunner'])
            ? $options['batchRunner']
            : new BatchRunner();
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
     * @param Message|array $message An instance of
     *        {@see Google\Cloud\PubSub\Message}, or an array in the correct
     *        [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     * @return bool
     */
    public function publish($message)
    {
        $message = $message instanceof Message
            ? $message->toArray()
            : $message;

        $job = $this->getJob($message);

        return $job->publish($message);
    }

    /**
     * Returns an array representation of a callback which will be used to write
     * batch items.
     *
     * @return array
     * @deprecated
     */
    protected function getCallback()
    {
        return $this->batchMethod;
    }

    /**
     * Intended for internal use only by the batch publisher.
     *
     * This method is called internally by the batch runner.
     * {@see Google\Cloud\PubSub\OrderingKeyBatchJob} provides this method as
     * its publish callback.
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/publish Publish Message
     *
     * @param array[] $messages A list of messages. Each message must be in the correct
     *        [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     * @param array $options [optional] Configuration Options
     * @return array A list of message IDs.
     * @internal
     * @access private
     */
    public function publishDeferred(array $messages, array $options = [])
    {
        if (!array_key_exists($this->topicName, self::$topics)) {
            if (!$this->client) {
                //@codeCoverageIgnoreStart
                $this->client = new PubSubClient($this->publishOptions['clientConfig']);
                //@codeCoverageIgnoreEnd
            }
            self::$topics[$this->topicName] = $this->client->topic($this->topicName);
        }

        $topic = self::$topics[$this->topicName];

        return $topic->publishBatch($messages, $options);
    }

    /**
     * Fetch or create a new job for the ordering key batch publish.
     *
     * @param array $message
     * @return OrderingKeyBatchJob
     */
    private function getJob(array $message)
    {
        $orderingKey = isset($message['orderingKey'])
            ? $message['orderingKey']
            : 'default';

        if (!isset($this->jobs[$orderingKey])) {
            $options = $this->publishOptions;
            $options['batchRunner'] = $this->batchRunner;
            $this->jobs[$orderingKey] = new OrderingKeyBatchJob($this, $orderingKey, $this->topicName, $options);
        }

        return $this->jobs[$orderingKey];
    }
}
