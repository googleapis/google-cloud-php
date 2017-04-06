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

use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class SnapshotTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'my-project';
    const NAME = 'snapshot';

    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            self::NAME,
            false
        );
    }

    public function testConstructWithFullyQualifiedName()
    {
        $snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            false
        );

        $this->assertEquals($this->snapshot->name(), $snapshot->name());
    }

    public function testName()
    {
        $this->assertEquals('projects/'. self::PROJECT .'/snapshots/'. self::NAME, $this->snapshot->name());
    }

    public function testInfo()
    {
        $snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            false,
            [
                'subscription' => 'foo',
                'topic' => 'bar',
            ]
        );

        $this->assertEquals([
            'name' => 'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            'subscription' => 'foo',
            'topic' => 'bar',
            'expirationTime' => null
        ], $snapshot->info());
    }

    public function testCreate()
    {
        $this->connection->createSnapshot(Argument::any())
            ->shouldBeCalled();

        $snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            false,
            [
                'subscription' => 'foo',
            ]
        );

        $snapshot->create();
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
            'snapshot' => 'projects/'. self::PROJECT .'/snapshots/'. self::NAME
        ]);

        $this->snapshot->setConnection($this->connection->reveal());

        $this->snapshot->delete();
    }

    public function testTopicNull()
    {
        $this->assertNull($this->snapshot->topic());
    }

    public function testTopic()
    {
        $snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            false,
            [
                'topic' => 'foo',
            ]
        );

        $this->assertInstanceOf(Topic::class, $snapshot->topic());
    }

    public function testSubscriptionNull()
    {
        $this->assertNull($this->snapshot->subscription());
    }

    public function testSubscription()
    {
        $snapshot = new SnapshotStub(
            $this->connection->reveal(),
            self::PROJECT,
            'projects/'. self::PROJECT .'/snapshots/'. self::NAME,
            false,
            [
                'subscription' => 'foo',
            ]
        );

        $this->assertInstanceOf(Subscription::class, $snapshot->subscription());
    }
}

class SnapshotStub extends Snapshot
{
    public function setConnection($c)
    {
        $this->connection = $c;
    }
}
