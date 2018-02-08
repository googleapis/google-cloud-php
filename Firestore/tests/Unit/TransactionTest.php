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

use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Transaction;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $connection;
    private $valueMapper;
    private $transaction;
    private $reference;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->valueMapper = new ValueMapper($this->connection->reveal(), false);
        $this->transaction = \Google\Cloud\Core\Testing\TestHelpers::stub(Transaction::class, [
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
        $name = function ($name) {
            return sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, $name);
        };

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
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[1],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[2],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
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
                    'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/b',
                    'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/c',
                    'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/d'
                ]
                ], [
                    [
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/b',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/c',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/d'
                    ], [
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/b',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/c',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/d'
                    ]
                ], [
                    [
                        $b->reveal(),
                        $c->reveal(),
                        $d->reveal()
                    ], [
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/b',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/c',
                        'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/d'
                    ]
                ]
        ];
    }

    public function testDocumentsOrdered()
    {
        $tpl = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents/a/%s';
        $names = [
            sprintf($tpl, 'a'),
            sprintf($tpl, 'b'),
            sprintf($tpl, 'c'),
        ];

        $res = [
            [
                'missing' => $names[2],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[1],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[0],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
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
