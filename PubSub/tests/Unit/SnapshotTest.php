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

namespace Google\Cloud\Tests\Unit\Pubsub;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class SnapshotTest extends TestCase
{
    const PROJECT = 'my-project';
    const SNAPSHOT_ID = 'snapshot';

    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = TestHelpers::stub(Snapshot::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::SNAPSHOT_ID,
            false
        ], ['connection', 'info']);
    }

    public function testConstructWithFullyQualifiedName()
    {
        $snapshot = TestHelpers::stub(Snapshot::class, [
            $this->connection->reveal(),
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
        $this->connection->createSnapshot(Argument::any())
            ->shouldBeCalled();

        $info = [
            'subscription' => 'foo',
        ];

        $this->snapshot->___setProperty('info', $info);

        $this->snapshot->___setProperty('connection', $this->connection->reveal());

        $this->snapshot->create();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testCreateWithoutSubscription()
    {
        $this->snapshot->create();
    }

    public function testDelete()
    {
        $this->connection->deleteSnapshot([
            'snapshot' => 'projects/'. self::PROJECT .'/snapshots/'. self::SNAPSHOT_ID
        ]);

        $this->snapshot->___setProperty('connection', $this->connection->reveal());

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
