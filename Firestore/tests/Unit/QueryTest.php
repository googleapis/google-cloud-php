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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Testing\ArrayHasSameValuesToken;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\V1\FirestoreClient as FirestoreGapicClient;
use Google\Cloud\Firestore\V1\StructuredQuery\CompositeFilter\Operator;
use Google\Cloud\Firestore\V1\StructuredQuery\Direction;
use Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator as FieldFilterOperator;
use Google\Cloud\Firestore\ValueMapper;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends TestCase
{
    use ExpectException;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const QUERY_PARENT = 'projects/example_project/databases/(default)/documents';
    const COLLECTION = 'foo';

    private $queryObj = [
        'from' => [
            ['collectionId' => self::COLLECTION]
        ]
    ];
    private $connection;
    private $query;
    private $collectionGroupQuery;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->query = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            $this->queryObj
        ], ['connection', 'query', 'transaction']);

        $allDescendants = $this->queryObj;
        $allDescendants['from'][0]['allDescendants'] = true;
        $this->collectionGroupQuery = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            $allDescendants
        ], ['connection', 'query', 'transaction']);
    }

    public function testConstructMissingFrom()
    {
        $this->expectException('InvalidArgumentException');

        new Query(
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            []
        );
    }

    public function testDocuments()
    {
        $name = self::QUERY_PARENT .'/foo';

        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => $name,
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ],
                []
            ]));

        $this->query->___setProperty('connection', $this->connection->reveal());

        $res = $this->query->documents(['maxRetries' => 0]);
        $this->assertContainsOnlyInstancesOf(DocumentSnapshot::class, $res);
        $this->assertCount(1, $res->rows());

        $current = $res->rows()[0];
        $this->assertEquals($name, $current->name());
        $this->assertEquals('world', $current['hello']);
    }

    public function testDocumentsMetadata()
    {
        $name = self::QUERY_PARENT .'/foo';

        $ts = (new \DateTime)->format(Timestamp::FORMAT);
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => $name,
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ],
                        'createTime' => $ts,
                        'updateTime' => $ts
                    ],
                    'readTime' => $ts
                ],
                []
            ]));

        $this->query->___setProperty('connection', $this->connection->reveal());

        $res = $this->query->documents()->rows()[0];
        $this->assertInstanceOf(Timestamp::class, $res->createTime());
        $this->assertInstanceOf(Timestamp::class, $res->updateTime());
        $this->assertInstanceOf(Timestamp::class, $res->readTime());
    }

    public function testSelect()
    {
        $paths = [
            'users.john',
            'users.dave'
        ];

        $this->runAndAssert(function (Query $q) use ($paths) {
            return $q->select($paths);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'select' => [
                    'fields' => [
                        [ 'fieldPath' => 'users.john' ],
                        [ 'fieldPath' => 'users.dave' ],
                    ]
                ]
            ]
        ]);
    }

    public function testSelectOverride()
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
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'select' => [
                    'fields' => [
                        [ 'fieldPath' => 'users.dan' ],
                    ]
                ]
            ]
        ]);
    }

    public function testSelectName()
    {
        $this->runAndAssert(function (Query $q) {
            return $q->select([]);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
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
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'where' => [
                    'compositeFilter' => [
                        'op' => Operator::PBAND,
                        'filters' => [
                            [
                                'fieldFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.name'
                                    ],
                                    'op' => FieldFilterOperator::EQUAL,
                                    'value' => [
                                        'stringValue' => 'John'
                                    ]
                                ]
                            ], [
                                'fieldFilter' => [
                                    'field' => [
                                        'fieldPath' => 'user.age'
                                    ],
                                    'op' => FieldFilterOperator::EQUAL,
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
     */
    public function testWhereUnaryInvalidComparisonOperator($operator)
    {
        $this->expectException('InvalidArgumentException');

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
        $refl = new \ReflectionClass(FieldFilterOperator::class);
        $constants = $refl->getConstants();

        $ops = [];
        foreach ($constants as $constant) {
            $ops[] = [$constant];
        }
        return array_merge($ops, [
            ['<'],
            ['<='],
            ['>'],
            ['>='],
            ['='],
            ['!='],
            ['array-contains'],
            ['in'],
            ['IN'],
            ['array-contains-any'],
        ]);
    }

    /**
     * @dataProvider sentinels
     */
    public function testWhereInvalidSentinelValue($sentinel)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where('foo', '=', $sentinel);
    }

    public function testWhereInvalidOperator()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where('foo', 'hello', 'bar');
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentId($document, $expected)
    {
        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(FieldPath::documentId(), '=', $document);

            return $res;
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'where' => [
                    'fieldFilter' => [
                        'field' => [
                            'fieldPath' => '__name__'
                        ],
                        'op' => FieldFilterOperator::EQUAL,
                        'value' => [
                            'referenceValue' => is_string($expected)
                                ? $expected
                                : $expected->name()
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentIdIn($document, $expected)
    {
        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(FieldPath::documentId(), 'in', [$document]);

            return $res;
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'where' => [
                    'fieldFilter' => [
                        'field' => [
                            'fieldPath' => '__name__'
                        ],
                        'op' => FieldFilterOperator::IN,
                        'value' => [
                            'arrayValue' => [
                                'values' => [
                                    [
                                        'referenceValue' => is_string($expected)
                                            ? $expected
                                            : $expected->name()
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function whereDocument()
    {
        $name = FirestoreGapicClient::documentPathName(self::PROJECT, self::DATABASE, self::COLLECTION . '/a/b/c');

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn($name);
        $snap = $this->prophesize(DocumentSnapshot::class);
        $snap->name()->willReturn($name);
        return [
            ['a/b/c', $name],
            ['a/b/c', $ref->reveal()],
            ['a/b/c', $snap->reveal()]
        ];
    }

    /**
     * @dataProvider whereInvalidDocument
     */
    public function testWhereInvalidDocument($document)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where(FieldPath::documentId(), '=', $document);
    }

    public function whereInvalidDocument()
    {
        return [
            [
                'a/b',
                1010
            ]
        ];
    }

    public function testOrderBy()
    {
        $this->runAndAssert(function (Query $q) {
            $res = $q->orderBy('user.name', 'DESC');
            $res = $res->orderBy('user.age', 'ASC');

            return $res;
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => ['fieldPath' => 'user.name'],
                        'direction' => Direction::DESCENDING
                    ], [
                        'field' => ['fieldPath' => 'user.age'],
                        'direction' => Direction::ASCENDING
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider cursors
     */
    public function testOrderByAfterCursor($cursor)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy('foo')->$cursor(['bar'])->orderBy('world');
    }

    public function cursors()
    {
        return [
            ['startAt'], ['startAfter'], ['endBefore'], ['endAt']
        ];
    }

    /**
     * @dataProvider orderOperators
     */
    public function testOrderOperators($operator)
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

    public function testOrderByInvalidOperator()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy('foo', 'hello');
    }

    public function testLimit()
    {
        $limit = 50;

        $this->runAndAssert(function (Query $q) use ($limit) {
            return $q->limit($limit);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'limit' => $limit
            ]
        ]);
    }

    /**
     * @dataProvider limitToLast
     */
    public function testLimitToLast(callable $filter, array $query)
    {
        $this->runAndAssert(function (Query $q) use ($filter) {
            $q = $filter($q);
            $q = $q->limitToLast(1);

            return $q;
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'limit' => 1
            ] + $query
        ]);
    }

    /**
     * Query scenarios verifying the inversion of ordering and cursors.
     */
    public function limitToLast()
    {
        return [
            [
                function (Query $q) {
                    return $q->orderBy('foo', 'DESC');
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::ASCENDING
                        ]
                    ]
                ]
            ], [
                function (Query $q) {
                    return $q->orderBy('foo', 'ASC');
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::DESCENDING
                        ]
                    ]
                ]
            ], [
                function (Query $q) {
                    return $q->orderBy('foo', 'DESC')
                        ->startAt(['bar']);
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::ASCENDING
                        ]
                    ],
                    'endAt' => [
                        'values' => [
                            [
                                'stringValue' => 'bar'
                            ]
                        ],
                        'before' => false
                    ]
                ]
            ], [
                function (Query $q) {
                    return $q->orderBy('foo', 'DESC')
                        ->startAfter(['bar']);
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::ASCENDING
                        ]
                    ],
                    'endAt' => [
                        'values' => [
                            [
                                'stringValue' => 'bar'
                            ]
                        ],
                        'before' => true
                    ]
                ]
            ], [
                function (Query $q) {
                    return $q->orderBy('foo', 'DESC')
                        ->endAt(['bar']);
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::ASCENDING
                        ]
                    ],
                    'startAt' => [
                        'values' => [
                            [
                                'stringValue' => 'bar'
                            ]
                        ],
                        'before' => true
                    ]
                ]
            ], [
                function (Query $q) {
                    return $q->orderBy('foo', 'DESC')
                        ->endBefore(['bar']);
                },
                [
                    'orderBy' => [
                        [
                            'field' => ['fieldPath' => 'foo'],
                            'direction' => Direction::ASCENDING
                        ]
                    ],
                    'startAt' => [
                        'values' => [
                            [
                                'stringValue' => 'bar'
                            ]
                        ],
                        'before' => false
                    ]
                ]
            ]
        ];
    }

    public function testLimitToLastReversesResults()
    {
        $name1 = self::QUERY_PARENT .'/foo';
        $name2 = self::QUERY_PARENT .'/bar';

        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => $name1,
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ],
                [
                    'document' => [
                        'name' => $name2,
                        'fields' => [
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ],
            ]));

        $this->query->___setProperty('connection', $this->connection->reveal());

        $res = $this->query->orderBy('foo', 'DESC')
            ->limitToLast(2)
            ->documents(['maxRetries' => 0]);

        $rows = $res->rows();
        $this->assertEquals($name2, $rows[0]->name());
        $this->assertEquals($name1, $rows[1]->name());
    }

    public function testLimitToLastWithoutOrderBy()
    {
        $this->expectException('\RuntimeException');

        $this->query->limitToLast(1)->documents()->current();
    }

    public function testOffset()
    {
        $offset = 50;

        $this->runAndAssert(function (Query $q) use ($offset) {
            return $q->offset($offset);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'offset' => $offset
            ]
        ]);
    }

    public function testStartAt()
    {
        $this->runAndAssert(function (Query $q) {
            return $q->orderBy('name', Query::DIR_DESCENDING)->startAt(['john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'name'
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
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
            return $q->orderBy('name', Query::DIR_DESCENDING)->startAfter(['john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'name'
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
                'startAt' => [
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
            return $q->orderBy('name', Query::DIR_DESCENDING)->endBefore(['john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'name'
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
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
            return $q->orderBy('name', Query::DIR_DESCENDING)->endAt(['john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'name'
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
                'endAt' => [
                    'values' => [
                        [
                            'stringValue' => 'john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testBuildPositionWithDocumentId()
    {
        $documentPath = $this->queryFrom()[0]['collectionId'] . '/john';

        $this->runAndAssert(function (Query $q) use ($documentPath) {
            return $q->orderBy(Query::DOCUMENT_ID, Query::DIR_DESCENDING)->endAt(['john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
                'endAt' => [
                    'values' => [
                        [
                            'referenceValue' => self::QUERY_PARENT .'/'. $documentPath
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testBuildPositionWithDocumentReference()
    {
        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId']);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $ref->parent()->willReturn($c->reveal());

        $this->runAndAssert(function (Query $q) use ($ref) {
            return $q->orderBy(Query::DOCUMENT_ID, Query::DIR_DESCENDING)->endAt([$ref->reveal()]);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_DESCENDING
                    ]
                ],
                'endAt' => [
                    'values' => [
                        [
                            'referenceValue' => self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testPositionWithDocumentSnapshot()
    {
        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId']);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $ref->parent()->willReturn($c->reveal());

        $snapshot = $this->prophesize(DocumentSnapshot::class);
        $snapshot->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $snapshot->reference()->willReturn($ref->reveal());

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            return $this->query->startAt($snapshot->reveal());
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ]
                ],
                'startAt' => [
                    'before' => true,
                    'values' => [
                        [
                            'referenceValue' => self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testSnapshotInFieldValue()
    {
        $this->expectException('InvalidArgumentException');

        $snapshot = $this->prophesize(DocumentSnapshot::class);
        $this->query->startAt([$snapshot->reveal()]);
    }

    public function testInvalidFieldValues()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->startAt('foo');
    }

    public function testPositionSnapshotOrderBy()
    {
        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId']);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $ref->parent()->willReturn($c->reveal());

        $snapshot = $this->prophesize(DocumentSnapshot::class);
        $snapshot->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $snapshot->reference()->willReturn($ref->reveal());
        $snapshot->get('a')->willReturn('b');
        $snapshot->get('c')->willReturn('d');

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->orderBy('a')->orderBy('c')->orderBy(FieldPath::documentId());
            return $query->startAt($snapshot->reveal());
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'a'
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ], [
                        'field' => [
                            'fieldPath' => 'c'
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ], [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ]
                ],
                'startAt' => [
                    'before' => true,
                    'values' => [
                        ['stringValue' => 'b'],
                        ['stringValue' => 'd'],
                        [
                            'referenceValue' => self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testPositionInequalityFilter()
    {
        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId']);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $ref->parent()->willReturn($c->reveal());

        $snapshot = $this->prophesize(DocumentSnapshot::class);
        $snapshot->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $snapshot->reference()->willReturn($ref->reveal());
        $snapshot->get('foo')->willReturn('bar');

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->where('foo', '>', 'bar');
            return $query->startAt($snapshot->reveal());
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => 'foo'
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ], [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ]
                ],
                'startAt' => [
                    'before' => true,
                    'values' => [
                        [
                            'stringValue' => 'bar'
                        ], [
                            'referenceValue' => self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john'
                        ]
                    ]
                ],
                'where' => [
                    'fieldFilter' => [
                        'field' => [
                            'fieldPath' => 'foo'
                        ],
                        'op' => 3,
                        'value' => [
                            'stringValue' => 'bar'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testBuildPositionTooManyCursorValues()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy('foo')->endAt(['a','b']);
    }

    public function testBuildPositionOutOfBounds()
    {
        $this->expectException('InvalidArgumentException');

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/whatev/john');

        $col = $this->prophesize(CollectionReference::class);
        $col->name()->willReturn(self::QUERY_PARENT .'/whatev/john');
        $ref->parent()->willReturn($col->reveal());

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$ref->reveal()]);
    }

    public function testBuildPositionInvalidCursorType()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([10]);
    }

    public function testBuildPositionInvalidDocumentName()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt(['a/b']);
    }

    /**
     * @dataProvider sentinels
     */
    public function testBuildPositionInvalidSentinelValue($sentinel)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$sentinel]);
    }

    public function testBuildPositionNestedChild()
    {
        $this->expectException('InvalidArgumentException');

        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john/bar/bat/baz');
        $ref->parent()->willReturn($c->reveal());

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$ref->reveal()]);
    }

    public function testBuildPositionAllDescendantsDocument()
    {
        $this->runAndAssert(function (Query $q) {
            $query = $q->orderBy(FieldPath::documentId());
            return $query->startAt([$this->queryFrom()[0]['collectionId'] .'/john']);
        }, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(true),
                'orderBy' => [
                    [
                        'field' => [
                            'fieldPath' => Query::DOCUMENT_ID
                        ],
                        'direction' => Query::DIR_ASCENDING
                    ]
                ],
                'startAt' => [
                    'before' => true,
                    'values' => [
                        [
                            'referenceValue' => self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john'
                        ]
                    ]
                ]
            ]
        ], $this->collectionGroupQuery);
    }

    private function runAndAssert(callable $filters, $assertion, Query $query = null)
    {
        if (is_array($assertion)) {
            $this->connection->runQuery(
                new ArrayHasSameValuesToken($assertion + ['retries' => 0])
            )->shouldBeCalledTimes(1)->willReturn(new \ArrayIterator([
                []
            ]));
        } elseif (is_callable($assertion)) {
            $this->connection->runQuery(Argument::that($assertion))
                ->shouldBeCalledTimes(1);
        }

        $query = $query ?: $this->query;
        $immutable = clone $query;
        $immutable->___setProperty('connection', $this->connection->reveal());
        $query = $filters($immutable);

        $this->assertInstanceOf(Query::class, $query);
        $this->assertNotEquals($immutable, $query);

        iterator_to_array($query->documents(['maxRetries' => 0]));
    }

    private function queryFrom($allDescendants = false)
    {
        $from = $this->queryObj['from'];
        if ($allDescendants) {
            $from[0]['allDescendants'] = true;
        }

        return $from;
    }

    public function sentinels()
    {
        return [
            [FieldValue::deleteField()],
            [FieldValue::serverTimestamp()],
            [FieldValue::arrayUnion([])],
            [FieldValue::arrayRemove([])]
        ];
    }
}
