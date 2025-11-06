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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-querysnapshot
 */
class QuerySnapshotTest extends TestCase
{
    use ProphecyTrait;

    public function testIsEmptyReturnsFalse()
    {
        $snapshot = $this->getQuerySnapshot([[]]);
        $this->assertFalse($snapshot->isEmpty());
    }

    public function testIsEmptyReturnsTrue()
    {
        $snapshot = $this->getQuerySnapshot();
        $this->assertTrue($snapshot->isEmpty());
    }

    public function testSize()
    {
        $snapshot = $this->getQuerySnapshot();
        $this->assertEquals(0, $snapshot->size());

        $twoArraySnapshot = $this->getQuerySnapshot([[], []]);
        $this->assertEquals(2, $twoArraySnapshot->size());
    }

    public function testRows()
    {
        $rows = [
            'foo', 'bar'
        ];
        $snapshot = $this->getQuerySnapshot($rows);

        $this->assertEquals($rows, $snapshot->rows());
    }

    public function testIterator()
    {
        $rows = [
            'foo', 'bar'
        ];
        $snapshot = $this->getQuerySnapshot($rows);

        $this->assertEquals($rows, iterator_to_array($snapshot));
    }

    private function getQuerySnapshot(array $rows = []): QuerySnapshot
    {
        $query = $this->prophesize(Query::class);
        return new QuerySnapshot($query->reveal(), $rows);
    }
}
