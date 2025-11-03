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

use ArrayIterator;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\Serializer;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\RunAggregationQueryRequest;
use Google\Cloud\Firestore\V1\RunAggregationQueryResponse;
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

    private $gapicClient;
    private $query;
    private $aggregate;
    private $aggregateQuery;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->query = new Query(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            self::QUERY_PARENT,
            $this->queryObj
        );
        $this->aggregate = Aggregate::count();
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testGetSnapshot($type, $arg, $expected)
    {
        $aggregate = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $aggregateQuery = new AggregateQuery(
            $this->gapicClient->reveal(),
            self::QUERY_PARENT,
            ['query' => $this->queryObj],
            $aggregate
        );


        $response = new RunAggregationQueryResponse();
        $response->mergeFromJsonString(json_encode([
            'result' => [
                'aggregateFields' => [
                    $type => ['integerValue' => 123456]
                ]
            ]
        ]));
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new ArrayIterator([
            $response
        ]));

        $this->gapicClient->runAggregationQuery(
            Argument::that(function (RunAggregationQueryRequest $request) use ($type, $expected) {
                $this->assertEquals(1, count($request->getStructuredAggregationQuery()->getAggregations()));
                $aggregation = $request->getStructuredAggregationQuery()->getAggregations()[0];

                switch ($type) {
                    case 'count':
                        $this->assertTrue($aggregation->hasCount());
                        break;
                    case 'sum':
                        $this->assertTrue($aggregation->hasSum());
                        break;
                    case 'avg':
                        $this->assertTrue($aggregation->hasAvg());
                        break;
                    default:
                        $this->fail('Unknown property detected');
                }

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn($stream->reveal());

        $response = $aggregateQuery->getSnapshot();
        $this->assertInstanceOf(AggregateQuerySnapshot::class, $response);
        $this->assertEquals(123456, $response->get($type));
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAddAggregation($type, $arg, $expected)
    {
        $expectedProps = [
            [$type => $expected],
            [$type => $expected, 'alias' => 'total'],
            [$type => $expected, 'alias' => 'type_with_another_alias'],
        ];

        $aggregate = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $aggregate2 = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $aggregate3 = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $aggregate2->alias('total');
        $aggregate3->alias('type_with_another_alias');

        $aggregateQuery = new AggregateQuery(
             $this->gapicClient->reveal(),
            self::QUERY_PARENT,
            ['query' => $this->queryObj],
            $aggregate
        );

        $aggregateQuery->addAggregation($aggregate2);
        $aggregateQuery->addAggregation($aggregate3);

        $response = new RunAggregationQueryResponse();
        $response->mergeFromJsonString(json_encode([
            'result' => [
                'aggregateFields' => [
                    $type => ['integerValue' => 123456]
                ]
            ]
        ]));
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new ArrayIterator([
            $response
        ]));

        $this->gapicClient->runAggregationQuery(
            Argument::that(function (RunAggregationQueryRequest $request) use ($type) {
                $this->assertEquals(3, count($request->getStructuredAggregationQuery()->getAggregations()));

                $aggregations = $request->getStructuredAggregationQuery()->getAggregations();

                $this->assertEquals('total', $aggregations[1]->getAlias());
                $this->assertNotEmpty('type_with_another_alias', $aggregations[2]->getAlias());

                $aggregation = $aggregations[0];

                switch ($type) {
                    case 'count':
                        $this->assertTrue($aggregation->hasCount());
                        break;
                    case 'sum':
                        $this->assertTrue($aggregation->hasSum());
                        break;
                    case 'avg':
                        $this->assertTrue($aggregation->hasAvg());
                        break;
                    default:
                        $this->fail('Unknown property detected');
                }

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn($stream->reveal());

        $response = $aggregateQuery->getSnapshot();

        $this->assertInstanceOf(AggregateQuerySnapshot::class, $response);
    }

    public function aggregationTypes()
    {
        return [
            ['count', null, []],
            ['sum', 'testField', ['field' => ['fieldPath' => 'testField']]],
            ['avg', 'testField', ['field' => ['fieldPath' => 'testField']]]
        ];
    }
}
