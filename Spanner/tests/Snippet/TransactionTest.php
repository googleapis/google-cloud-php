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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\CommitResponse\CommitStats;
use Prophecy\Argument;

/**
 * @group spanner
 */
class TransactionTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;

    const TRANSACTION = 'my-transaction';

    private $connection;
    private $transaction;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $operation = $this->prophesize(Operation::class);
        $session = $this->prophesize(Session::class);
        $session->info()
            ->willReturn([
                'databaseName' => 'database'
            ]);
        $session->name()
            ->willReturn('database');

        $this->transaction = TestHelpers::stub(Transaction::class, [
            $operation->reveal(),
            $session->reveal(),
            self::TRANSACTION
        ], ['operation', 'isRetry']);
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

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'execute');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testExecuteUpdate()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdate');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('modifiedRowCount');

        $this->assertEquals(1, $res->returnVal());
    }

    public function testExecuteUpdateWithStruct()
    {
        $expectedSql = "UPDATE Posts SET title = 'Updated Title' WHERE " .
            "STRUCT<Title STRING, Content STRING>(Title, Content) = @post";

        $expectedParams = [
            'post' => ["Updated Title", "Sample Content"]
        ];
        $expectedStructData = [
            [
                "name" => "Title",
                "type" => [
                    "code" => Database::TYPE_STRING
                ]
            ],
            [
                "name" => "Content",
                "type" => [
                    "code" => Database::TYPE_STRING
                ]
            ]
        ];

        $this->connection->executeStreamingSql(
            Argument::allOf(
                Argument::withEntry('sql', $expectedSql),
                Argument::withEntry('params', $expectedParams),
                Argument::withEntry(
                    'paramTypes',
                    Argument::withEntry(
                        'post',
                        Argument::withEntry(
                            'structType',
                            Argument::withEntry('fields', Argument::is($expectedStructData))
                        )
                    )
                )
            )
        )
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdate', 1);
        $snippet->addUse(Database::class);
        $snippet->addUse(StructType::class);
        $snippet->addUse(StructValue::class);

        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('modifiedRowCount');

        $this->assertEquals(1, $res->returnVal());
    }

    public function testExecuteUpdateBatch()
    {
        $this->connection->executeBatchDml(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resultSets' => [
                    [
                        'stats' => [
                            'rowCountExact' => 1
                        ]
                    ]
                ]
            ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke();

        $this->assertEquals('Updated 1 row(s) across 1 statement(s)', $res->output());
    }

    public function testExecuteUpdateBatchError()
    {
        $this->connection->executeBatchDml(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resultSets' => [],
                'status' => [
                    'code' => 3,
                    'message' => 'foo'
                ]
            ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke();

        $this->assertEquals('An error occurred: foo', $res->output());
    }

    public function testRead()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'read');
        $snippet->addLocal('transaction', $this->transaction);
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

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('insert', $mutations[0]);
    }


    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('insert', $mutations[0]);
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('update', $mutations[0]);
    }


    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('update', $mutations[0]);
    }

    public function testInsertOrUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdate');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }


    public function testInsertOrUpdateBatch()
    {
        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }

    public function testReplace()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replace');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('replace', $mutations[0]);
    }


    public function testReplaceBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replaceBatch');
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('replace', $mutations[0]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('transaction', $this->transaction);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $snippet->invoke();

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertArrayHasKey('delete', $mutations[0]);
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->refreshOperation($this->transaction, $this->connection->reveal());

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

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
        $snippet->addLocal('transaction', $this->transaction);

        $snippet->invoke();
    }

    public function testGetCommitStats()
    {
        $expectedCommitStats = new CommitStats(['mutation_count' => 4]);
        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString(),
                'commitStats' => $expectedCommitStats,
            ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'getCommitStats');
        $snippet->addLocal('transaction', $this->transaction);

        $res = $snippet->invoke('commitStats');
        $this->assertEquals($expectedCommitStats, $res->returnVal());
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
}
