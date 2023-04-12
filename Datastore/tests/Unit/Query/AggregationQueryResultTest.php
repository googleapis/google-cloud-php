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
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Query\Query;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 */
class AggregationQueryResultTest extends TestCase
{
    private $aggregationQueryResult;

    public function setUp(): void
    {
        $this->aggregationQueryResult = TestHelpers::stub(
            AggregationQueryResult::class,
            [],
            [
                'query',
                'aggregationResults',
            ]
        );
    }

    public function testGetQueryAllowsNullValues()
    {
        $this->assertNull($this->aggregationQueryResult->getQuery());
    }

    public function testGetQueryAllowsNonNullValues()
    {
        $mapper = new EntityMapper('foo', true, false);
        $query = new Query($mapper);
        $this->aggregationQueryResult->___setProperty('query', $query);
        $this->assertNotNull($this->aggregationQueryResult->getQuery());
        $this->assertEquals($query, $this->aggregationQueryResult->getQuery());
    }

    public function testGetThrowsForInvalidKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('alias does not exist');
        $this->aggregationQueryResult->___setProperty('aggregationResults', [
            [
                'aggregateProperties' => [
                    'alias' => 1
                ]
            ]
        ]);

        $this->aggregationQueryResult->get('non_existing_alias');
    }

    public function testGetReturnsForValidKey()
    {
        $this->aggregationQueryResult->___setProperty('aggregationResults', [
            [
                'aggregateProperties' => [
                    'alias1' => 1,
                    'alias2' => 2,
                    'alias3' => 3,
                ]
            ]
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $this->assertEquals($i, $this->aggregationQueryResult->get('alias' . $i));
        }
    }

    public function testGetReadTime()
    {
        $expectedTime = (new \DateTime)->format('Y-m-d\TH:i:s') .'.000001Z';
        $this->aggregationQueryResult = TestHelpers::stub(
            AggregationQueryResult::class,
            [
                [
                    'batch' => ['readTime' => $expectedTime]
                ]
            ]
        );

        $actualReadTime = $this->aggregationQueryResult->getReadTime();
        $this->assertEquals($expectedTime, $actualReadTime);
    }

    public function testGetTransaction()
    {
        $expectedTransaction = 'some-transaction';
        $this->aggregationQueryResult = TestHelpers::stub(
            AggregationQueryResult::class,
            [
                [
                    'transaction' => $expectedTransaction
                ]
            ]
        );

        $actualTransaction = $this->aggregationQueryResult->getTransaction();
        $this->assertEquals($expectedTransaction, $actualTransaction);
    }
}
