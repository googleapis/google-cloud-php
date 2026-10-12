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

namespace Google\Cloud\Datastore\Tests\Unit\Query;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Query\Query;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class AggregationQueryResultTest extends TestCase
{
    use ProphecyTrait;

    private EntityMapper $mapper;

    public function setUp(): void
    {
        $this->mapper = $this->prophesize(EntityMapper::class)->reveal();
    }

    public function testGetQueryAllowsNullValues()
    {
        $aggregationQueryResult = new AggregationQueryResult([], $this->mapper);
        $this->assertNull($aggregationQueryResult->getQuery());
    }

    public function testGetQueryAllowsNonNullValues()
    {
        $query = [
            'nestedQuery' => null,
            'aggregations' => [],
        ];
        $aggregationQueryResult = new AggregationQueryResult(['query' => $query], $this->mapper);
        $this->assertEquals(new AggregationQuery(...array_values($query)), $aggregationQueryResult->getQuery());
    }

    public function testGetThrowsForInvalidKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('alias does not exist');

        $aggregationResults = [
            [
                'aggregateProperties' => [
                    'alias' => 1
                ]
            ]
        ];
        $aggregationQueryResult = new AggregationQueryResult(
            [
                'batch' => [
                    'aggregationResults' => $aggregationResults
                ]
            ],
            $this->mapper
        );
        $aggregationQueryResult->get('non_existing_alias');
    }

    public function testGetReturnsForValidKey()
    {
        $aggregationResults = [
            [
                'aggregateProperties' => [
                    'alias1' => 1,
                    'alias2' => 2,
                    'alias3' => 3,
                ]
            ]
        ];
        $aggregationQueryResult = new AggregationQueryResult(
            [
                'batch' => [
                    'aggregationResults' => $aggregationResults
                ]
            ],
            $this->mapper
        );

        for ($i = 1; $i <= 3; $i++) {
            $this->assertEquals($i, $aggregationQueryResult->get('alias' . $i));
        }
    }

    public function testGetReadTime()
    {
        $expectedTime = new Timestamp(new \DateTime);
        $aggregationQueryResult = new AggregationQueryResult(
            [
                'batch' => ['readTime' => $expectedTime]
            ],
            $this->mapper
        );

        $actualReadTime = $aggregationQueryResult->getReadTime();
        $this->assertEquals($expectedTime, $actualReadTime);
    }

    public function testGetTransaction()
    {
        $expectedTransaction = 'some-transaction';
        $aggregationQueryResult = new AggregationQueryResult(
            [
                'transaction' => $expectedTransaction
            ],
            $this->mapper
        );

        $actualTransaction = $aggregationQueryResult->getTransaction();
        $this->assertEquals($expectedTransaction, $actualTransaction);
    }
}
