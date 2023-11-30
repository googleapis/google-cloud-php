<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Aggregation;

/**
 * @group datastore
 * @group datastore-query
 */
class AggregationQueryTest extends DatastoreMultipleDbTestCase
{
    private static $kind;
    private static $data = [
        ['score' => 1],
        ['score' => 2],
        ['score' => 3],
        ['score' => 4],
        ['maxScore' => PHP_FLOAT_MAX],
        ['maxScore' => PHP_FLOAT_MAX],
        ['minScore' => -PHP_FLOAT_MAX],
        ['minScore' => -PHP_FLOAT_MAX],
        ['nullScore' => null],
        ['nanScore' => NAN],
        ['arrayScore' => [1, 2, 3]],
        ['arrayScore' => [10]]
    ];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$kind = uniqid('testKind');
        $keys = self::$restClient->keys(self::$kind, ['number' => count(self::$data)]);
        $keys = self::$restClient->allocateIds($keys);
        foreach ($keys as $count => $key) {
            self::$restClient->insert(self::$restClient->entity($key, self::$data[$count]));
        }

        // on rare occasions the queries below are returning no results when
        // triggered immediately after an insert operation. the sleep here
        // is intended to help alleviate this issue.
        sleep(1);

        foreach ($keys as $key) {
            self::$localDeletionQueue->add($key);
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::tearDownFixtures();
    }

    /**
     * @dataProvider filterCases
     */
    public function testQueryShouldFailForIncorrectAlias(
        DatastoreClient $client,
        $type,
        $property,
        $expected
    ) {
        $this->skipEmulatorTests();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('alias does not exist');
        $aggregation = (is_null($property) ? Aggregation::$type() : Aggregation::$type($property));
        $aggregationQuery = $client->query()
            ->kind(self::$kind)
            ->aggregation($aggregation);

        $results = $client->runAggregationQuery($aggregationQuery);

        $results->get('total');
    }

    /**
     * @dataProvider filterCases
     * @dataProvider cornerCases
     */
    public function testQueryWithFilter(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $aggregation = (is_null($property) ? Aggregation::$type() : Aggregation::$type($property));
        $aggregationQuery = $client->query()
            ->kind(self::$kind)
            ->aggregation($aggregation->alias('result'));

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('result'));
    }

    /**
     * @dataProvider filterCases
     */
    public function testOverQueryWithFilter(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $aggregation = (is_null($property) ? Aggregation::$type() : Aggregation::$type($property));
        $query = $client->query()
            ->kind(self::$kind);
        $aggregationQuery = $client->aggregationQuery()
            ->over($query)
            ->addAggregation($aggregation);

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('property_1'));
    }

    /**
     * @dataProvider filterCases
     */
    public function testGqlQueryWithFilter(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $aggregationQuery = $client->gqlQuery(
            sprintf("SELECT %s(%s) as result From %s", $type, ($property ?? '*'), self::$kind),
            ['allowLiterals' => true]
        )->aggregation();

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('result'));
    }

    /**
     * @dataProvider filterCases
     */
    public function testOverGqlQueryWithFilter(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $query = $client->gqlQuery(
            sprintf(
                "AGGREGATE %s(%s) as result OVER"
                . " (SELECT * FROM %s)",
                $type,
                ($property ?? '*'),
                self::$kind
            )
        );
        $aggregationQuery = $client->aggregationQuery()
            ->over($query);

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('result'));
    }

    /**
     * @dataProvider limitCases
     */
    public function testQueryWithLimit(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $aggregation = (is_null($property) ? Aggregation::$type() : Aggregation::$type($property));
        $query = $client->query()
            ->kind(self::$kind)
            ->limit(2);
        $aggregationQuery = $client->aggregationQuery()
            ->over($query)
            ->addAggregation($aggregation->alias('result'));

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('result'));
    }

    /**
     * @dataProvider limitCases
     */
    public function testGqlQueryWithLimit(DatastoreClient $client, $type, $property, $expected)
    {
        $this->skipEmulatorTests();
        $queryString = sprintf(
            "AGGREGATE
                %s(%s) AS result
            OVER (
                SELECT * From %s LIMIT 2
            )",
            $type,
            ($property ?? '*'),
            self::$kind
        );
        $query = $client->gqlQuery(
            $queryString,
            ['allowLiterals' => true]
        );
        $aggregationQuery = $client->aggregationQuery()
            ->over($query);

        $results = $client->runAggregationQuery($aggregationQuery);

        $this->compareResult($expected, $results->get('result'));
    }

    /**
     * @dataProvider multipleAggregationCases
     */
    public function testQueryWithMultipleAggregations(
        DatastoreClient $client,
        $types,
        $properties,
        $expected
    ) {
        $this->skipEmulatorTests();
        $query = $client->query()
            ->kind(self::$kind);
        $aggregationQuery = $client->aggregationQuery()
            ->over($query);
        foreach ($types as $type) {
            $aggregationQuery->addAggregation(
                (
                    is_null($properties[$type])
                    ? Aggregation::$type()
                    : Aggregation::$type($properties[$type])
                )->alias($type)
            );
        }

        $results = $client->runAggregationQuery($aggregationQuery);

        foreach ($types as $type) {
            $this->compareResult($expected[$type], $results->get($type));
        }
    }

    /**
     * @dataProvider multipleAggregationCases
     */
    public function testGqlQueryWithMultipleAggregations(
        DatastoreClient $client,
        $types,
        $properties,
        $expected
    ) {
        $this->skipEmulatorTests();
        $aggregateString = '';
        foreach ($types as $type) {
            $str = sprintf('%s(%s) AS %sResult', $type, ($properties[$type] ?? '*'), $type);
            if (!empty($aggregateString)) {
                $aggregateString .= ', ';
            }
            $aggregateString .= $str;
        }
        $queryString = sprintf(
            "AGGREGATE %s OVER (SELECT * From %s)",
            $aggregateString,
            self::$kind
        );
        $query = $client->gqlQuery(
            $queryString,
            ['allowLiterals' => true]
        );
        $aggregationQuery = $client->aggregationQuery()
            ->over($query);

        $results = $client->runAggregationQuery($aggregationQuery);

        foreach ($types as $type) {
            $this->compareResult($expected[$type], $results->get($type . 'Result'));
        }
    }

    /**
     * Each case is of the format:
     * [
     *      // Datastore client
     *      DatastoreClient $client,
     *
     *      // Aggregation Type to test
     *      string $type,
     *
     *      // Property to aggregate upon
     *      string $property
     *
     *      // Expected result
     *      mixed $expected
     * ]
     */
    public function filterCases()
    {
        $clients = $this->defaultDbClientProvider();
        $cases = [];
        foreach ($clients as $name => $client) {
            $client = $client[0];
            $cases[] = [$client, 'count', null, count(self::$data)];
            $cases[] = [$client, 'sum', 'score', 10];
            $cases[] = [$client, 'avg', 'score', 2.5];
        }
        return $cases;
    }

    /**
     * Each case is of the format:
     * [
     *      // Datastore client
     *      DatastoreClient $client,
     *
     *      // Aggregation Type to test
     *      string $type,
     *
     *      // Property to aggregate upon
     *      string $property
     *
     *      // Expected results
     *      array $expected
     * ]
     */
    public function limitCases()
    {
        $clients = $this->defaultDbClientProvider();
        $cases = [];
        foreach ($clients as $name => $client) {
            $client = $client[0];
            $cases[] = [$client, 'count', null, 2];
            $cases[] = [$client, 'sum', 'score', 3];
            $cases[] = [$client, 'avg', 'score', 1.5];
        }
        return $cases;
    }

    /**
     * Each case is of the format:
     * [
     *      // Datastore client
     *      DatastoreClient $client,
     *
     *      // Aggregation Type to test
     *      string $type,
     *
     *      // Property to aggregate upon
     *      string $property
     *
     *      // Expected results
     *      array $expected
     * ]
     */
    public function cornerCases()
    {
        $clients = $this->defaultDbClientProvider();

        // An array of the format:
        // ['casename' => [expectedSum, expectedAvg], ...]
        $caseNamesWithExpectedValues = [
            'max' => [INF, INF],
            'min' => [-INF, -INF],
            'null' => [0, null],
            'nan' => [NAN, NAN],

            // Datastore considers each value of array type as single
            // element (on contrary, firestore considers array type as
            // non numeric data type and ignores for sum / avg)
            'array' => [16, 4.0],
        ];
        $cases = [];
        foreach ($clients as $name => $client) {
            $client = $client[0];
            foreach ($caseNamesWithExpectedValues as $name => $expected) {
            // These corner cases are not applicable for COUNT hence omitted.
                $cases[] = [$client, 'sum', $name . 'Score', $expected[0]];
                $cases[] = [$client, 'avg', $name . 'Score', $expected[1]];
            }
        }
        return $cases;
    }

    /**
     * Each case is of the format:
     * [
     *      // Datastore client
     *      DatastoreClient $client,
     *
     *      // Aggregation Types to test
     *      array $types,
     *
     *      // Properties of respective aggregates of the format [$type1 => $property1, $type2 => $property2...]
     *      string $properties
     *
     *      // Expected results of the format [$type1 => $result1, $type2 => $result2...]
     *      array $expected
     * ]
     */
    public function multipleAggregationCases()
    {
        $clients = $this->defaultDbClientProvider();
        $cases = [];
        foreach ($clients as $name => $client) {
            $cases[] = [
                $client[0],
                ['count', 'sum', 'avg'],
                [
                    'count' => null,
                    'sum' => 'score',
                    'avg' => 'score'
                ],
                [
                    'count' => 4,
                    'sum' => 10,
                    'avg' => 2.5
                ]
            ];
        }
        return $cases;
    }

    private function compareResult($expected, $actual)
    {
        if (is_float($expected)) {
            if (is_nan($expected)) {
                $this->assertNan($actual);
            } else {
                $this->assertEqualsWithDelta($expected, $actual, 0.01);
            }
        } else {
            // Used because assertEquals(null, '') doesn't fails
            $this->assertSame($expected, $actual);
        }
    }
}
