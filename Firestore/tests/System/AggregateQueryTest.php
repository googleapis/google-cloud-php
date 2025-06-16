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

use Exception;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Filter;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\V1\ExplainOptions;
use InvalidArgumentException;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateQueryTest extends FirestoreTestCase
{
    private CollectionReference $query;

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

    /**
     * @dataProvider getMultipleAggregationCases
     */
    public function testMultipleAggregationsOverDifferentFields($aggregates, $expectedResults, $docsToAdd = [])
    {
        $this->insertDocs($docsToAdd);

        $query = $this->query;
        foreach ($aggregates as $aggregate) {
            $query = $query->addAggregation($aggregate);
        }

        $querySnapshot = $query->getSnapshot();
        foreach ($expectedResults as $key => $value) {
            $this->compareResult($value, $querySnapshot->get($key));
        }
    }

    private function insertDocs(array $docs)
    {
        $docsRefs = [];
        foreach ($docs as $doc) {
            $docsRefs[] = $this->query->add($doc);
        }
        return $docsRefs;
    }

    private function compareResult($expected, $actual)
    {
        if (!is_null($expected) && is_nan($expected)) {
            $this->assertNan($actual);
        } elseif (is_double($expected)) {
            $this->assertEqualsWithDelta($expected, $actual, 0.01);
        } else {
            $this->assertEquals($expected, $actual);
        }
    }

    private function assertQuery(Query $query, $type, $arg, $expected)
    {
        if ($expected instanceof Exception) {
            $this->expectException(get_class($expected));
            $this->expectExceptionMessage($expected->getMessage());
        }

        $actual = $arg ? $query->$type($arg) : $query->$type();

        $this->compareResult($expected, $actual);
        $this->assertQueryWithMultipleAggregations($query, $type, $arg, $expected);
    }

    private function assertQueryWithMultipleAggregations(Query $query, $type, $arg, $expected)
    {
        if ($expected instanceof Exception) {
            $this->expectException(get_class($expected));
            $this->expectExceptionMessage($expected->getMessage());
        }

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

        foreach ($expectedResults as $key => $expectedResult) {
            $actualResult = $snapshot->get($key);
            $this->compareResult($expected, $actualResult);
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

    public function testAggregationExplainOptionsWithAnalyzeFalseReturnsPlanSummaryOnly()
    {
        $docsToAdd = [['foo' => 'bar', 'hello' => 'world', 'good' => 'night']];

        $this->insertDocs($docsToAdd);
        $query = $this->query->where('foo', '=', 'bar');
        $aggregationQuery = $query->addAggregation(Aggregate::count()->alias('total'));

        $explainOptions = new ExplainOptions();
        $explainOptions->setAnalyze(false);

        $result = $aggregationQuery->getSnapshot([
            'explainOptions' => $explainOptions
        ]);

        $explainMetrics = $result->getExplainMetrics();

        $this->assertNotNull($explainMetrics);
        $this->assertNotNull($explainMetrics->getPlanSummary());
        $this->assertNull($explainMetrics->getExecutionStats());

        // When setting the ExplainOptions::analyze to false, the 'total' alias
        // should be empty. The AggregateQuerySnapshot::get() method
        // throws an error when the alias is not found
        $this->expectException(InvalidArgumentException::class);
        $result->get('total');
    }

    public function testAggregationExplainOptionsWithAnalyzeTrueReturnsAll()
    {
        $docsToAdd = [['foo' => 'bar', 'hello' => 'world', 'good' => 'night']];

        $this->insertDocs($docsToAdd);
        $query = $this->query->where('foo', '=', 'bar');
        $aggregationQuery = $query->addAggregation(Aggregate::count()->alias('total'));

        $explainOptions = new ExplainOptions();
        $explainOptions->setAnalyze(true);

        $result = $aggregationQuery->getSnapshot([
            'explainOptions' => $explainOptions
        ]);

        $explainMetrics = $result->getExplainMetrics();

        $this->assertNotNull($explainMetrics);
        $this->assertNotNull($explainMetrics->getPlanSummary());
        $this->assertNotNull($explainMetrics->getExecutionStats());
        $this->assertEquals($result->get('total'), 1);
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
     *     mixed $expectedResult, // can also be instance of Exception
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getSelectCases()
    {
        return [
            // With mask
            [
                'count',
                null,
                ['foo', 'good'],
                1,
                [['foo' => 'bar', 'hello' => 'world', 'good' => 'night']]
            ],
            [
                'sum',
                'foo',
                ['foo'],
                new BadRequestException('Cannot apply property masks when aggregation fields are present.'),
                [['foo' => 1, 'zoo' => 100], ['foo' => 2, 'zoo' => 200]]
            ],
            [
                'avg',
                'foo',
                ['foo'],
                new BadRequestException('Cannot apply property masks when aggregation fields are present.'),
                [['foo' => 1, 'zoo' => 100], ['foo' => 2, 'zoo' => 200]]
            ],

            // With empty mask
            [
                'count',
                null,
                [], 1,
                [['foo' => 'bar']]
            ],
            [
                'sum',
                'foo',
                [],
                new BadRequestException(
                    'Aggregation over non-key properties is not supported for base query that only returns keys.'
                ),
                [['foo' => 1, 'zoo' => 100], ['foo' => 2, 'zoo' => 200]]
            ],
            [
                'avg',
                'foo',
                [],
                new BadRequestException(
                    'Aggregation over non-key properties is not supported for base query that only returns keys'
                ),
                [['foo' => 1, 'zoo' => 100], ['foo' => 2, 'zoo' => 200]]
            ]
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
        $numDoc = [
            ['value' => [1, 2]],
            ['value' => [30]]
        ];
        $maxValueExceedDoc = [
            ['value' => PHP_FLOAT_MAX],
            ['value' => PHP_FLOAT_MAX]
        ];
        $randomVal = base64_encode(random_bytes(10));
        $randomInt = random_int(1, PHP_INT_MAX);
        return [
            // For testing where: equality for random value
            ['count', null, '=', $randomVal, 1, [['value' => $randomVal]]],
            ['sum', 'value', '=', $randomInt, $randomInt, [['value' => $randomInt]]],
            ['avg', 'value', '=', $randomInt, $randomInt, [['value' => $randomInt]]],

            // For testing where: equality for null
            ['count', null, '=', null, 1, [['value' => null]]],
            ['sum', 'value', '=', null, 0, [['value' => null]]],
            ['avg', 'value', '=', null, null, [['value' => null]]],

            // For testing where: equality for NAN
            ['count', null, '=', NAN, 1, [['value' => NAN]]],
            ['sum', 'value', '=', NAN, NAN, [['value' => NAN]]],
            ['avg', 'value', '=', NAN, NAN, [['value' => NAN]]],

            // For testing where: in array
            ['count', null, 'in', [['foo']], 1, $arrayDoc],
            ['count', null, 'in', [['foo'], ['foo', 'bar']], 2, $arrayDoc],
            ['count', null, 'in', [['bar', 'foo']], 0, $arrayDoc],
            // Array is considered non numeric for Sum and Avg
            ['sum', 'value', 'in', [[1, 2]], 0, $numDoc],
            ['avg', 'value', 'in', [[1, 2]], null, $numDoc],

            // For testing aggregation on empty query set
            ['sum', 'value', '=', 'non_existent', 0, []],
            ['avg', 'value', '=', 'non_existent', null, []],

            // When sum is greater than FLOAT_MAX
            ['sum', 'value', '>', 0, INF, $maxValueExceedDoc],
            ['avg', 'value', '>', 0, INF, $maxValueExceedDoc],
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
        $docsToAdd = [
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
            ['value' => 4]
        ];
        return [
            ['count', null, [4, 3, 3, 4], $docsToAdd],
            ['sum', 'value', [10, 9, 6, 10], $docsToAdd],
            ['avg', 'value', [2.5, 3, 2, 2.5], $docsToAdd]
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
        $docsToAdd = [
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
            ['value' => 4],
            ['value' => 5]
        ];
        return [
            ['count', null, [2, 2], $docsToAdd],
            ['sum', 'value', [9, 7], $docsToAdd],
            ['avg', 'value', [4.5, 3.5], $docsToAdd]
        ];
    }

    /**
     * This dataProvider returns the test cases to test how
     * multiple aggregations work with multiple fields.
     *
     * The values are of the form
     * [
     *     array<Aggregate> $aggregates,
     *     array $expectedResults,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getMultipleAggregationCases()
    {
        $docsToAdd = [
            ['key1' => 1, 'key2' => 2],
            ['key1' => 3, 'key2' => 4],
            ['key1' => 10],
            ['key1' => 20],
            ['key2' => 100],
        ];
        $case1 = [
            Aggregate::count()->alias('count'),
            Aggregate::avg('key2')->alias('avg'),
        ];
        $case2 = [
            Aggregate::count()->alias('count'),
            Aggregate::sum('key1')->alias('sum'),
        ];
        $case3 = [
            Aggregate::count()->alias('count'),
            Aggregate::sum('key1')->alias('sum'),
            Aggregate::avg('key1')->alias('avg'),
        ];

        return [
            [$case1, ['count' => 3, 'avg' => 35.33], $docsToAdd],
            [$case2, ['count' => 4, 'sum' => 34], $docsToAdd],
            [$case3, ['count' => 4, 'sum' => 34, 'avg' => 8.5], $docsToAdd]
        ];
    }
}
