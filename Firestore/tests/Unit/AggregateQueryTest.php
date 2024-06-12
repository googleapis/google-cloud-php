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

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\FirestoreTestHelperTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as V1FirestoreClient;
use Google\Cloud\Firestore\V1\RunAggregationQueryRequest;
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
    use FirestoreTestHelperTrait;
    use ProphecyTrait;

    const QUERY_PARENT = 'projects/example_project/databases/(default)/';

    private $queryObj = [
        'from' => [
            ['collectionId' => 'foo']
        ]
    ];

    private $connection;
    private $requestHandler;
    private $serializer;
    private $query;
    private $aggregate;
    private $aggregateQuery;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = $this->getSerializer();
        $this->query = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            $this->requestHandler->reveal(),
            $this->serializer,
            new ValueMapper(
                $this->connection->reveal(),
                $this->requestHandler->reveal(),
                $this->serializer,
                false
            ),
            self::QUERY_PARENT,
            $this->queryObj
        ], ['connection', 'requestHandler', 'query']);
        $this->aggregate = Aggregate::count();
        $this->aggregateQuery = TestHelpers::stub(AggregateQuery::class, [
            $this->connection->reveal(),
            $this->requestHandler->reveal(),
            $this->serializer,
            self::QUERY_PARENT,
            ['query' => $this->queryObj],
            $this->aggregate
        ], ['connection', 'requestHandler', 'query', 'aggregates']);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testGetSnapshot($type, $arg, $expected)
    {
        $expectedProps = [
            [$type => $expected]
        ];
        $aggregate = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $this->aggregateQuery->___setProperty('aggregates', [$aggregate]);

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'runAggregationQuery',
            Argument::that(function ($req) use ($expectedProps) {
                $data = $this->getSerializer()->encodeMessage($req);
                $x = $data['structuredAggregationQuery']['aggregations'];
                return array_replace_recursive($x, $expectedProps) == $x;
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn(new \ArrayIterator([[
            'result' => [
                'aggregateFields' => [
                    $type => ['testResultType' => 123456]
                ]
            ]
        ]]));

        $this->aggregateQuery->___setProperty('requestHandler', $this->requestHandler->reveal());

        $response = $this->aggregateQuery->getSnapshot();
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

        // Filling the array using array_fill or similar method results in
        // having values by reference, hence not suited for test's purpose.
        $aggregates = [
            $arg ? Aggregate::$type($arg) : Aggregate::$type(),
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('total'),
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('type_with_another_alias')
        ];
        $this->aggregateQuery->___setProperty('aggregates', $aggregates);

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'runAggregationQuery',
            Argument::that(function ($req) use ($expectedProps) {
                $data = $this->getSerializer()->encodeMessage($req);
                $x = $data['structuredAggregationQuery']['aggregations'];
                return array_replace_recursive($x, $expectedProps) == $x;
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn(new \ArrayIterator([]));

        $this->aggregateQuery->___setProperty('requestHandler', $this->requestHandler->reveal());

        $response = $this->aggregateQuery->getSnapshot();

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
