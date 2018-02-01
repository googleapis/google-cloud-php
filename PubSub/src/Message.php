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

/**
 * Represents a PubSub Message.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $subscription = $pubsub->subscription('my-new-subscription');
 *
 * $messages = $subscription->pull();
 * foreach ($messages as $message) {
 *     echo $message->data();
 * }
 * ```
 */
class Message
{
    /**
     * @var array
     */
    private $message;

    /**
     * @var string
     */
    private $ackId;

    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @param array $message See
     *        [PubsubMessage](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     * @param array $metadata {
     *     Message metadata
     *
     *     @type string $ackId The message ackId. This is only set when messages
     *           are pulled from the PubSub service.
     *     @type Subscription $subscription The subscription the message was
     *           obtained from. This is only set when messages are delivered by
     *           pushDelivery.
     */
    public function __construct(array $message, array $metadata)
    {
        $this->message = $message + [
            'data' => null,
            'messageId' => null,
            'publishTime' => null,
            'attributes' => []
        ];

        $metadata += [
            'ackId' => null,
            'subscription' => null
        ];

        $this->ackId = $metadata['ackId'];
        $this->subscription = $metadata['subscription'];
    }

    /**
     * The message payload.
     *
     * Example:
     * ```
     * echo $message->data();
     * ```
     *
     * @return string
     */
    public function data()
    {
        return $this->message['data'];
    }

    /**
     * Retrieve a single message attribute.
     *
     * Example:
     * ```
     * echo $message->attribute('browser-name');
     * ```
     *
     * @param string $key The attribute key
     * @return string|null
     */
    public function attribute($key)
    {
        return (isset($this->message['attributes'][$key]))
            ? $this->message['attributes'][$key]
            : null;
    }

    /**
     * Retrieve all message attributes.
     *
     * Example:
     * ```
     * $attributes = $message->attributes();
     * ```
     *
     * @return array
     */
    public function attributes()
    {
        return $this->message['attributes'];
    }

    /**
     * Get the message ID.
     *
     * The message ID is assigned by the server when the message is published.
     * Guaranteed to be unique within the topic.
     *
     * Example:
     * ```
     * echo $message->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->message['messageId'];
    }

    /**
     * Get the message published time.
     *
     * Example:
     * ```
     * $time = $message->publishTime();
     * ```
     *
     * @return \DateTimeImmutable
     */
    public function publishTime()
    {
        return ($this->message['publishTime'])
            ? new \DateTimeImmutable($this->message['publishTime'])
            : null;
    }

    /**
     * Get the message ackId.
     *
     * This is only set when message is obtained via
     * {@see Google\Cloud\PubSub\Subscription::pull()}.
     *
     * Example:
     * ```
     * echo $message->ackId();
     * ```
     *
     * @return string
     */
    public function ackId()
    {
        return $this->ackId;
    }

    /**
     * Get the subcription through which the message was obtained.
     *
     * This is only set when the message is obtained via push delivery.
     *
     * Example:
     * ```
     * echo "Subscription Name: ". $message->subscription()->name();
     * ```
     *
     * @return Subscription
     */
    public function subscription()
    {
        return $this->subscription;
    }

    /**
     * Get the message data.
     *
     * Available keys are `ackId`, `subscription` and `message`.
     *
     * Example:
     * ```
     * $info = $message->info();
     * ```
     *
     * @return array
     */
    public function info()
    {
        return [
            'ackId' => $this->ackId,
            'subscription' => $this->subscription,
            'message' => $this->message
        ];
    }
}
