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

    /**
     * @dataProvider getSelectCases
     */
    public function testSelect($type, $arg, $fieldMask, $expected, $docsToAdd = [])
    {
        $this->insertDocs($docsToAdd);
        $query = $this->query->select($fieldMask);
        $this->assertQuery($query, $type, $arg, $expected);
    }

    /**
     * @dataProvider getWhereCases
     */
    public function testWhere($type, $arg, $op, $fieldValue, $expected, $docsToAdd = [])
    {
        $this->insertDocs($docsToAdd);
        $query = $this->query->where('value', $op, $fieldValue);
        $this->assertQuery($query, $type, $arg, $expected);
    }

    /**
     * @dataProvider getSnapshotCursorCases
     */
    public function testSnapshotCursors($type, $arg, $expectedResults, $docsToAdd = [])
    {
        $refs = $this->insertDocs($docsToAdd);

        $query = $this->query->orderBy('value')->startAt($refs[0]->snapshot());
        $this->assertQuery($query, $type, $arg, $expectedResults[0]);

        $query = $this->query->orderBy('value')->startAfter($refs[0]->snapshot());
        $this->assertQuery($query, $type, $arg, $expectedResults[1]);

        $query = $this->query->orderBy('value')->endBefore(end($refs)->snapshot());
        $this->assertQuery($query, $type, $arg, $expectedResults[2]);

        $query = $this->query->orderBy('value')->endAt(end($refs)->snapshot());
        $this->assertQuery($query, $type, $arg, $expectedResults[3]);
    }

    /**
     * @dataProvider getLimitCases
     */
    public function testLimits($type, $arg, $expectedResults, $docsToAdd = [])
    {
        $refs = $this->insertDocs($docsToAdd);

        $query = $this->query->orderBy('value')
            ->limitToLast(2);
        $this->assertQuery($query, $type, $arg, $expectedResults[0]);


        $query = $this->query->orderBy('value')
            ->startAt($refs[1]->snapshot())
            ->endAt($refs[3]->snapshot())
            ->limitToLast(2);
        $this->assertQuery($query, $type, $arg, $expectedResults[1]);
    }

    private function insertDocs(array $docs)
    {
        $docsRefs = [];
        foreach ($docs as $doc) {
            $docsRefs[] = $this->query->add($doc);
        }
        return $docsRefs;
    }

    private function assertQuery(Query $query, $type, $arg, $expected)
    {
        $actual = $arg ? $query->$type($arg) : $query->$type();
        $this->assertEquals($expected, $actual);
        $this->assertQueryWithMultipleAggregations($query, $type, $arg, $expected);
    }

    private function assertQueryWithMultipleAggregations(Query $query, $type, $arg, $expected)
    {
        $aggregations = [
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('a1'),
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('a2'),
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('a3')
        ];
        $expectedResults = [
            'a1' => $expected,
            'a2' => $expected,
            'a3' => $expected,
        ];
        foreach ($aggregations as $aggregation) {
            $query = $query->addAggregation($aggregation);
        }
        $expectedTimestamp = new Timestamp(new \DateTimeImmutable());

        $snapshot = $query->getSnapshot();

        foreach ($expectedResults as $k => $v) {
            $expectedResult = $v;
            $actualResult = $snapshot->get($k);
            $this->assertEquals($expectedResult, $actualResult);
        }

        $this->assertEquals(0, strlen($snapshot->getTransaction()));
        $actualTimestamp = $snapshot->getReadTime();
        $this->assertInstanceOf(Timestamp::class, $snapshot->getReadTime());
        $this->assertEqualsWithDelta(
            $expectedTimestamp->get()->getTimestamp(),
            $actualTimestamp->get()->getTimestamp(),
            100
        );
    }

    /**
     * This dataProvider returns the test cases to test how
     * aggregations work with `select()` field mask.
     *
     * The values are of the form
     * [
     *     string $aggregationType,
     *     string $targetFieldName,
     *     string $fieldMask,
     *     mixed $expectedResult,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getSelectCases()
    {
        return [
            ['count', null, ['foo', 'good'], 1, [['foo' => 'bar', 'hello' => 'world', 'good' => 'night']]],
            ['count', null, [], 1, [['foo' => 'bar']]],
        ];
    }

    /**
     * This dataProvider returns the test cases to test how
     * aggregations work with `where()` (i.e. field filter).
     *
     * The values are of the form
     * [
     *     string $aggregationType,
     *     string $targetFieldName,
     *     string $operation
     *     string $fieldValue,
     *     mixed $expectedResult,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getWhereCases()
    {
        $arrayDoc = [
            ['value' => ['foo', 'bar']],
            ['value' => ['foo']]
        ];
        $randomVal = base64_encode(random_bytes(10));
        return [
            // For testing where: equality for random value
            ['count', null, '=', $randomVal, 1, [['value' => $randomVal]]],

            // For testing where: equality for null
            ['count', null, '=', null, 1, [['value' => null]]],

            // For testing where: equality for NAN
            ['count', null, '=', NAN, 1, [['value' => NAN]]],

            // For testing where: in array
            ['count', null, 'in', [['foo']], 1, $arrayDoc],
            ['count', null, 'in', [['foo'], ['foo', 'bar']], 2, $arrayDoc],
            ['count', null, 'in', [['bar']], 0, $arrayDoc],
            ['count', null, 'in', [['foo', 'bar']], 1, $arrayDoc],
            ['count', null, 'in', [['bar', 'foo']], 0, $arrayDoc],
        ];
    }

    /**
     * This dataProvider returns the test cases to test how
     * aggregations work with `cursors`.
     *
     * The values are of the form
     * [
     *     string $aggregationType,
     *     string $targetFieldName,
     *     array $expectedResults,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getSnapshotCursorCases()
    {
        $docsToAdd = [['value' => 0], ['value' => 1], ['value' => 2], ['value' => 3]];
        return [
            ['count', null, [4, 3, 3, 4], $docsToAdd]
        ];
    }

    /**
     * This dataProvider returns the test cases to test how
     * aggregations work with `limits`.
     *
     * The values are of the form
     * [
     *     string $aggregationType,
     *     string $targetFieldName,
     *     array $expectedResults,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getLimitCases()
    {
        $docsToAdd = [['value' => 0], ['value' => 1], ['value' => 2], ['value' => 3],  ['value' => 4]];
        return [
            ['count', null, [2, 2], $docsToAdd]
        ];
    }
}
