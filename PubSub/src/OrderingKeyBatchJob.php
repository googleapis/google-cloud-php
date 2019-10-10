<?php
/**
 * Copyright 2020 Google LLC
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

use Google\Cloud\Core\Batch\BatchTrait;

/**
 * Represents a batch job for a single ordering key.
 *
 * Ordering keys must be segregated into separate RPCs. This class handles
 * separate batch jobs, named by its ordering key. Each instance will send
 * periodic RPCs containing one or more deferred messages. Messages are sent by
 * the batch daemon or a shutdown function. This class defers the work of making
 * service calls to {@see Google\Cloud\PubSub\BatchPublisher::publishDeferred}.
 *
 * @internal
 */
class OrderingKeyBatchJob
{
    use BatchTrait;

    const ID_TEMPLATE = 'pubsub-ordering-key-%s';

    /**
     * @var BatchPublisher
     */
    private $publisher;

    /**
     * @param BatchPublisher The batch publisher
     * @param string $orderingKey The ordering key
     * @param array $options client and publish options.
     */
    public function __construct(BatchPublisher $publisher, $orderingKey, array $options)
    {
        $this->publisher = $publisher;

        $this->setCommonBatchProperties($options + [
            'identifier' => sprintf(self::ID_TEMPLATE, $orderingKey),
            'batchMethod' => [$publisher, 'publishDeferred']
        ]);
    }

    /**
     * Returns an array representation of a callback which will be used to write
     * batch items.
     *
     * @return array
     * @access private
     * @internal
     */
    protected function getCallback()
    {
        return $this->batchMethod;
    }

    /**
     * Push a message onto the batch runner.
     *
     * @param array $message
     * @return bool
     * @access private
     * @internal
     */
    public function publish(array $message)
    {
        return $this->batchRunner->submitItem($this->identifier, $message);
    }
}
