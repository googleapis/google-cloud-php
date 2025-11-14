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

use DateTimeImmutable;
use Google\Cloud\Core\Testing\ArrayHasSameValuesToken;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
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
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Firestore\Filter;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\ExplainOptions;
use Google\Cloud\Firestore\V1\RunAggregationQueryRequest;
use Google\Cloud\Firestore\V1\RunAggregationQueryResponse;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Protobuf\Int32Value;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends TestCase
{
    use GenerateProtoTrait;
    use ServerStreamMockTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const QUERY_PARENT = 'projects/example_project/databases/(default)/documents';
    const COLLECTION = 'foo';

    private $queryObj = [
        'from' => [
            ['collectionId' => self::COLLECTION]
        ]
    ];
    private $gapicClient;
    private $query;
    private $collectionGroupQuery;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);

        $this->query = new Query(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            self::QUERY_PARENT,
            $this->queryObj
        );

        $allDescendants = $this->queryObj;
        $allDescendants['from'][0]['allDescendants'] = true;
        $this->collectionGroupQuery = new Query(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            self::QUERY_PARENT,
            $allDescendants
        );
    }

    public function testConstructMissingFrom()
    {
        $this->expectException(InvalidArgumentException::class);

        new Query(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            self::QUERY_PARENT,
            []
        );
    }

    public function testDocuments()
    {
        $name = self::QUERY_PARENT .'/foo';

        $protoResponse = self::generateProto(RunQueryResponse::class, [
            'document' => [
                'name' => $name,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ],
            'readTime' => ['seconds' => 123, 'nanos' => 321]
        ]);

        $this->gapicClient->runQuery(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $this->query->documents(['maxRetries' => 0]);
        $this->assertContainsOnlyInstancesOf(DocumentSnapshot::class, $res);
        $this->assertCount(1, $res->rows());

        $current = $res->rows()[0];
        $this->assertEquals($name, $current->name());
        $this->assertEquals('world', $current['hello']);
    }

    public function testContainsQueryExplainOptions()
    {
        $name = self::QUERY_PARENT .'/foo';
        $explainOptions = new ExplainOptions();
        $explainOptions->setAnalyze(true);

        $protoResponse = self::generateProto(RunQueryResponse::class, [
            'document' => [
                'name' => $name,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ],
        ]);

        $this->gapicClient->runQuery(
            Argument::that(function (RunQueryRequest $request) {
                $this->assertNotEmpty($request->getExplainOptions());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $this->query->documents(['maxRetries' => 0, 'explainOptions' => $explainOptions]);
        $this->assertContainsOnlyInstancesOf(DocumentSnapshot::class, $res);
        $this->assertCount(1, $res->rows());

        $current = $res->rows()[0];
        $this->assertEquals($name, $current->name());
        $this->assertEquals('world', $current['hello']);
    }

    public function testDocumentsMetadata()
    {
        $name = self::QUERY_PARENT .'/foo';

        $ts = [
            'nanos' => 321,
            'seconds' => 123
        ];

        $protoResponse = self::generateProto(RunQueryResponse::class, [
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
        ]);

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $this->query->documents()->rows()[0];
        $this->assertInstanceOf(Timestamp::class, $res->createTime());
        $this->assertInstanceOf(Timestamp::class, $res->updateTime());
        $this->assertInstanceOf(Timestamp::class, $res->readTime());
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAggregation($type, $arg)
    {
        $protoResponse = self::generateProto(RunAggregationQueryResponse::class, [
           'result' => [
                'aggregateFields' => [
                    $type => ['integerValue' => 1]
                ]
            ]
        ]);

        $this->gapicClient->runAggregationQuery(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $arg ? $this->query->$type($arg) : $this->query->$type();
        $this->assertEquals(1, $res);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAggregationWithReadTime($type, $arg)
    {
        $protoResponse = self::generateProto(RunAggregationQueryResponse::class, [
            'result' => [
                'aggregateFields' => [
                    $type => ['integerValue' => 1]
                ]
            ]
        ]);

        $readTime = new Timestamp(new DateTimeImmutable('now'));
        $this->gapicClient->runAggregationQuery(
            Argument::that(function (RunAggregationQueryRequest $request) use ($readTime) {
                $expectedSeconds = $readTime->get()->format('U');
                $expectedNanos = $readTime->nanoSeconds();

                $this->assertEquals($expectedSeconds, $request->getReadTime()->getSeconds());
                $this->assertEquals($expectedNanos, $request->getReadTime()->getNanos());

                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $arg ?
            $this->query->$type($arg, ['readTime' => $readTime]) :
            $this->query->$type(['readTime' => $readTime]);
        $this->assertEquals(1, $res);
    }

    public function testSelect()
    {
        $paths = [
            'users.john',
            'users.dave'
        ];

        $requestToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($paths) {
            return $q->select($paths);
        }, $requestToAssert);
    }

    public function testSelectOverride()
    {
        $paths = [
            'users.john',
            'users.dave'
        ];

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($paths) {
            $res = $q->select($paths);
            $res = $res->select(['users.dan']);
            return $res;
        }, $protoToAssert);
    }

    public function testSelectName()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            return $q->select([]);
        }, $protoToAssert);
    }

    public function testWhere()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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
                            ], [
                                'compositeFilter' => [
                                    'op' => Operator::PBOR,
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
                                        ],
                                        [
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
                                            'compositeFilter' => [
                                                'op' => Operator::PBAND,
                                                'filters' => [
                                                    [
                                                        'unaryFilter' => [
                                                            'field' => [
                                                                'fieldPath' => 'user.coolness'
                                                            ],
                                                            'op' => Query::OP_NULL
                                                        ]
                                                    ],
                                                    [
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
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $this->runAndAssert(function (Query $q) {
            $res = $q->where('user.name', '=', 'John');
            $res = $res->where('user.age', '=', 30);
            $res = $res->where('user.coolness', '=', null);
            $res = $res->where('user.numberOfFriends', '=', NAN);
            $res = $res->where(
                Filter::or([
                    Filter::field('user.name', '=', 'John'),
                    Filter::field('user.age', '=', 30),
                    Filter::and([
                        Filter::field('user.coolness', '=', null),
                        Filter::field('user.numberOfFriends', '=', NAN)
                        ])
                    ])
            );

            return $res;
        },$protoToAssert);
    }

    /**
     * @dataProvider invalidUnaryComparisonOperators
     */
    public function testWhereUnaryInvalidComparisonOperator($operator)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->where('foo', $operator, null);
    }

    /**
     * @dataProvider invalidUnaryComparisonOperators
     */
    public function testWhereUnaryInvalidComparisonOperatorWithFilter($operator)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where(Filter::field('foo', $operator, null));
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
        $ret = $this->query->where('foo', $operator, 'bar');
        $this->assertInstanceOf(Query::class, $ret);

        $ret = $this->query->where(Filter::field('foo', $operator, 'bar'));
        $this->assertInstanceOf(Query::class, $ret);
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
            ['not_in'],
            ['NOT_IN'],
            ['array-contains-any'],
        ]);
    }

    /**
     * @dataProvider sentinels
     */
    public function testWhereInvalidSentinelValue($sentinel)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->where('foo', '=', $sentinel);
    }

    /**
     * @dataProvider sentinels
     */
    public function testWhereInvalidSentinelValueWithFilter($sentinel)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where(Filter::field('foo', '=', $sentinel));
    }

    public function testWhereInvalidOperator()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->where('foo', 'hello', 'bar');
    }

    public function testWhereInvalidOperatorWithFilter()
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where(Filter::field('foo', 'hello', 'bar'));
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentId($document, $expected)
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(FieldPath::documentId(), '=', $document);

            return $res;
        }, $protoToAssert);
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentIdWithFilter($document, $expected)
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(Filter::field(FieldPath::documentId(), '=', $document));

            return $res;
        }, $protoToAssert);
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentIdIn($document, $expected)
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class,  [
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

        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(FieldPath::documentId(), 'in', [$document]);

            return $res;
        }, $protoToAssert);
    }

    /**
     * @dataProvider whereDocument
     */
    public function testWhereDocumentIdInWithFilter($document, $expected)
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($document) {
            $res = $q->where(Filter::field(FieldPath::documentId(), 'in', [$document]));

            return $res;
        }, $protoToAssert);
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
        $this->expectException(InvalidArgumentException::class);

        $this->query->where(FieldPath::documentId(), '=', $document);
    }

    /**
     * @dataProvider whereInvalidDocument
     */
    public function testWhereInvalidDocumentWithFilter($document)
    {
        $this->expectException('InvalidArgumentException');

        $this->query->where(Filter::field(FieldPath::documentId(), '=', $document));
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
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            $res = $q->orderBy('user.name', 'DESC');
            $res = $res->orderBy('user.age', 'ASC');

            return $res;
        }, $protoToAssert);
    }

    /**
     * @dataProvider cursors
     */
    public function testOrderByAfterCursor($cursor)
    {
        $this->expectException(InvalidArgumentException::class);

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
        $ret = $this->query->orderBy('foo', $operator);
        $this->assertInstanceOf(Query::class, $ret);
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
        $this->expectException(InvalidArgumentException::class);

        $this->query->orderBy('foo', 'hello');
    }

    public function testLimit()
    {
        $limit = 50;

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'limit' => new Int32Value(['value' => $limit])
            ]
        ]);

        $this->runAndAssert(function (Query $q) use ($limit) {
            return $q->limit($limit);
        }, $protoToAssert);
    }

    /**
     * @dataProvider limitToLast
     */
    public function testLimitToLast(callable $filter, array $query)
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'limit' => new Int32Value(['value' => 1])
            ] + $query
            ]);

        $this->runAndAssert(function (Query $q) use ($filter) {
            $q = $filter($q);
            $q = $q->limitToLast(1);

            return $q;
        }, $protoToAssert);
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

        $protoResponses = [
            self::generateProto(RunQueryResponse::class, [
                'document' => [
                    'name' => $name1,
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ],
                'readTime' => [
                    'seconds' => 123,
                    'nanos' => 321
                ]
            ]),
            self::generateProto(RunQueryResponse::class, [
                'document' => [
                    'name' => $name2,
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ],
                'readTime' => [
                    'seconds' => 123,
                    'nanos' => 321
                ]
            ])
        ];

        $this->gapicClient->runQuery(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock($protoResponses));

        $res = $this->query->orderBy('foo', 'DESC')
            ->limitToLast(2)
            ->documents(['maxRetries' => 0]);

        $rows = $res->rows();
        $this->assertEquals($name2, $rows[0]->name());
        $this->assertEquals($name1, $rows[1]->name());
    }

    public function testLimitToLastWithoutOrderBy()
    {
        $this->expectException(\RuntimeException::class);

        $this->query->limitToLast(1)->documents()->current();
    }

    public function testOffset()
    {
        $offset = 50;

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
            'parent' => self::QUERY_PARENT,
            'structuredQuery' => [
                'from' => $this->queryFrom(),
                'offset' => $offset
            ]
        ]);

        $this->runAndAssert(function (Query $q) use ($offset) {
            return $q->offset($offset);
        }, $protoToAssert);
    }

    public function testStartAt()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            return $q->orderBy('name', Query::DIR_DESCENDING)->startAt(['john']);
        }, $protoToAssert);
    }

    public function testStartAfter()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            return $q->orderBy('name', Query::DIR_DESCENDING)->startAfter(['john']);
        }, $protoToAssert);
    }

    public function testEndBefore()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            return $q->orderBy('name', Query::DIR_DESCENDING)->endBefore(['john']);
        }, $protoToAssert);
    }

    public function testEndAt()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) {
            return $q->orderBy('name', Query::DIR_DESCENDING)->endAt(['john']);
        }, $protoToAssert);
    }

    public function testBuildPositionWithDocumentId()
    {
        $documentPath = $this->queryFrom()[0]['collectionId'] . '/john';

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($documentPath) {
            return $q->orderBy(Query::DOCUMENT_ID, Query::DIR_DESCENDING)->endAt(['john']);
        }, $protoToAssert);
    }

    public function testBuildPositionWithDocumentReference()
    {
        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId']);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');
        $ref->parent()->willReturn($c->reveal());

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($ref) {
            return $q->orderBy(Query::DOCUMENT_ID, Query::DIR_DESCENDING)->endAt([$ref->reveal()]);
        }, $protoToAssert);
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

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            return $this->query->startAt($snapshot->reveal());
        }, $protoToAssert);
    }

    public function testSnapshotInFieldValue()
    {
        $this->expectException(InvalidArgumentException::class);

        $snapshot = $this->prophesize(DocumentSnapshot::class);
        $this->query->startAt([$snapshot->reveal()]);
    }

    public function testInvalidFieldValues()
    {
        $this->expectException(InvalidArgumentException::class);

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

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->orderBy('a')->orderBy('c')->orderBy(FieldPath::documentId());
            return $query->startAt($snapshot->reveal());
        }, $protoToAssert);
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

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->where('foo', '>', 'bar');
            return $query->startAt($snapshot->reveal());
        }, $protoToAssert);

        $secondProtoToAssert = self::generateProto(RunQueryRequest::class, [
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
                    'compositeFilter' => [
                        'op' => Operator::PBOR,
                        'filters' => [
                            [
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
                    ]
                ]
            ]
        ]);

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->where(Filter::or([Filter::field('foo', '>', 'bar')]));
            return $query->startAt($snapshot->reveal());
        }, $secondProtoToAssert);
    }

    public function testPositionInequalityWithCompositeFilter()
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

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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
                    'compositeFilter' => [
                        'op' => Operator::PBOR,
                        'filters' => [
                            [
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
                    ]
                ]
            ]
        ]);

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->where(Filter::or([Filter::field('foo', '>', 'bar')]));
            return $query->startAt($snapshot->reveal());
        }, $protoToAssert);
    }

    public function testPositionInequalityWithFieldFilter()
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

        $protoToAssert = self::generateProto(RunQueryRequest::class, [
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

        $this->runAndAssert(function (Query $q) use ($snapshot) {
            $query = $this->query->where(Filter::field('foo', '>', 'bar'));
            return $query->startAt($snapshot->reveal());
        }, $protoToAssert);
    }

    public function testBuildPositionTooManyCursorValues()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->orderBy('foo')->endAt(['a','b']);
    }

    public function testBuildPositionOutOfBounds()
    {
        $this->expectException(InvalidArgumentException::class);

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/whatev/john');

        $col = $this->prophesize(CollectionReference::class);
        $col->name()->willReturn(self::QUERY_PARENT .'/whatev/john');
        $ref->parent()->willReturn($col->reveal());

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$ref->reveal()]);
    }

    public function testBuildPositionInvalidCursorType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([10]);
    }

    public function testBuildPositionInvalidDocumentName()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt(['a/b']);
    }

    /**
     * @dataProvider sentinels
     */
    public function testBuildPositionInvalidSentinelValue($sentinel)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$sentinel]);
    }

    public function testBuildPositionNestedChild()
    {
        $this->expectException(InvalidArgumentException::class);

        $c = $this->prophesize(CollectionReference::class);
        $c->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john');

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::QUERY_PARENT .'/'. $this->queryFrom()[0]['collectionId'] .'/john/bar/bat/baz');
        $ref->parent()->willReturn($c->reveal());

        $this->query->orderBy(Query::DOCUMENT_ID)->startAt([$ref->reveal()]);
    }

    public function testBuildPositionAllDescendantsDocument()
    {
        $protoToAssert = self::generateProto(RunQueryRequest::class,  [
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
        ]);

        $this->runAndAssert(function (Query $q) {
            $query = $q->orderBy(FieldPath::documentId());
            return $query->startAt([$this->queryFrom()[0]['collectionId'] .'/john']);
        }, $protoToAssert, $this->collectionGroupQuery);
    }

    private function runAndAssert(callable $filters, $assertion, ?Query $query = null)
    {
        $this->gapicClient->runQuery($assertion, Argument::any())
                ->shouldBeCalledTimes(1)
                ->willReturn($this->getServerStreamMock([new RunQueryResponse()]));

        $query = $query ?: $this->query;
        $immutable = clone $query;
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

    public function aggregationTypes()
    {
        return [
            ['count', null],
            ['sum', 'testField'],
            ['avg', 'testField']
        ];
    }
}
