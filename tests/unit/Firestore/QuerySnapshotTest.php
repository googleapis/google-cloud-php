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

namespace Google\Cloud\Tests\Unit\Firestore;

use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-querysnapshot
 */
class QuerySnapshotTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = \Google\Cloud\Dev\stub(QuerySnapshot::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            $this->prophesize(Query::class)->reveal(),
            function() {}
            ], ['connection', 'call']);
    }

    public function testIsEmptyReturnsFalse()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => 'foo',
                        'fields' => []
                    ],
                    'readTime' => ['seconds' => time()]
                ]
            ]));

        $this->setCall($this->connection->reveal());

        $this->snapshot->rows()->current();

        $this->assertFalse($this->snapshot->isEmpty());
    }

    public function testIsEmptyReturnsTrue()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                []
            ]));

        $this->setCall($this->connection->reveal());

        $this->snapshot->rows()->current();

        $this->assertTrue($this->snapshot->isEmpty());
    }

    public function testSize()
    {
        $this->assertNull($this->snapshot->size());
    }

    public function testSizeWithCount()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => 'foo',
                        'fields' => []
                    ],
                    'readTime' => ['seconds' => time()]
                ]
            ]));

        $this->setCall($this->connection->reveal());

        $this->snapshot->rows()->current();
        $this->assertEquals(1, $this->snapshot->size());
    }

    public function testIterate()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => 'foo',
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ],
                    'readTime' => ['seconds' => time()]
                ], [
                    'document' => [
                        'name' => 'bar',
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'google'
                            ]
                        ]
                    ],
                    'readTime' => ['seconds' => time()]
                ]
            ]));

        $this->setCall($this->connection->reveal());

        $hellos = [];
        foreach ($this->snapshot as $row) {
            $hellos[] = $row['hello'];
        }

        $this->assertEquals(['world', 'google'], $hellos);
    }

    public function testRows()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => 'foo',
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ],
                    'readTime' => ['seconds' => time()]
                ], [
                    'document' => [
                        'name' => 'bar',
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'google'
                            ]
                        ]
                    ],
                    'readTime' => ['seconds' => time()]
                ]
            ]));

        $this->setCall($this->connection->reveal());

        $hellos = [];
        foreach ($this->snapshot->rows() as $row) {
            $hellos[] = $row['hello'];
        }

        $this->assertEquals(['world', 'google'], $hellos);
    }

    private function setCall(ConnectionInterface $conn)
    {
        $this->snapshot->___setProperty('call', function () use ($conn) {
            return $conn->runQuery([]);
        });
    }
}
