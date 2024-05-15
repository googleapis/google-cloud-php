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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\FirestoreTestHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Firestore\AggregateQuery;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\Transaction;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as V1FirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends SnippetTestCase
{
    use FirestoreTestHelperTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    public const PROJECT = 'example_project';
    public const DATABASE_ID = '(default)';
    public const TRANSACTION = 'foobar';
    public const DATABASE = 'projects/example_project/databases/(default)';
    public const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    public const DOCUMENT_TEMPLATE = 'projects/%s/databases/%s/documents/users/%s';

    private $connection;
    private $requestHandler;
    private $serializer;
    private $transaction;
    private $document;
    private $batch;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = $this->getSerializer();
        $this->transaction = TestHelpers::stub(TransactionStub::class, [
            $this->connection->reveal(),
            $this->requestHandler->reveal(),
            $this->serializer,
            new ValueMapper(
                $this->connection->reveal(),
                $this->requestHandler->reveal(),
                $this->serializer,
                false
            ),
            self::DATABASE,
            self::TRANSACTION
        ], ['connection', 'requestHandler', 'writer']);

        $this->document = $this->prophesize(DocumentReference::class);
        $this->document->name()->willReturn(self::DOCUMENT);

        $this->batch = $this->prophesize(WriteBatch::class);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'beginTransaction',
            Argument::type(BeginTransactionRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['transaction' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $client = TestHelpers::stub(FirestoreClient::class, [], [
            'connection',
            'requestHandler'
        ]);
        $client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $client->___setProperty('connection', $this->connection->reveal());


        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $client);
        $snippet->invoke();
    }

    public function testSnapshot()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            [
                'found' => [
                    'name' => self::DOCUMENT,
                    'fields' => [],
                    'readTime' => (new \DateTime())->format(Timestamp::FORMAT)
                ]
            ]
        ]));

        $this->transaction->setConnection(
            $this->connection->reveal(),
            $this->requestHandler->reveal()
        );

        $snippet = $this->snippetFromMethod(Transaction::class, 'snapshot');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('document', $this->document->reveal());
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(DocumentSnapshot::class, $res->returnVal());
    }

    public function testRunAggregateQuery()
    {
        $this->connection->runAggregationQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([]));
        $aggregateQuery = new AggregateQuery(
            $this->connection->reveal(),
            $this->requestHandler->reveal(),
            $this->serializer,
            self::DOCUMENT,
            ['query' => []],
            Aggregate::count()
        );

        $snippet = $this->snippetFromMethod(Transaction::class, 'runAggregateQuery');
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('aggregateQuery', $aggregateQuery);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(AggregateQuerySnapshot::class, $res->returnVal());
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

    public function testDocuments()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            [
                'found' => [
                    'name' => sprintf(self::DOCUMENT_TEMPLATE, self::PROJECT, self::DATABASE_ID, 'john'),
                    'fields' => []
                ],
                'readTime' => (new \DateTime())->format(Timestamp::FORMAT)
            ], [
                'found' => [
                    'name' => sprintf(self::DOCUMENT_TEMPLATE, self::PROJECT, self::DATABASE_ID, 'dave'),
                    'fields' => []
                ],
                'readTime' => (new \DateTime())->format(Timestamp::FORMAT)
            ]
        ]);

        $this->transaction->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'documents');
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke('documents')->returnVal();

        $this->assertInstanceOf(DocumentSnapshot::class, $res[0]);
        $this->assertEquals('john', $res[0]->id());
    }

    public function testDocumentsDoesntExist()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            [
                'missing' => sprintf(self::DOCUMENT_TEMPLATE, self::PROJECT, self::DATABASE_ID, 'deleted-user'),
                'readTime' => (new \DateTime())->format(Timestamp::FORMAT)
            ]
        ]);

        $this->transaction->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snippet = $this->snippetFromMethod(Transaction::class, 'documents', 1);
        $snippet->addLocal('transaction', $this->transaction);
        $res = $snippet->invoke();

        $this->assertEquals('deleted-user Does Not Exist', $res->output());
    }
}

//@codingStandardsIgnoreStart
class TransactionStub extends Transaction
{
    use FirestoreTestHelperTrait;

    private $database;

    public function __construct(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        ValueMapper $valueMapper,
        $database,
        $transaction
    ) {
        $this->database = $database;

        parent::__construct(
            $connection,
            $requestHandler,
            $serializer,
            $valueMapper,
            $database,
            $transaction
        );
    }

    public function setConnection(ConnectionInterface $connection, RequestHandler $requestHandler)
    {
        $this->connection = $connection;
        $this->requestHandler = $requestHandler;
        $this->writer = new WriteBatch(
            $connection,
            $requestHandler,
            $this->getSerializer(),
            new ValueMapper(
                $connection,
                $requestHandler,
                $this->getSerializer(),
                false
            ),
            $this->database,
            $this->___getProperty('transaction')
        );
    }

    public function setWriter(WriteBatch $writer)
    {
        $this->___setProperty('writer', $writer);
    }
}
//@codingStandardsIgnoreEnd
