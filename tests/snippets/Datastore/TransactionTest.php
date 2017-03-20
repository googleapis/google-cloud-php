<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Snippets\Datastore;

use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group datastore
 */
class TransactionTest extends SnippetTestCase
{
    const PROJECT = 'my-awesome-project';

    private $connection;
    private $operation;
    private $transaction;
    private $transactionId = 'foo';
    private $datastore;
    private $key;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = \Google\Cloud\Dev\stub(Operation::class, [
            $this->connection->reveal(),
            self::PROJECT,
            '',
            new EntityMapper(self::PROJECT, false, false)
        ]);
        $this->transaction = new Transaction($this->operation, self::PROJECT, $this->transactionId);
        $this->datastore = new DatastoreClient;
        $this->key = new Key('my-awesome-project', [
            [
                'path' => [
                    ['kind' => 'Person', 'name' => 'Bob']
                ]
            ]
        ]);
    }

    public function testClass()
    {
        $connectionStub = $this->prophesize(ConnectionInterface::class);
        $connectionStub->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'transaction' => 'foo'
            ]);

        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($datastore);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($datastore, $connectionStub);
            $property->setAccessible(false);'
        );
        $snippet->addLocal('connectionStub', $connectionStub->reveal());

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insert');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'insert') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'insert') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->allocateIdsConnectionMock();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entity', $this->datastore->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'update') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entities', [
            $this->datastore->entity($this->datastore->key('Person', 'Bob'), [], ['populatedByService' => true]),
            $this->datastore->entity($this->datastore->key('Person', 'John'), [], ['populatedByService' => true])
        ]);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'update') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testUpsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'upsert');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entity', $this->datastore->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'upsert') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testUpsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'upsertBatch');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entities', [
            $this->datastore->entity($this->datastore->key('Person', 'Bob'), [], ['populatedByService' => true]),
            $this->datastore->entity($this->datastore->key('Person', 'John'), [], ['populatedByService' => true])
        ]);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'upsert') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'delete') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testDeleteBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'deleteBatch');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->commit(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            if (array_keys($args['mutations'][0])[0] !== 'delete') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testLookup()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookup');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->lookup(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->lookup(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ],
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'John']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'John'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals("Bob", explode("\n", $res->output())[0]);
        $this->assertEquals("John", explode("\n", $res->output())[1]);
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'runQuery');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('query', $this->prophesize(QueryInterface::class)->reveal());

        $this->connection->runQuery(Argument::that(function ($args) {
            if ($args['transaction'] !== $this->transactionId) return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => [
                                'key' => [
                                    'path' => [
                                        ['kind' => 'Person', 'name' => 'Bob']
                                    ]
                                ],
                                'properties' => [
                                    'firstName' => [
                                        'stringValue' => 'Bob'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('result');
        $this->assertEquals('Bob', $res->output());
    }

    public function testCommit()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testRollback()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->transaction);

        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    // ******** HELPERS

    private function allocateIdsConnectionMock()
    {
        $this->connection->allocateIds(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'keys' => [
                    [
                        'path' => [
                            [
                                'kind' => 'Person',
                                'id' => '4682475895'
                            ]
                        ]
                    ],
                    [
                        'path' => [
                            [
                                'kind' => 'Person',
                                'id' => '4682475896'
                            ]
                        ]
                    ]
                ]
            ]);

        return $this->connection->reveal();
    }
}
