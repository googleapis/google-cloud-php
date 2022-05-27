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

namespace Google\Cloud\Tests\System\ServiceWhitelist;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group whitelist
 */
class WhitelistTest extends SystemTestCase
{
    use AssertStringContains;

    const MESSAGE = 'NOTE: Error may be due to Whitelist Restriction.';
    const TESTING_PREFIX = 'gcloud_whitelist_testing_';

    private $keyFilePath;

    public function set_up()
    {
        $this->markTestSkipped('Temporarily removed from the system test suite.');
        if (!getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH')) {
            $this->markTestSkipped('Missing whitelist keyfile path for whitelist system tests.');
        }

        $this->keyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
    }

    public function testPubSubListSnapshotsRest()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'rest'
        ]);

        $this->checkException(function () use ($client) {
            iterator_to_array($client->snapshots());
        });
    }

    public function testPubSubListSnapshotsGrpc()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'grpc'
        ]);

        $this->checkException(function () use ($client) {
            iterator_to_array($client->snapshots());
        });
    }

    public function testPubSubCreateSnapshotRest()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'rest'
        ]);

        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($topic);

        $sub = $topic->subscribe(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($sub);

        $this->checkException(function () use ($client, $sub) {
            $client->createSnapshot(uniqid(self::TESTING_PREFIX), $sub);
        });
    }

    public function testPubSubCreateSnapshotGrpc()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'grpc'
        ]);

        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($topic);

        $sub = $topic->subscribe(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($sub);

        $this->checkException(function () use ($client, $sub) {
            $client->createSnapshot(uniqid(self::TESTING_PREFIX), $sub);
        });
    }

    public function testPubSubSeekRest()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'rest'
        ]);

        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($topic);

        $sub = $topic->subscribe(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($sub);

        $this->checkException(function () use ($sub) {
            $sub->seekToTime(new Timestamp(new \DateTime));
        });
    }

    public function testPubSubSeekGrpc()
    {
        $client = new PubSubClient([
            'keyFilePath' => $this->keyFilePath,
            'transport' => 'grpc'
        ]);

        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($topic);

        $sub = $topic->subscribe(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add($sub);

        $this->checkException(function () use ($sub) {
            $sub->seekToTime(new Timestamp(new \DateTime));
        });
    }

    private function checkException(callable $call)
    {
        $thrown = false;
        $ex = null;
        try {
            $call();
        } catch (\Exception $e) {
            $thrown = true;
            $ex = $e;
        }

        $this->assertTrue($thrown);
        $this->assertInstanceOf(NotFoundException::class, $ex);
        $this->assertStringContainsString(self::MESSAGE, $ex->getMessage());
    }
}
