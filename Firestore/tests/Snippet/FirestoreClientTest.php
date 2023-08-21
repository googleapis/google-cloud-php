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

use Google\Cloud\Core\Blob;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\WriteBatch;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-client
 */
class FirestoreClientTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $connection;
    private $client;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(FirestoreClient::class, [
            ['projectId' => self::PROJECT]
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(FirestoreClient::class);
        $res = $snippet->invoke('firestore');
        $this->assertInstanceOf(FirestoreClient::class, $res->returnVal());
    }

    public function testEmulator()
    {
        $snippet = $this->snippetFromClass(FirestoreClient::class, 1);
        $res = $snippet->invoke('firestore');
        $this->assertInstanceOf(FirestoreClient::class, $res->returnVal());
        $this->assertEquals('localhost:8900', getenv('FIRESTORE_EMULATOR_HOST'));
    }

    public function testBatch()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'batch');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(WriteBatch::class, $res->returnVal());
    }

    public function testCollection()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'collection');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('collection');
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal());
    }

    public function testCollections()
    {
        $this->connection->listCollectionIds(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'collectionIds' => ['users', 'accounts']
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'collections');
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke('collections');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal()->current());
    }

    public function testDocument()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'document');
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke('document');
        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testDocuments()
    {
        $tpl = 'projects/%s/databases/%s/documents/users/%s';

        $this->connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                [
                    'found' => [
                        'name' => sprintf($tpl, self::PROJECT, self::DATABASE, 'john'),
                        'fields' => []
                    ],
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ], [
                    'found' => [
                        'name' => sprintf($tpl, self::PROJECT, self::DATABASE, 'dave'),
                        'fields' => []
                    ],
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'documents');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('documents')->returnVal();

        $this->assertInstanceOf(DocumentSnapshot::class, $res[0]);
        $this->assertEquals('john', $res[0]->id());
    }

    public function testDocumentsDoesntExist()
    {
        $tpl = 'projects/%s/databases/%s/documents/users/%s';
        $this->connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                [
                    'missing' => sprintf($tpl, self::PROJECT, self::DATABASE, 'deleted-user'),
                    'readTime' => (new \DateTime)->format(Timestamp::FORMAT)
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'documents', 1);
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke();

        $this->assertEquals('deleted-user Does Not Exist', $res->output());
    }

    public function testCollectionGroup()
    {
        $this->connection->runQuery(Argument::any())
            ->willReturn(new \ArrayIterator([
                [
                    'document' => [
                        'name' => 'a/b/c/d',
                        'fields' => []
                    ],
                    'readTime' => null
                ], [
                    'document' => [
                        'name' => 'c/d',
                        'fields' => []
                    ],
                    'readTime' => null
                ]
            ]));

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'collectionGroup');
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('2 documents found!', $res->output());
    }

    public function testRunTransaction()
    {
        $from = sprintf('projects/%s/databases/%s/documents/users/john', self::PROJECT, self::DATABASE);
        $to = sprintf('projects/%s/databases/%s/documents/users/dave', self::PROJECT, self::DATABASE);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['transaction' => 'foo']);

        $this->connection->batchGetDocuments(Argument::withEntry('documents', [$from]))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'found' => [
                        'name' => $from,
                        'readTime' => (new \DateTime)->format(Timestamp::FORMAT),
                        'fields' => [
                            'balance' => [
                                'doubleValue' => 1000.00
                            ]
                        ]
                    ]
                ]
            ]));

        $this->connection->batchGetDocuments(Argument::withEntry('documents', [$to]))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'found' => [
                        'name' => $to,
                        'readTime' => (new \DateTime)->format(Timestamp::FORMAT),
                        'fields' => [
                            'balance' => [
                                'doubleValue' => 1000.00
                            ]
                        ]
                    ]
                ]
            ]));

        $this->connection->commit(Argument::any())
            ->shouldBeCalled();

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'runTransaction');
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke('toNewBalance');
        $this->assertEquals(1500.00, $res->returnVal());
    }

    public function testGeoPoint()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'geoPoint');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('geoPoint');
        $this->assertInstanceOf(GeoPoint::class, $res->returnVal());
    }

    public function testBlob()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'blob');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('blob');
        $this->assertInstanceOf(Blob::class, $res->returnVal());
    }

    public function testBlobBinaryData()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'blob', 1);
        $snippet->addLocal('firestore', $this->client);
        $snippet->replace("__DIR__ .'/family-photo.jpg'", "'php://temp'");
        $res = $snippet->invoke('blob');
        $this->assertInstanceOf(Blob::class, $res->returnVal());
    }

    public function testFieldPath()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'fieldPath');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('path');
        $this->assertInstanceOf(FieldPath::class, $res->returnVal());
    }
}
