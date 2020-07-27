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

use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\V1\AcknowledgeRequest;
use Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest;
use Google\Cloud\PubSub\V1\StreamingPullRequest;
use Google\ApiCore\ApiException;
use Google\Rpc\Code;

class StreamingPull
{
    private $subscriptionName;
    private $ackDeadline = 10;
    private $clientId = null;
    private $args = [];

    private $connection;
    private $stream = null;
    private $closed;

    public function __construct(ConnectionInterface $connection, $subscriptionName)
    {
        $this->closed = true;

        if (!method_exists($connection, 'streamingPull')) {
            throw new \RuntimeException('Connection does not support StreamingPull requests.');
        }

        $this->subscriptionName = $subscriptionName;
        $this->connection = $connection;
        $this->closed = false;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function setAckDeadline($seconds)
    {
        $this->ackDeadline = $seconds;
    }

    public function setClientId($id)
    {
        $this->clientId = $id;
    }

    public function setTimeoutMillis($millis)
    {
        $this->args['timeoutMillis'] = (int)$millis;
    }

    public function close()
    {
        if ($this->closed) {
            return;
        }

        if (isset($this->stream)) {
            $this->stream->closeWrite();
            $this->stream = null;
        }
        $this->closed = true;
    }

    public function pull()
    {
        $this->init();
        try {
            $receivedMessages = $this->stream->read()->getReceivedMessages()->getIterator();
            $messages = [];
            foreach ($receivedMessages as $receivedMessage) {
                $pubSubMessage = $receivedMessage->getMessage();
                $attributes = [];
                foreach ($pubSubMessage->getAttributes() as $key => $value) {
                    $attributes[$key] = $value;
                }
                $messages[] = new Message([
                    'data' => $pubSubMessage->getData(),
                    'messageId' => $pubSubMessage->getMessageId(),
                    'publishTime' => $pubSubMessage->getPublishTime()->toDateTime(),
                    'attributes' => $attributes,
                    'orderingKey' => $pubSubMessage->getOrderingKey(),
                ], [
                    'ackId' => $receivedMessage->getAckId(),
                    'deliveryAttempt' => $receivedMessage->getDeliveryAttempt(),
                    'subscription' => null,
                ]);
            }

            return $messages;
        } catch (ApiException $e) {
            $this->stream = null;
            if ($e->getCode() == Code::DEADLINE_EXCEEDED) {
                return [];
            }

            $this->close();
            throw $e;
        } catch (\Exception $e) {
            $this->close();
            throw $e;
        }
    }

    public function acknowledge(Message $message, array $options = [])
    {
        $this->acknowledgeBatch([$message], $options);
    }

    public function acknowledgeBatch(array $messages, array $options = [])
    {
        if (!count($messages)) {
            return;
        }

        $this->init();
        try {
            $request = new AcknowledgeRequest($options);
            $request->setAckIds($this->getAckIds($messages));
            $this->stream->write($request);
        } catch (\Exception $e) {
            $this->close();
            throw $e;
        }
    }

    public function modifyAckDeadline(Message $message, $seconds, array $options = [])
    {
        $this->modifyAckDeadlineBatch([$message], $seconds, $options);
    }

    public function modifyAckDeadlineBatch(array $messages, $seconds, array $options = [])
    {
        if (!count($messages)) {
            return;
        }

        $this->init();
        try {
            $request = new ModifyAckDeadlineRequest($options);
            $request->setAckIds($this->getAckIds($messages));
            $request->setAckDeadlineSeconds($seconds);
            $this->stream->write($request);
        } catch (\Exception $e) {
            $this->close();
            throw $e;
        }
    }

    private function init()
    {
        if ($this->closed) {
            throw new \RuntimeException('Cannot use closed streaming pull.');
        }

        if (!isset($this->stream)) {
            try {
                $request = new StreamingPullRequest();
                $request->setSubscription($this->subscriptionName);
                $request->setStreamAckDeadlineSeconds($this->ackDeadline);
                if (isset($this->clientId)) {
                    $request->setClientId((string)$this->clientId);
                }
                $stream = $this->connection->streamingPull($this->args);
                $this->stream = $stream;
                $stream->write($request);
            } catch (\Exception $e) {
                $this->close();
                throw $e;
            }
        }
    }

    private function getAckIds(array $messages)
    {
        $result = [];
        foreach ($messages as $message) {
            $result[] = $message->ackId();
        }
        return $result;
    }
}
