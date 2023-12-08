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

use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\Aggregation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 */
class AggregationQueryTest extends TestCase
{
    private $query;
    private $gqlQuery;

    public function setUp(): void
    {
        $mapper = new EntityMapper('foo', true, false);
        $this->query = new Query($mapper);
        $this->gqlQuery = new GqlQuery($mapper, 'SELECT 1');
    }

    public function testConstructorOptions()
    {
        $self = $this->query->filter('foo', '=', 'bar');
        $expectedQuery = [
            'filter' => [
                'compositeFilter' => [
                    'op' => 'AND',
                    'filters' => [
                        [
                            'propertyFilter' => [
                                'op' => 'EQUAL',
                                'property' => ['name' => 'foo'],
                                'value' => ['stringValue' => 'bar'],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $query = new AggregationQuery($self);

        $this->assertEquals($expectedQuery, $query->queryObject()['aggregationQuery']['nestedQuery']);
        $this->assertArrayHasKey('aggregations', $query->queryObject()['aggregationQuery']);
    }

    public function testConstructorOptionsWithGqlQuery()
    {
        $expectedQuery = [
            'queryString' => 'SELECT 1',
            'allowLiterals' => false
        ];

        $query = new AggregationQuery($this->gqlQuery);

        $this->assertEquals($expectedQuery, $query->queryObject()['gqlQuery']);
        $this->assertArrayNotHasKey('aggregationQuery', $query->queryObject());
    }

    public function testLimit()
    {
        $self = $this->query->limit(2);
        $this->assertInstanceOf(Query::class, $this->query);
        $expectedQuery = [
            'limit' => 2
        ];

        $query = new AggregationQuery($self);

        $this->assertEquals($expectedQuery, $query->queryObject()['aggregationQuery']['nestedQuery']);
        $this->assertArrayHasKey('aggregations', $query->queryObject()['aggregationQuery']);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAggregation($type)
    {
        $expectedQuery = [
            'aggregations' => [
                [$type => ($type == 'count' ? [] : ['property' => ['name' => 'foo']])]
            ],
            'nestedQuery' => []
        ];

        $query = new AggregationQuery($this->query);
        $query->addAggregation($type == 'count' ? Aggregation::$type() : Aggregation::$type('foo'));

        $this->assertEquals($expectedQuery, $query->queryObject()['aggregationQuery']);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAlias($type)
    {
        $expectedQuery = [
            'aggregations' => [
                [
                    $type => ($type == 'count' ? [] : ['property' => ['name' => 'foo']]),
                    'alias' => 'total'
                ]
            ],
            'nestedQuery' => []
        ];

        $query = new AggregationQuery($this->query);
        $query->addAggregation(
            ($type == 'count' ? Aggregation::$type() : Aggregation::$type('foo'))->alias('total')
        );

        $this->assertEquals($expectedQuery, $query->queryObject()['aggregationQuery']);
    }

    public function aggregationTypes()
    {
        return [
            ['count'],
            ['sum'],
            ['avg']
        ];
    }
}
