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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateQueryTest extends TestCase
{
    const QUERY_PARENT = 'projects/example_project/databases/(default)/';
    const COLLECTION = 'foo';

    private $queryObj = [
        'from' => [
            ['collectionId' => self::COLLECTION]
        ]
    ];

    private $connection;
    private $query;
    private $aggregate;
    private $aggregateQuery;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->query = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            $this->queryObj
        ], ['connection', 'query']);
        $this->aggregate = Aggregate::count();
        $this->aggregateQuery = new AggregateQuery(
            $this->connection->reveal(),
            self::QUERY_PARENT,
            $this->query,
            $this->aggregate
        );
    }

    public function testAggregation()
    {
        $expectedProps = [
            ['count' => []]
        ];
        $aggregations = $this->aggregateQuery->finalQueryPrepare();

        $this->assertEquals($expectedProps, $aggregations['aggregations']);
        $this->assertArrayHasKey('structuredQuery', $aggregations);
    }

    public function testAddAggregation()
    {
        $expectedProps = [
            ['count' => []],
            ['count' => [], 'alias' => 'total'],
            ['count' => ['upTo' => ['value' => 2]], 'alias' => 'count_upto_2'],
        ];
        $this->aggregateQuery->addAggregation(Aggregate::count()->alias('total'));
        $this->aggregateQuery->addAggregation(
            Aggregate::count()
            ->alias('count_upto_2')
            ->limit(2)
        );

        $aggregations = $this->aggregateQuery->finalQueryPrepare();

        $this->assertEquals($expectedProps, $aggregations['aggregations']);
        $this->assertArrayHasKey('structuredQuery', $aggregations);
    }
}
