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

namespace Google\Cloud\PubSub;

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Timestamp;
use DateTimeInterface;

interface PubSubClientInterface
{
    /**
     * @param string $name
     * @param array $options
     * @return Topic
     */
    public function createTopic($name, array $options = []);

    /**
     * @param string $name
     * @return Topic
     */
    public function topic($name);

    /**
     * @param array $options
     * @return ItemIterator<Topic>
     */
    public function topics(array $options = []);

    /**
     * @param string $name
     * @param Topic|string $topic
     * @param array  $options
     * @return Subscription
     */
    public function subscribe($name, $topic, array $options = []);

    /**
     * @param string $name
     * @param string $topicName
     * @return Subscription
     */
    public function subscription($name, $topicName = null);

    /**
     * @param array $options
     * @return ItemIterator<Subscription>
     */
    public function subscriptions(array $options = []);

    /**
     * @param string $name
     * @param Subscription $subscription
     * @param array $options
     * @return Snapshot
     */
    public function createSnapshot($name, Subscription $subscription, array $options = []);

    /**
     * @param string $name
     * @param array $info
     * @return Snapshot
     */
    public function snapshot($name, array $info = []);

    /**
     * @param array $options
     * @return ItemIterator<Snapshot>
     */
    public function snapshots(array $options = []);

    /**
     * @param string $schemaId
     * @param array $info
     * @return Schema
     */
    public function schema($schemaId, array $info = []);

    /**
     * @param string $schemaId
     * @param string $type
     * @param string $definition
     * @param array $options
     * @return Schema
     */
    public function createSchema($schemaId, $type, $definition, array $options = []);

    /**
     * @param array $options
     * @return ItemIterator<Schema>
     */
    public function schemas(array $options = []);

    /**
     * @param array $schema
     * @param array $options
     * @return void
     * @throws BadRequestException
     */
    public function validateSchema(array $schema, array $options = []);

    /**
     * @param Schema|string|array $schema
     * @param string $message
     * @param string $encoding
     * @param array $options
     * @return void
     * @throws BadRequestException
     */
    public function validateMessage($schema, $message, $encoding, array $options = []);

    /**
     * @param array $requestBody
     * @return Message
     */
    public function consume(array $requestBody);

    /**
     * @param DateTimeInterface $timestamp
     * @param int $nanoSeconds
     * @return Timestamp
     */
    public function timestamp(DateTimeInterface $timestamp, $nanoSeconds = null);

    /**
     * @param int $seconds
     * @param int $nanos
     * @return Duration
     */
    public function duration($seconds, $nanos = 0);

    public function __debugInfo();
}
