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
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\CommitResponse\CommitStats;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\ResultSet;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Rpc\Status;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class TransactionTest extends SnippetTestCase
{
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    private $spannerClient;
    private $serializer;
    private $transaction;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();
        $operation = new Operation($this->spannerClient->reveal(), $this->serializer);
        $session = $this->prophesize(SessionCache::class);
        $session->name()->willReturn(self::SESSION);

        $this->transaction = new Transaction(
            $operation,
            $session->reveal(),
            self::TRANSACTION,
            ['isRetry' => true]
        );
    }

    public function testClass()
    {
        $database = $this->prophesize(Database::class);
        $database->runTransaction(Argument::type('callable'))
            ->shouldBeCalled()
            ->willReturn(null);

        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->replace('$database =', '//$database =');
        $snippet->addLocal('database', $database->reveal());

        $res = $snippet->invoke();
    }

    public function testClassReturnTransaction()
    {
        $transaction = $this->prophesize(Transaction::class)->reveal();
        $database = $this->prophesize(Database::class);
        $database->transaction()
            ->shouldBeCalled()
            ->willReturn($transaction);

        $snippet = $this->snippetFromClass(Transaction::class, 1);
        $snippet->addLocal('database', $database->reveal());
        $res = $snippet->invoke('transaction');
        $this->assertEquals($transaction, $res->returnVal());
    }

    public function testExecute()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $snippet = $this->snippetFromMagicMethod(Transaction::class, 'execute');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testExecuteUpdate()
    {
        $stats = new ResultSetStats(['row_count_exact' => 1]);
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(null, $stats));

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdate');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('modifiedRowCount');

        $this->assertEquals(1, $res->returnVal());
    }

    public function testExecuteUpdateWithStruct()
    {
        $expectedSql = "UPDATE Posts SET title = 'Updated Title' WHERE " .
            'STRUCT<Title STRING, Content STRING>(Title, Content) = @post';

        $expectedParams = [
            'post' => ['Updated Title', 'Sample Content']
        ];
        $expectedStructData = [
            [
                'name' => 'Title',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ],
            [
                'name' => 'Content',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) use ($expectedSql, $expectedParams, $expectedStructData) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($expectedSql, $args->getSql());
                $this->assertEquals($message['params'], $expectedParams);
                $this->assertEquals($message['paramTypes']['post']['structType']['fields'], $expectedStructData);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                [],
                new ResultSetStats(['row_count_exact' => 1])
            ));

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
        $this->spannerClient->executeBatchDml(
            Argument::type(ExecuteBatchDmlRequest::class),
            Argument::type('array')
        )->willReturn(new ExecuteBatchDmlResponse([
                'result_sets' => [
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 1
                        ])
                    ])
                ]
            ]));

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke();

        $this->assertEquals('Updated 1 row(s) across 1 statement(s)', $res->output());
    }

    public function testExecuteUpdateBatchError()
    {
        $this->spannerClient->executeBatchDml(
            Argument::type(ExecuteBatchDmlRequest::class),
            Argument::type('array')
        )->willReturn(new ExecuteBatchDmlResponse([
                'result_sets' => [],
                'status' => new Status([
                    'code' => 3,
                    'message' => 'foo'
                ])
            ]));

        $snippet = $this->snippetFromMethod(Transaction::class, 'executeUpdateBatch');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke();

        $this->assertEquals('An error occurred: foo', $res->output());
    }

    public function testRead()
    {
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream());

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
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('insert', $mutations[0]);
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('insert', $mutations[0]);
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('update', $mutations[0]);
    }

    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('update', $mutations[0]);
    }

    public function testInsertOrUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdate');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }

    public function testInsertOrUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdateBatch');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }

    public function testReplace()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replace');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('replace', $mutations[0]);
    }

    public function testReplaceBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replaceBatch');
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('replace', $mutations[0]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('mutationGroup', $this->transaction);
        $snippet->invoke();

        $reflProp = new \ReflectionProperty($this->transaction, 'mutationData');
        $reflProp->setAccessible(true);
        $mutations = $reflProp->getValue($this->transaction);
        $this->assertArrayHasKey('delete', $mutations[0]);
    }

    public function testRollback()
    {
        $this->spannerClient->rollback(
            Argument::type(RollbackRequest::class),
            Argument::type('array')
        )->shouldBeCalledOnce();

        $snippet = $this->snippetFromMethod(Transaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->transaction);

        $snippet->invoke();
    }

    public function testCommit()
    {
        $this->spannerClient->commit(
            Argument::type(CommitRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
        $snippet->addLocal('transaction', $this->transaction);

        $snippet->invoke();
    }

    public function testGetCommitStats()
    {
        $expectedCommitStats = new CommitStats(['mutation_count' => 4]);
        $this->spannerClient->commit(
            Argument::type(CommitRequest::class),
            Argument::type('array')
        )->willReturn(new CommitResponse([
            'commit_stats' => $expectedCommitStats,
        ]));

        $snippet = $this->snippetFromMethod(Transaction::class, 'getCommitStats');
        $snippet->addLocal('transaction', $this->transaction);

        $res = $snippet->invoke('commitStats');
        $this->assertInstanceOf(CommitStats::class, $res->returnVal());
        $this->assertEquals(4, $res->returnVal()->getMutationCount());
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

        $res = $snippet->invoke();
        $this->assertEquals('This is a retry transaction!', $res->output());
    }
}
