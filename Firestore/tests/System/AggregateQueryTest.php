<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\Query;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateQueryTest extends FirestoreTestCase
{
    private $query;

    public function setUp(): void
    {
        $this->query = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($this->query);
    }

    public function testSelect()
    {
        $this->insertDoc([
            'foo' => 'bar',
            'hello' => 'world',
            'good' => 'night'
        ]);

        $query = $this->query->select(['foo', 'good']);

        $this->assertQueryCount($query, 1);
    }

    public function testSelectEmpty()
    {
        $this->insertDoc([
            'foo' => 'bar'
        ]);

        $query = $this->query->select([]);

        $this->assertQueryCount($query, 1);
    }

    public function testWhere()
    {
        $randomVal = base64_encode(random_bytes(10));
        $this->insertDoc([
            'foo' => $randomVal
        ]);

        $query = $this->query->where('foo', '=', $randomVal);
        $this->assertQueryCount($query, 1);
    }

    public function testWhereNull()
    {
        $this->insertDoc([
            'foo' => null
        ]);

        $query = $this->query->where('foo', '=', null);
        $this->assertQueryCount($query, 1);
    }

    public function testWhereNan()
    {
        $this->insertDoc([
            'foo' => NAN
        ]);

        $query = $this->query->where('foo', '=', NAN);
        $this->assertQueryCount($query, 1);
    }

    public function testWhereInArray()
    {
        $name = $this->query->name();
        $this->insertDoc([
            'foos' => ['foo', 'bar'],
        ]);
        $this->insertDoc([
            'foos' => ['foo'],
        ]);

        $docs = self::$client->collection($name)->where('foos', 'in', [['foo']]);
        $this->assertQueryCount($docs, 1);
        $docs = self::$client->collection($name)->where('foos', 'in', [['bar']]);
        $this->assertQueryCount($docs, 0);
        $docs = self::$client->collection($name)->where('foos', 'in', [['foo', 'bar']]);
        $this->assertQueryCount($docs, 1);
        $docs = self::$client->collection($name)->where('foos', 'in', [['bar', 'foo']]);
        $this->assertQueryCount($docs, 0);
    }

    public function testSnapshotCursors()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);

        $refs = [];
        for ($i = 0; $i <= 3; $i++) {
            $doc = $collection->document($i);
            $doc->create(['i' => $i]);
            $refs[] = $doc;
        }

        $q = $collection->startAt($refs[0]->snapshot());
        $this->assertQueryCount($q, count($refs));

        $q = $collection->startAfter($refs[0]->snapshot());
        $this->assertQueryCount($q, count($refs)-1);

        $q = $collection->endBefore(end($refs)->snapshot());
        $this->assertQueryCount($q, count($refs)-1);

        $q = $collection->endAt(end($refs)->snapshot());
        $this->assertQueryCount($q, count($refs));
    }

    public function testLimitToLast()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        for ($i = 1; $i <= 5; $i++) {
            $collection->add(['i' => $i]);
        }

        $q = $collection->orderBy('i')
            ->limitToLast(2);

        $this->assertQueryCount($q, 2);
    }

    public function testLimitToLastWithCursors()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        for ($i = 1; $i <= 5; $i++) {
            $collection->add(['i' => $i]);
        }

        $q = $collection->orderBy('i')
            ->startAt([2])
            ->endAt([4])
            ->limitToLast(5);

        $this->assertQueryCount($q, 3);
    }

    private function insertDoc(array $fields)
    {
        return $this->query->add($fields);
    }

    private function assertQueryCount(Query $query, $expectedCount)
    {
        $actualCount = $query->count();
        $this->assertEquals($expectedCount, $actualCount);

        $this->assertQueryCountWithMultipleAggregations($query, $expectedCount);
    }

    private function assertQueryCountWithMultipleAggregations(
        Query $query,
        $expectedCount
    ) {
        $aggregations = [
            Aggregate::count()->alias('count'),
            Aggregate::count()->alias('count_with_alias_a'),
            Aggregate::count()->alias('count_with_alias_b'),
        ];
        $expectedCounts = [
            'count' => $expectedCount,
            'count_with_alias_a' => $expectedCount,
            'count_with_alias_b' => $expectedCount,
        ];
        foreach ($aggregations as $aggregation) {
            $query = $query->addAggregation($aggregation);
        }
        $expectedTimestamp = new Timestamp(new \DateTimeImmutable());

        $snapshot = $query->getSnapshot();

        foreach ($expectedCounts as $k => $v) {
            $expectedCount = $v;
            $actualCount = $snapshot->get($k);
            $this->assertEquals($expectedCount, $actualCount);
        }

        $this->assertEquals(0, strlen($snapshot->getTransaction()));
        $actualTimestamp = $snapshot->getReadTime();
        $this->assertInstanceOf(Timestamp::class, $snapshot->getReadTime());
        $this->assertEqualsWithDelta(
            $expectedTimestamp->get()->getTimestamp(),
            $actualTimestamp->get()->getTimestamp(),
            10
        );
    }
}
