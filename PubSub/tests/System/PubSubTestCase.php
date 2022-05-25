<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\PubSub\Tests\System;

use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;

class PubSubTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $grpcClient;
    protected static $restClient;
    protected static $topic;
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::set_up_before_class();

        $result = [
            'grpc' => [self::$grpcClient],
        ];
        if (!self::isEmulatorUsed()) {
            $result['rest'] = [self::$restClient];
        }
        return $result;
    }

    public static function set_up_before_class()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$restClient = new PubSubClientRest([
            'keyFilePath' => $keyFilePath,
            'transport' => 'rest',
        ]);
        self::$grpcClient = new PubSubClientGrpc([
            'keyFilePath' => $keyFilePath,
            'transport' => 'grpc',
        ]);
        self::setUsingEmulatorForClassPrefix((bool) getenv('PUBSUB_EMULATOR_HOST'));
        self::$hasSetUp = true;
    }

    public static function topic(PubSubClient $client, array $config = [])
    {
        $topicName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName, $config);
        self::$deletionQueue->add($topic);

        return $topic;
    }

    public static function subscription(PubSubClient $client, Topic $topic, array $config = [])
    {
        $subName = uniqid(self::TESTING_PREFIX);
        $sub = $client->subscribe($subName, $topic, $config);

        self::$deletionQueue->add($sub);

        return $sub;
    }

    public static function topicAndSubscription(PubSubClient $client, array $topicConfig = [], array $subConfig = [])
    {
        $topic = self::topic($client, $topicConfig);
        $sub = self::subscription($client, $topic, $subConfig);

        return [$topic, $sub];
    }
}

//@codingStandardsIgnoreStart
class PubSubClientRest extends PubSubClient {}
class PubSubClientGrpc extends PubSubClient {}
//@codingStandardsIgnoreEnd
