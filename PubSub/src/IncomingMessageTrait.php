<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\PubSub\Connection\ConnectionInterface;

/**
 * Provides a factory to build messages.
 */
trait IncomingMessageTrait
{
    /**
     * Create a Message instance from an incoming message.
     *
     * @param array $message The message data
     * @param ConnectionInterface $connection The service connection.
     * @param string $projectId The current project ID.
     * @param bool $encode Whether to base64_encode.
     * @return Message
     */
    private function messageFactory(array $message, ConnectionInterface $connection, $projectId, $encode)
    {
        if (!isset($message['message'])) {
            throw new GoogleException('Invalid message data.');
        }

        if (isset($message['message']['data']) && $encode) {
            $message['message']['data'] = base64_decode($message['message']['data']);
        }

        $subscription = null;
        if (isset($message['subscription'])) {
            $subscription = new Subscription(
                $connection,
                $projectId,
                $message['subscription'],
                null,
                $encode
            );
        }

        return new Message($message['message'], [
            'ackId' => (isset($message['ackId'])) ? $message['ackId'] : null,
            'deliveryAttempt' => (isset($message['deliveryAttempt'])) ? $message['deliveryAttempt'] : null,
            'subscription' => $subscription
        ]);
    }
}
