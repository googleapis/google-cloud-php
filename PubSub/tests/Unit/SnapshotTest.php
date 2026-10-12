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

namespace Google\Cloud\PubSub\Tests\Unit;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class SnapshotTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'my-project';
    const SNAPSHOT_ID = 'snapshot';

    private $requestHandler;
    private $snapshot;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->snapshot = TestHelpers::stub(Snapshot::class, [
            $this->requestHandler->reveal(),
            new Serializer(),
            self::PROJECT,
            self::SNAPSHOT_ID,
            false
        ], ['requestHandler', 'info']);
    }

    public function testConstructWithFullyQualifiedName()
    {
        $snapshot = TestHelpers::stub(Snapshot::class, [
            $this->requestHandler->reveal(),
            new Serializer(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::SNAPSHOT_ID,
            false
        ]);

        $this->assertEquals($this->snapshot->name(), $snapshot->name());
    }

    public function testName()
    {
        $this->assertEquals('projects/'. self::PROJECT .'/snapshots/'. self::SNAPSHOT_ID, $this->snapshot->name());
    }

    public function testInfo()
    {
        $info = [
            'name' => 'projects/'. self::PROJECT .'/snapshots/'. self::SNAPSHOT_ID,
            'subscription' => 'foo',
            'topic' => 'bar',
            'expirationTime' => null
        ];

        $this->snapshot->___setProperty('info', $info);

        $this->assertEquals($info, $this->snapshot->info());
    }

    public function testCreate()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSnapshot',
            Argument::cetera()
        )->shouldBeCalled();

        $info = [
            'subscription' => 'foo',
        ];

        $this->snapshot->___setProperty('info', $info);

        $this->snapshot->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->snapshot->create();
    }

    public function testCreateWithoutSubscription()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->snapshot->create();
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'deleteSnapshot',
            Argument::cetera()
        )->shouldBeCalled();

        $this->snapshot->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->snapshot->delete();
    }

    public function testTopicNull()
    {
        $this->assertNull($this->snapshot->topic());
    }

    public function testTopic()
    {
        $this->snapshot->___setProperty('info', [
            'topic' => 'foo',
        ]);

        $this->assertInstanceOf(Topic::class, $this->snapshot->topic());
    }

    public function testSubscriptionNull()
    {
        $this->assertNull($this->snapshot->subscription());
    }

    public function testSubscription()
    {
        $this->snapshot->___setProperty('info', [
            'subscription' => 'foo',
        ]);

        $this->assertInstanceOf(Subscription::class, $this->snapshot->subscription());
    }
}
