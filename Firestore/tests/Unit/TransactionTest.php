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
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Transaction;
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
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $connection;
    private $valueMapper;
    private $transaction;
    private $ref;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->valueMapper = new ValueMapper($this->connection->reveal(), false);
        $this->transaction = TestHelpers::stub(Transaction::class, [
            $this->connection->reveal(),
            $this->valueMapper,
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            self::TRANSACTION
        ]);

        $this->ref = $this->prophesize(DocumentReference::class);
        $this->ref->name()->willReturn(self::DOCUMENT);
    }

    public function testSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::DOCUMENT],
            'transaction' => self::TRANSACTION
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
            [
                'found' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ]
            ]
        ]));

        $this->transaction->___setProperty('connection', $this->connection->reveal());

        $res = $this->transaction->snapshot($this->ref->reveal());
        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::DOCUMENT, $res->name());
        $this->assertEquals('world', $res['hello']);
    }

    public function testRunQuery()
    {
        $this->connection->runQuery(Argument::withEntry('transaction', self::TRANSACTION))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([[]]));

        $query = new Query($this->connection->reveal(), $this->valueMapper, '', ['from' => ['collectionId' => '']]);

        $res = $this->transaction->runQuery($query);
        $this->assertInstanceOf(QuerySnapshot::class, $res);
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testRunAggregateQuery($type, $arg)
    {
        $this->connection->runAggregationQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([]));

        $aggregateQuery = new AggregateQuery(
            $this->connection->reveal(),
            self::DOCUMENT,
            ['query' => []],
            $arg ? Aggregate::$type($arg) : Aggregate::$type()
        );

        $this->transaction->___setProperty('connection', $this->connection->reveal());

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
            $this->connection->reveal(),
            self::DOCUMENT,
            ['query' => []],
            $arg ? Aggregate::$type($arg) : Aggregate::$type()
        );
        $this->connection->runAggregationQuery(
            Argument::withEntry('readTime', $timestamp)
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            [
                'result' => [
                    'aggregateFields' => [
                        $type => ['integerValue' => 1]
                    ]
                ]
            ]
        ]));

        $this->transaction->___setProperty('connection', $this->connection->reveal());

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
                ]
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
                ]
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
                ]
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
                ]
            ]
        ]);
    }

    public function testDelete()
    {
        $this->transaction->delete($this->ref->reveal());

        $this->expectAndInvoke([
            [
                'delete' => self::DOCUMENT
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testDocuments(array $input, array $names)
    {
        $timestamp = (new Timestamp(new \DateTimeImmutable))->formatAsString();

        $res = [
            [
                'found' => [
                    'name' => $names[0],
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ],
                'readTime' => $timestamp
            ], [
                'missing' => $names[1],
                'readTime' => $timestamp
            ], [
                'missing' => $names[2],
                'readTime' => $timestamp
            ]
        ];

        $this->connection->batchGetDocuments(Argument::allOf(
            Argument::withEntry('documents', $names),
            Argument::withEntry('transaction', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn($res);

        $this->transaction->___setProperty('connection', $this->connection->reveal());

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
        $timestamp = (new Timestamp(new \DateTimeImmutable))->formatAsString();
        $tpl = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/%s';
        $names = [
            sprintf($tpl, 'a'),
            sprintf($tpl, 'b'),
            sprintf($tpl, 'c'),
        ];

        $res = [
            [
                'missing' => $names[2],
                'readTime' => $timestamp
            ], [
                'missing' => $names[1],
                'readTime' => $timestamp
            ], [
                'missing' => $names[0],
                'readTime' => $timestamp
            ]
        ];

        $this->connection->batchGetDocuments(Argument::withEntry('documents', $names))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->transaction->___setProperty('connection', $this->connection->reveal());

        $res = $this->transaction->documents($names);
        $this->assertEquals($names[0], $res[0]->name());
        $this->assertEquals($names[1], $res[1]->name());
        $this->assertEquals($names[2], $res[2]->name());
    }

    private function expectAndInvoke(array $writes)
    {
        $this->connection->commit([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => $writes,
            'transaction' => self::TRANSACTION
        ])->shouldBeCalled();
        $this->transaction->___setProperty('connection', $this->connection->reveal());
        $this->transaction->writer()->commit();
    }
}
