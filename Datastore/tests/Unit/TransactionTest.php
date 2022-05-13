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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Transaction;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * This test case includes a data provider to run tests on both rw and ro transactions.
 *
 * @group datastore
 * @group datastore-transaction
 */
class TransactionTest extends TestCase
{
    use DatastoreOperationRefreshTrait;

    const PROJECT = 'example-project';
    const TRANSACTION = 'transaction-id';

    private $connection;
    private $transaction;
    private $readOnly;
    private $key;
    private $entity;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $op = new Operation(
            $this->connection->reveal(),
            self::PROJECT,
            null,
            new EntityMapper(self::PROJECT, false, false)
        );

        $this->transaction = TestHelpers::stub(Transaction::class, [
            $op, self::PROJECT, self::TRANSACTION
        ], ['operation']);

        $this->readOnly = TestHelpers::stub(ReadOnlyTransaction::class, [
            $op, self::PROJECT, self::TRANSACTION
        ], ['operation']);

        $this->key = $op->key('Person', 12345);
        $this->entity = $op->entity($this->key, ['name' => 'John']);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookup(callable $transaction)
    {
        $this->connection->lookup(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('keys', [$this->key->keyObject()])
        ))->shouldBeCalled()->willReturn([
            'found' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ]
        ]);

        $transaction = $transaction();
        $this->refreshOperation($transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookup($this->key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($this->key->keyObject(), $res->key()->keyObject());
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupMissing(callable $transaction)
    {
        $this->connection->lookup(
            Argument::withEntry('keys', [$this->key->keyObject()])
        )->shouldBeCalled()->willReturn([
            'missing' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ]
        ]);

        $transaction = $transaction();
        $this->refreshOperation($transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookup($this->key);
        $this->assertNull($res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupBatch(callable $transaction)
    {
        $this->connection->lookup(
            Argument::withEntry('keys', [$this->key->keyObject()])
        )->shouldBeCalled()->willReturn([
            'found' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ],
            'missing' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ],
            'deferred' => [
                $this->key->keyObject()
            ]
        ]);

        $transaction = $transaction();
        $this->refreshOperation($transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookupBatch([$this->key]);
        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRunQuery(callable $transaction)
    {
        $this->connection->runQuery(Argument::allOf(
            Argument::withEntry('partitionId', ['projectId' => self::PROJECT]),
            Argument::withEntry('gqlQuery', ['queryString' => 'SELECT 1=1'])
        ))->shouldBeCalled()->willReturn([
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ]
            ]
        ]);

        $transaction = $transaction();
        $this->refreshOperation($transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);

        $res = iterator_to_array($transaction->runQuery($query->reveal()));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRollback(callable $transaction)
    {
        $this->connection->rollback(Argument::withEntry('transaction', self::TRANSACTION))
            ->shouldBeCalled();

        $transaction = $transaction();
        $this->refreshOperation($transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $transaction->rollback();
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutations($method, $mutation, $key)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->$method($this->entity, ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutationsBatch($method, $mutation, $key)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $method .= 'Batch';

        $this->transaction->$method([$this->entity], ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function mutationsProvider()
    {
        return $this->mutationsProviderProvider(12345);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->connection->allocateIds(Argument::allOf(
            Argument::withEntry('keys', [$key->keyObject()])
        ))->shouldBeCalled()->willReturn([
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method($entity);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testBatchMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->connection->allocateIds(Argument::allOf(
            Argument::withEntry('keys', [$key->keyObject()])
        ))->shouldBeCalled()->willReturn([
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $method .= 'Batch';
        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method([$entity]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function partialKeyMutationsProvider()
    {
        $res = $this->mutationsProviderProvider(12345, true);
        return array_filter($res, function ($case) {
            return $case[0] !== 'update';
        });
    }

    public function testDelete()
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [
                [
                    'delete' => $this->key->keyObject()
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->delete($this->key);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function testDeleteBatch()
    {

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::withEntry('mutations', [
                [
                    'delete' => $this->key->keyObject()
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->transaction, $this->connection->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->deleteBatch([$this->key]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    private function entityArray(Key $key)
    {
        return [
            'key' => $key->keyObject(),
            'properties' => [
                'name' => [
                    'stringValue' => 'John'
                ]
            ]
        ];
    }

    private function mutationsProviderProvider($id, $partialKey = false)
    {
        $key = new Key(self::PROJECT);
        $key->pathElement('Person', !$partialKey ? $id : null);
        $mutation = $this->entityArray($key);

        if ($partialKey) {
            $mutation['key']['path'][0]['id'] = $id;
        }

        return [
            ['insert', $mutation, clone $key, $id],
            ['update', $mutation, clone $key, $id],
            ['upsert', $mutation, clone $key, $id],
        ];
    }

    private function commitResponse()
    {
        return [
            'mutationResults' => [
                [
                    'version' => 1
                ]
            ]
        ];
    }

    public function transactionProvider()
    {
        // init so the callbacks have a reference to hold until invoked.
        $this->setUp();

        return [
            // return callables to get around phpunit's annoying habit of running data providers way too early.
            [
                function () {
                    return $this->transaction;
                }
            ], [
                function () {
                    return $this->readOnly;
                }
            ]
        ];
    }
}
