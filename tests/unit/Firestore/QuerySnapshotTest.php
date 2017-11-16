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

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-querysnapshot
 */
class QuerySnapshotTest extends TestCase
{
    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = \Google\Cloud\Dev\stub(QuerySnapshot::class, [
            $this->prophesize(Query::class)->reveal(),
            []
        ], ['rows']);
    }

    public function testIsEmptyReturnsFalse()
    {
        $this->snapshot->___setProperty('rows', [[]]);

        $this->assertFalse($this->snapshot->isEmpty());
    }

    public function testIsEmptyReturnsTrue()
    {
        $this->snapshot->___setProperty('rows', []);

        $this->assertTrue($this->snapshot->isEmpty());
    }

    public function testSize()
    {
        $this->snapshot->___setProperty('rows', []);
        $this->assertEquals(0, $this->snapshot->size());

        $this->snapshot->___setProperty('rows', [[], []]);
        $this->assertEquals(2, $this->snapshot->size());
    }

    public function testRows()
    {
        $rows = [
            'foo', 'bar'
        ];
        $this->snapshot->___setProperty('rows', $rows);

        $this->assertEquals($rows, $this->snapshot->rows());
    }

    public function testIterator()
    {
        $rows = [
            'foo', 'bar'
        ];
        $this->snapshot->___setProperty('rows', $rows);

        $this->assertEquals($rows, iterator_to_array($this->snapshot));
    }
}
