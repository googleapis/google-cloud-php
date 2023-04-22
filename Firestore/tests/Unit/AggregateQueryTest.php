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
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateQueryTest extends TestCase
{
    use ProphecyTrait;

    const QUERY_PARENT = 'projects/example_project/databases/(default)/';

    private $queryObj = [
        'from' => [
            ['collectionId' => 'foo']
        ]
    ];

    private $connection;
    private $query;
    private $aggregate;
    private $aggregateQuery;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->query = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            $this->queryObj
        ], ['connection', 'query']);
        $this->aggregate = Aggregate::count();
        $this->aggregateQuery = TestHelpers::stub(AggregateQuery::class, [
            $this->connection->reveal(),
            self::QUERY_PARENT,
            ['query' => $this->queryObj],
            $this->aggregate
        ], ['connection', 'query', 'aggregates']);
    }

    public function testGetSnapshot()
    {
        $expectedProps = [
            ['count' => []]
        ];

        $this->connection->runAggregationQuery(Argument::that(function ($args) use ($expectedProps) {
            return $expectedProps == $args['structuredAggregationQuery']['aggregations'];
        }))
            ->shouldBeCalledTimes(1)
            ->willReturn(new \ArrayIterator([[
                'result' => [
                    'aggregateFields' => [
                        'count' => ['integerValue' => 123456]
                    ]
                ]
            ]]));
        $this->aggregateQuery->___setProperty('connection', $this->connection->reveal());

        $response = $this->aggregateQuery->getSnapshot();
        $this->assertInstanceOf(AggregateQuerySnapshot::class, $response);
        $this->assertEquals(123456, $response->get('count'));
    }

    public function testAddAggregation()
    {
        $expectedProps = [
            ['count' => []],
            ['count' => [], 'alias' => 'total'],
            ['count' => [], 'alias' => 'count_with_another_alias'],
        ];
        $this->aggregateQuery->addAggregation(Aggregate::count()->alias('total'));
        $this->aggregateQuery->addAggregation(
            Aggregate::count()
            ->alias('count_with_another_alias')
        );

        $this->connection->runAggregationQuery(Argument::that(function ($args) use ($expectedProps) {
            return $expectedProps == $args['structuredAggregationQuery']['aggregations'];
        }))
            ->shouldBeCalledTimes(1)
            ->willReturn(new \ArrayIterator([]));
        $this->aggregateQuery->___setProperty('connection', $this->connection->reveal());
        $response = $this->aggregateQuery->getSnapshot();

        $this->assertInstanceOf(AggregateQuerySnapshot::class, $response);
    }
}
