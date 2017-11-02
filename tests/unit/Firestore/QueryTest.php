<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Firestore;

use Prophecy\Argument;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Firestore\V1beta1\StructuredQuery_Direction;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\StructuredQuery_FieldFilter_Operator;
use Google\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const PARENT = 'projects/example_project/databases/(default)/documents/';

    private $queryObj = ['from' => 'projects/example_project/databases/(default)/documents/'];
    private $connection;
    private $query;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->query = \Google\Cloud\Dev\stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::PARENT,
            $this->queryObj
        ], ['connection', 'query', 'transaction']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructMissingFrom()
    {
        new Query($this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::PARENT,
            []
        );
    }

    public function testSelect()
    {
        $paths = [
            'users.john',
            'users.dave'
        ];

        $this->runAndAssert(function (Query $q) use ($paths) {
            $res = $q->select($paths);
            $res = $res->select(['users.dan']);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'select' => [
                    'fields' => [
                        [ 'fieldPath' => 'users.john' ],
                        [ 'fieldPath' => 'users.dave' ],
                        [ 'fieldPath' => 'users.dan' ],
                    ]
                ]
            ]
        ]);
    }

    public function testSelectName()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->select([]);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'select' => [
                    'fields' => [
                        [ 'fieldPath' => '__name__' ]
                    ]
                ]
            ]
        ]);
    }

    public function testWhere()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->where('user.name', '=', 'John');
            $res = $res->where('user.age', '=', 30);
            $res = $res->where('user.coolness', '=', null);
            $res = $res->where('user.numberOfFriends', '=', NAN);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'where' => [
                    'compositeFilter' => [
                        'op' => StructuredQuery_CompositeFilter_Operator::PBAND,
                        'filters' => [
                            [
                                'fieldFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.name'
                                    ],
                                    'op' => StructuredQuery_FieldFilter_Operator::EQUAL,
                                    'value' => [
                                        'stringValue' => 'John'
                                    ]
                                ]
                            ], [
                                'fieldFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.age'
                                    ],
                                    'op' => StructuredQuery_FieldFilter_Operator::EQUAL,
                                    'value' => [
                                        'integerValue' => '30'
                                    ]
                                ]
                            ],
                            [
                                'unaryFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.coolness'
                                    ],
                                    'op' => Query::OP_NULL
                                ]
                            ], [
                                'unaryFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.numberOfFriends'
                                    ],
                                    'op' => Query::OP_NAN
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider invalidUnaryComparisonOperators
     * @expectedException InvalidArgumentException
     */
    public function testWhereUnaryInvalidComparisonOperator($operator)
    {
        $this->query->where('foo', $operator, null);
    }

    public function invalidUnaryComparisonOperators()
    {
        return [
            [Query::OP_LESS_THAN],
            [Query::OP_LESS_THAN_OR_EQUAL],
            [Query::OP_GREATER_THAN],
            [Query::OP_GREATER_THAN_OR_EQUAL],
            ['<'],
            ['<='],
            ['>'],
            ['>='],
        ];
    }

    /**
     * @dataProvider whereOperators
     */
    public function testWhereOperators($operator)
    {
        $this->query->where('foo', $operator, 'bar');
    }

    public function whereOperators()
    {
        return [
            [Query::OP_LESS_THAN],
            [Query::OP_LESS_THAN_OR_EQUAL],
            [Query::OP_GREATER_THAN],
            [Query::OP_GREATER_THAN_OR_EQUAL],
            [Query::OP_EQUAL],
            ['<'],
            ['<='],
            ['>'],
            ['>='],
            ['='],
        ];
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testWhereInvalidOperator()
    {
        $this->query->where('foo', 'hello', 'bar');
    }

    public function testOrderBy()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->orderBy('user.name', 'DESC');
            $res = $res->orderBy('user.age', 'ASC');

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'orderBy' => [
                    [
                        'field' => ['fieldPath' => 'user.name'],
                        'direction' => StructuredQuery_Direction::DESCENDING
                    ], [
                        'field' => ['fieldPath' => 'user.age'],
                        'direction' => StructuredQuery_Direction::ASCENDING
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider orderOperators
     */
    public function testorderOperators($operator)
    {
        $this->query->orderBy('foo', $operator);
    }

    public function orderOperators()
    {
        return [
            [Query::DIR_ASCENDING],
            [Query::DIR_DESCENDING],
            ['ASC'],
            ['DESC'],
            ['asc'],
            ['desc'],
            ['ASCENDING'],
            ['DESCENDING'],
            ['ascending'],
            ['descending'],
        ];
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testOrderByInvalidOperator()
    {
        $this->query->orderBy('foo', 'hello');
    }

    public function testLimit()
    {
        $limit = 50;

        $this->runAndAssert(function (Query $q) use ($limit) {
            $res = $q->limit($limit);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'limit' => ['value' => $limit]
            ]
        ]);
    }

    public function testOffset()
    {
        $offset = 50;

        $this->runAndAssert(function (Query $q) use ($offset) {
            $res = $q->offset($offset);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'offset' => $offset
            ]
        ]);
    }

    public function testStartAt()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->startAt(['john']);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'startAt' => [
                    'before' => true,
                    'values' => [
                        [
                            'stringValue' => 'john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testStartAfter()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->startAfter(['john']);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'startAt' => [
                    'before' => false,
                    'values' => [
                        [
                            'stringValue' => 'john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testEndBefore()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->endBefore(['john']);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'endAt' => [
                    'before' => true,
                    'values' => [
                        [
                            'stringValue' => 'john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testEndAt()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->endAt(['john']);

            return $res;
        }, [
            'parent' => self::PARENT,
            'structuredQuery' => [
                'from' => self::PARENT,
                'endAt' => [
                    'before' => false,
                    'values' => [
                        [
                            'stringValue' => 'john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testDefaultRetries()
    {
        $this->connection->runQuery(Argument::withEntry('retries', 0))
            ->shouldBeCalledTimes(1)->willReturn(new \ArrayIterator([
                []
            ]));

        $query = clone $this->query;
        $query->___setProperty('connection', $this->connection->reveal());
        $query->documents()->rows()->current();
    }

    private function runAndAssert(callable $filters, $assertion)
    {
        if (is_array($assertion)) {
            $this->connection->runQuery($assertion + ['retries' => 0])
            ->shouldBeCalledTimes(1)->willReturn(new \ArrayIterator([
                []
            ]));
        } elseif (is_callable($assertion)) {
            $this->connection->runQuery(Argument::that($assertion))
                ->shouldBeCalledTimes(1);
        }

        $immutable = clone $this->query;
        $immutable->___setProperty('connection', $this->connection->reveal());
        $query = $filters($immutable);

        $this->assertInstanceOf(Query::class, $query);
        $this->assertNotEquals($immutable, $query);

        $query->documents(['maxRetries' => 0])->rows()->current();
    }
}
