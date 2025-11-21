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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Serializer;
use Google\Cloud\Firestore\Transaction;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\RunAggregationQueryRequest;
use Google\Cloud\Firestore\V1\RunAggregationQueryResponse;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends TestCase
{
    use GenerateProtoTrait;
    use ServerStreamMockTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $gapicClient;
    private $valueMapper;
    private $transaction;
    private $ref;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->valueMapper = new ValueMapper($this->gapicClient->reveal(), false);
        $this->transaction = new Transaction(
            $this->gapicClient->reveal(),
            $this->valueMapper,
            $this->getDbName(),
            self::TRANSACTION
        );

        $this->ref = $this->prophesize(DocumentReference::class);
        $this->ref->name()->willReturn(self::DOCUMENT);
    }

    public function testSnapshot()
    {
        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => self::DOCUMENT,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ]
        ]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals([self::DOCUMENT], iterator_to_array($request->getDocuments()));
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $this->transaction->snapshot($this->ref->reveal());
        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::DOCUMENT, $res->name());
        $this->assertEquals('world', $res['hello']);
    }

    public function testRunQuery()
    {
        $this->gapicClient->runQuery(
            Argument::that(function (RunQueryRequest $request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([new RunQueryResponse()]));

        $query = new Query($this->gapicClient->reveal(), $this->valueMapper, '', ['from' => [['collectionId' => '']]]);

        $res = $this->transaction->runQuery($query);
        $this->assertInstanceOf(QuerySnapshot::class, $res);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testRunAggregateQuery($type, $arg)
    {
        $this->gapicClient->runAggregationQuery(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([new RunAggregationQueryResponse()]));

        $aggregateQuery = new AggregateQuery(
            $this->gapicClient->reveal(),
            self::DOCUMENT,
            ['query' => []],
            $arg ? Aggregate::$type($arg) : Aggregate::$type()
        );

        $res = $this->transaction->runAggregateQuery($aggregateQuery);

        $this->assertInstanceOf(AggregateQuerySnapshot::class, $res);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testGetAggregateSnapshotReadTime($type, $arg)
    {
        $timestamp = [
            'seconds' => 100,
            'nanos' => 501
        ];

        $aggregateQuery = new AggregateQuery(
            $this->gapicClient->reveal(),
            self::DOCUMENT,
            ['query' => []],
            $arg ? Aggregate::$type($arg) : Aggregate::$type()
        );

        $protoResponse = self::generateProto(RunAggregationQueryResponse::class, [
            'result' => [
                'aggregateFields' => [
                    $type => ['integerValue' => 1]
                ]
            ]
        ]);

        $this->gapicClient->runAggregationQuery(
            Argument::that(function (RunAggregationQueryRequest $request) use ($timestamp) {
                $this->assertEquals($timestamp['seconds'], $request->getReadTime()->getSeconds());
                $this->assertEquals($timestamp['nanos'], $request->getReadTime()->getNanos());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock([$protoResponse]));

        $res = $this->transaction->runAggregateQuery($aggregateQuery, [
            'readTime' => new Timestamp(
                \DateTimeImmutable::createFromFormat('U', (string) $timestamp['seconds']),
                $timestamp['nanos']
            )
        ]);

        $this->assertEquals(1, $res->get($type));
    }

    public function testGetAggregateSnapshotReadTimeInvalidReadTime()
    {
        $this->expectException('InvalidArgumentException');
        $q = $this->prophesize(AggregateQuery::class);

        $res = $this->transaction->runAggregateQuery($q->reveal(), [
            'readTime' => 'invalid_time'
        ]);
    }

    public function testCreate()
    {
        $this->transaction->create($this->ref->reveal(), [
            'hello' => 'world'
        ]);

        $this->expectAndInvoke([
            [
                'currentDocument' => ['exists' => false],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => ['hello' => ['stringValue' => 'world']]
                ],
                'updateTransforms' => [],
            ]
        ]);
    }

    public function testSet()
    {
        $this->transaction->set($this->ref->reveal(), [
            'hello' => 'world'
        ]);

        $this->expectAndInvoke([
            [
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => ['hello' => ['stringValue' => 'world']]
                ],
                'updateTransforms' => [],
            ]
        ]);
    }

    public function testSetMerge()
    {
        $this->transaction->set($this->ref->reveal(), [
            'hello' => 'world'
        ], ['merge' => true]);

        $this->expectAndInvoke([
            [
                'updateMask' => ['fieldPaths' => ['hello']],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => ['hello' => ['stringValue' => 'world']]
                ],
                'updateTransforms' => [],
            ]
        ]);
    }

    public function testUpdate()
    {
        $this->transaction->update($this->ref->reveal(), [
            ['path' => 'hello', 'value' => 'world'],
            ['path' => 'foo.bar', 'value' => 'val'],
            ['path' => new FieldPath(['foo', 'baz']), 'value' => 'val']
        ]);

        $this->expectAndInvoke([
            [
                'updateMask' => [
                    'fieldPaths' => [
                        "foo.bar",
                        "foo.baz",
                        "hello",
                    ]
                ],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ],
                        'foo' => [
                            'mapValue' => [
                                'fields' => [
                                    'bar' => [
                                        'stringValue' => 'val'
                                    ],
                                    'baz' => [
                                        'stringValue' => 'val'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'updateTransforms' => [],
            ]
        ]);
    }

    public function testDelete()
    {
        $this->transaction->delete($this->ref->reveal());

        $this->expectAndInvoke([
            [
                'delete' => self::DOCUMENT,
                'updateTransforms' => []
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testDocuments(array $input, array $names)
    {
        $timestamp =  $timestamp = [
            'seconds' => 100,
            'nanos' => 501
        ];

        $protoResponseArray = [
            self::generateProto(BatchGetDocumentsResponse::class, [
                'found' => [
                    'name' => $names[0],
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ],
                'readTime' => $timestamp
            ]),
            self::generateProto(BatchGetDocumentsResponse::class, [
                'missing' => $names[1],
                'readTime' => $timestamp
            ]),
            self::generateProto(BatchGetDocumentsResponse::class, [
                'missing' => $names[2],
                'readTime' => $timestamp
            ]),
        ];

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($names) {
                foreach ($request->getDocuments() as $i => $documentName) {
                    $this->assertEquals($names[$i], $documentName);
                }
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock($protoResponseArray));

        $res = $this->transaction->documents($input);

        $this->assertEquals('world', $res[0]['hello']);
        $this->assertCount(3, $res);
    }

    public function documents()
    {
        $pathBase = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents';

        $b = $this->prophesize(DocumentReference::class);
        $b->name()->willReturn('a/b');

        $c = $this->prophesize(DocumentReference::class);
        $c->name()->willReturn('a/c');

        $d = $this->prophesize(DocumentReference::class);
        $d->name()->willReturn('a/d');
        return [
            [
                [
                    'a/b',
                    'a/c',
                    'a/d'
                ], [
                    $pathBase . '/a/b',
                    $pathBase . '/a/c',
                    $pathBase . '/a/d'
                ]
                ], [
                    [
                        $pathBase . '/a/b',
                        $pathBase . '/a/c',
                        $pathBase . '/a/d'
                    ], [
                        $pathBase . '/a/b',
                        $pathBase . '/a/c',
                        $pathBase . '/a/d'
                    ]
                ], [
                    [
                        $b->reveal(),
                        $c->reveal(),
                        $d->reveal()
                    ], [
                        $pathBase . '/a/b',
                        $pathBase . '/a/c',
                        $pathBase . '/a/d'
                    ]
                ]
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

    public function testDocumentsOrdered()
    {
        $timestamp = [
            'seconds' => 123,
            'nanos' => 321
        ];
        $tpl = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/%s';
        $names = [
            sprintf($tpl, 'a'),
            sprintf($tpl, 'b'),
            sprintf($tpl, 'c'),
        ];

        $protoResponseArray = [
            self::generateProto(BatchGetDocumentsResponse::class, [
                'missing' => $names[2],
                'readTime' => $timestamp
            ]),
            self::generateProto(BatchGetDocumentsResponse::class, [
                'missing' => $names[1],
                'readTime' => $timestamp
            ]),
            self::generateProto(BatchGetDocumentsResponse::class, [
                'missing' => $names[0],
                'readTime' => $timestamp
            ]),
        ];

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($names) {
                foreach ($request->getDocuments() as $i => $documentName) {
                    $this->assertEquals($names[$i], $documentName);
                }

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()
            ->willReturn($this->getServerStreamMock($protoResponseArray));

        $res = $this->transaction->documents($names);
        $this->assertEquals($names[0], $res[0]->name());
        $this->assertEquals($names[1], $res[1]->name());
        $this->assertEquals($names[2], $res[2]->name());
    }

    private function expectAndInvoke(array $writes)
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) use ($writes) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());

                $protoWrites = (new Serializer())->encodeMessage($request);

                $this->assertEquals($writes, $protoWrites['writes']);

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(new CommitResponse());
        $this->transaction->writer()->commit();
    }

    private function getDbName(): string
    {
        return sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
    }
}
