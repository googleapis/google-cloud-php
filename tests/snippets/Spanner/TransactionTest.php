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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class TransactionTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const TRANSACTION = 'my-transaction';

    private $connection;
    private $transaction;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $operation = $this->prophesize(Operation::class);
        $session = $this->prophesize(Session::class);

        $this->transaction = \Google\Cloud\Dev\stub(Transaction::class, [
            $operation->reveal(),
            $session->reveal(),
            self::TRANSACTION
        ], ['operation', 'isRetry']);
    }

    private function stubOperation($stub = null)
    {
        $operation = \Google\Cloud\Dev\stub(Operation::class, [
            $this->connection->reveal(), false
        ]);

        if (!$stub) {
            $stub = $this->transaction;
        }

        $stub->___setProperty('operation', $operation);
    }

    public function testClass()
    {
        $database = $this->prophesize(Database::class);
        $database->runTransaction(Argument::type('callable'))->shouldBeCalled();

        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->replace('$database =', '//$database =');
        $snippet->addLocal('database', $database->reveal());

        $res = $snippet->invoke();
    }

    public function testClassReturnTransaction()
    {
        $database = $this->prophesize(Database::class);
        $database->transaction()
            ->shouldBeCalled()
            ->willReturn('foo');

        $snippet = $this->snippetFromClass(Transaction::class, 1);
        $snippet->addLocal('database', $database->reveal());
        $res = $snippet->invoke('transaction');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testExecute()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->stubOperation();

        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'execute');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testRead()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->stubOperation();

        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'read');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addUse(KeySet::class);
        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'id');
        $snippet->addLocal('transaction', $this->transaction);

        $res = $snippet->invoke('id');
        $this->assertEquals(self::TRANSACTION, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insert');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['insert']));
    }


    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['insert']));
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['update']));
    }


    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['update']));
    }

    public function testInsertOrUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdate');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['insertOrUpdate']));
    }


    public function testInsertOrUpdateBatch()
    {
        $this->stubOperation();

        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['insertOrUpdate']));
    }

    public function testReplace()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replace');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['replace']));
    }


    public function testReplaceBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replaceBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['replace']));
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('transaction', $this->transaction);

        $this->stubOperation();

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertTrue(isset($mutations[0]['delete']));
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->stubOperation();

        $snippet = $this->snippetFromMethod(Transaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->transaction);

        $snippet->invoke();
    }

    public function testCommit()
    {
        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]);

        $this->stubOperation();

        $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
        $snippet->addLocal('transaction', $this->transaction);

        $snippet->invoke();
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'state');
        $snippet->addLocal('transaction', $this->transaction);

        $res = $snippet->invoke('state');
        $this->assertEquals(Transaction::STATE_ACTIVE, $res->returnVal());
    }

    public function testIsRetry()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'isRetry');
        $snippet->addLocal('transaction', $this->transaction);

        $this->transaction->___setProperty('isRetry', true);

        $res = $snippet->invoke();
        $this->assertEquals('This is a retry transaction!', $res->output());
    }

    private function resultGenerator()
    {
        yield [
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'loginCount',
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [0]
        ];
    }
}
