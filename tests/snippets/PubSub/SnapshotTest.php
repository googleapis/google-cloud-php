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

namespace Google\Cloud\Tests\Snippets\PubSub;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class SnapshotTest extends SnippetTestCase
{
    const PROJECT = 'my-awesome-project';
    const SNAPSHOT = 'projects/my-awesome-project/snapshots/my-snapshot';

    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = \Google\Cloud\Dev\stub(Snapshot::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::SNAPSHOT,
            false,
            [
                'topic' => 'foo',
                'subscription' => 'bar'
            ]
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Snapshot::class);
        $snippet->addLocal('snapshotName', self::SNAPSHOT);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
        $this->assertEquals(self::SNAPSHOT, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'name');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke();
        $this->assertEquals(self::SNAPSHOT, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'info');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->returnVal()['topic']);
    }

    public function testCreate()
    {
        $info = [
            'topic' => 'foo',
            'subscription' => 'bar'
        ];

        $this->connection->createSnapshot(Argument::any())
            ->shouldBeCalled()
            ->willReturn($info);

        $this->snapshot->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Snapshot::class, 'create');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testDelete()
    {
        $this->connection->deleteSnapshot(Argument::any())
            ->shouldBeCalled();

        $this->snapshot->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Snapshot::class, 'delete');
        $snippet->addLocal('snapshot', $this->snapshot);

        $snippet->invoke();
    }

    public function testTopic()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'topic');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'subscription');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }
}
