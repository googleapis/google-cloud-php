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

use Google\Cloud\Core\ArrayTrait;

/**
 * Builds a PubSub Message.
 *
 * This class may be used to build an API-compliant message for publication.
 *
 * This class is immutable and each build method returns a new instance with
 * your changes applied.
 *
 * Note that messages are invalid unless they include a data field or at least
 * one attribute. Both may be provided, but omission of both will result in an
 * error.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\MessageBuilder;
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $client = new PubSubClient();
 * $topic = $client->topic($topicId);
 *
 * $builder = new MessageBuilder();
 * $builder = $builder->setData('hello friend!')
 *     ->addAttribute('from', 'Bob')
 *     ->addAttribute('to', 'Jane');
 *
 * $topic->publish($builder->build());
 * ```
 */
class MessageBuilder
{
    use ArrayTrait;

    /**
     * @var array
     */
    private $message;

    /**
     * @param array $message The initial message data.
     */
    public function __construct(array $message = [])
    {
        $this->message = $message;
    }

    /**
     * Set the message data.
     *
     * Do not base64-encode the value; If it must be encoded, the client will
     * do it on your behalf.
     *
     * Example:
     * ```
     * $builder = $builder->setData('Hello friend!');
     * ```
     *
     * @param string $data The message data field.
     * @return MessageBuilder
     */
    public function setData($data)
    {
        return $this->newMessage([
            'data' => $data
        ]);
    }

    /**
     * Set optional attributes for this message.
     *
     * Example:
     * ```
     * $builder = $builder->setAttributes([
     *     'from' => 'Bob'
     * ]);
     * ```
     *
     * @param array $attributes A set of key/value pairs, where both key and
     *        value are strings.
     * @return MessageBuilder
     */
    public function setAttributes(array $attributes)
    {
        return $this->newMessage([
            'attributes' => $attributes
        ]);
    }

    /**
     * Add a single attribute to the message.
     *
     * Example:
     * ```
     * $builder = $builder->addAttribute('to', 'Jane');
     * ```
     *
     * @param string $key The attribute key.
     * @param string $value The attribute value.
     * @return MessageBuilder
     */
    public function addAttribute($key, $value)
    {
        $attributes = [];
        if (isset($this->message['attributes'])) {
            $attributes = $this->message['attributes'];
        }

        $attributes[$key] = $value;

        return $this->newMessage([
            'attributes' => $attributes
        ]);
    }

    /**
     * Set the message's ordering key.
     *
     * Example:
     * ```
     * $builder = $builder->setOrderingKey('order');
     * ```
     *
     * @param string $orderingKey The ordering key.
     * @return MessageBuilder
     */
    public function setOrderingKey($orderingKey)
    {
        return $this->newMessage([
            'orderingKey' => $orderingKey
        ]);
    }

    /**
     * Build a message.
     *
     * Example:
     * ```
     * $message = $builder->build();
     * ```
     *
     * @return Message
     * @throws \BadMethodCallException If required data is missing.
     */
    public function build()
    {
        $hasAttributes = isset($this->message['attributes']) && $this->message['attributes'];
        if (!isset($this->message['data']) && !$hasAttributes) {
            throw new \BadMethodCallException(
                'Messages must contain either a non-empty data field or at least one attribute.'
            );
        }

        return new Message($this->message);
    }

    private function newMessage(array $data)
    {
        $data = $this->arrayMergeRecursive($this->message, $data);

        return new static($data);
    }
}
