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
use Google\Cloud\Core\Batch\BatchTrait;

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
    use BatchTrait;

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
     * @param string $topicName The topic name.
     * @param array $options [optional] Please see
     *        {@see Google\Cloud\PubSub\Topic::batchPublisher()} for
     *        configuration details.
     */
    public function __construct($topicName, array $options = [])
    {
        $this->topicName = $topicName;
        $this->setCommonBatchProperties($options + [
            'identifier' => sprintf(self::ID_TEMPLATE, $topicName),
            'batchMethod' => 'publishDeferred'
        ]);
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

        return $this->batchRunner->submitItem($this->identifier, $message);
    }

    /**
     * Returns an array representation of a callback which will be used to write
     * batch items.
     *
     * @return array
     */
    protected function getCallback()
    {
        return [$this, $this->batchMethod];
    }

    /**
     * Publish a set of deferred messages, sorted into multiple calls by ordering key.
     *
     * Intended for internal use only by the batch publisher.
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
        $calls = [];
        foreach ($messages as $message) {
            $key = isset($message['orderingKey'])
                ? $message['orderingKey']
                : '';

            if (!isset($calls[$key])) {
                $calls[$key] = [];
            }

            $calls[$key][] = $message;
        }

        if (!array_key_exists($this->topicName, self::$topics)) {
            if (!$this->client) {
                //@codeCoverageIgnoreStart
                $this->client = new PubSubClient($this->getUnwrappedClientConfig());
                //@codeCoverageIgnoreEnd
            }
            self::$topics[$this->topicName] = $this->client->topic($this->topicName);
        }

        $topic = self::$topics[$this->topicName];

        $res = [];
        foreach ($calls as $call) {
            $res = array_merge($res, $topic->publishBatch($call, $options));
        }

        return $res;
    }
}
