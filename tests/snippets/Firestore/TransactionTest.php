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

namespace Google\Cloud\Tests\Snippets\Firestore;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Transaction;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const TRANSACTION = 'foobar';
    const DATABASE = 'projects/example_project/databases/(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $transaction;
    private $document;
    private $batch;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->transaction = \Google\Cloud\Dev\stub(TransactionStub::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::DATABASE,
            self::TRANSACTION
        ], ['connection', 'writer']);

        $this->document = $this->prophesize(DocumentReference::class);
        $this->document->name()->willReturn(self::DOCUMENT);

        $this->batch = $this->prophesize(WriteBatch::class);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['transaction' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $client = \Google\Cloud\Dev\stub(FirestoreClient::class);
        $client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $client);
        $snippet->invoke();
    }

    public function testSnapshot()
    {
        $this->connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'found' => [
                        'name' => self::DOCUMENT,
                        'fields' => [],
                        'readTime' => ['seconds' => time()]
                    ]
                ]
            ]));

        $this->transaction->setConnection($this->connection->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'snapshot');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(DocumentSnapshot::class, $res->returnVal());
    }

    public function testRunQuery()
    {
        $q = $this->prophesize(Query::class);
        $q->documents(Argument::any())->willReturn($this->prophesize(QuerySnapshot::class)->reveal());
        $snippet = $this->snippetFromMethod(Transaction::class, 'runQuery');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('query', $q->reveal());

        $res = $snippet->invoke('results');
        $this->assertInstanceOf(QuerySnapshot::class, $res->returnVal());
    }

    public function testCreate()
    {
        $this->batch->create(self::DOCUMENT, Argument::any(), Argument::any())->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'create');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->invoke();
    }

    public function testSet()
    {
        $this->batch->set(self::DOCUMENT, Argument::any(), Argument::any())->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'set');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->invoke();
    }

    public function testSetMerge()
    {
        $this->batch->set(self::DOCUMENT, Argument::any(), ['merge' => true])->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'set', 1);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->batch->update(self::DOCUMENT, Argument::any(), Argument::any())->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->invoke();
    }

    public function testUpdateSentinels()
    {
        $this->batch->update(self::DOCUMENT, [
            ['path' => 'country', 'value' => FieldValue::deleteField()],
            ['path' => 'lastLogin', 'value' => FieldValue::serverTimestamp()]
        ], Argument::any())->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'update', 1);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->invoke();
    }

    public function testUpdateSpecialChars()
    {
        $this->batch->update(self::DOCUMENT, Argument::any(), Argument::any())->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'update', 2);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->invoke();
    }

    public function testDelete()
    {
        $this->batch->delete(self::DOCUMENT, Argument::any(), Argument::any())->shouldBeCalled();

        $this->transaction->setWriter($this->batch->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $snippet->invoke();
    }
}

class TransactionStub extends Transaction
{
    private $database;

    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $database, $transaction)
    {
        $this->database = $database;

        parent::__construct($connection, $valueMapper, $database, $transaction);
    }

    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->writer = new WriteBatch(
            $connection,
            new ValueMapper($connection, false),
            $this->database,
            $this->___getProperty('transaction')
        );
    }

    public function setWriter(WriteBatch $writer)
    {
        $this->___setProperty('writer', $writer);
    }
}
