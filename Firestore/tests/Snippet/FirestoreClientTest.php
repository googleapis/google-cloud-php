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

use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Blob;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\BulkWriter;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\Tests\Unit\ServerStreamMockTrait;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as GapicFirestoreClient;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\ListCollectionIdsResponse;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Cloud\Firestore\WriteBatch;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-client
 */
class FirestoreClientTest extends SnippetTestCase
{
    use GenerateProtoTrait;
    use ServerStreamMockTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $gapicClient;
    private $client;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->gapicClient = $this->prophesize(GapicFirestoreClient::class);
        $this->client = new FirestoreClient([
            'projectId' => self::PROJECT,
            'firestoreClient' => $this->gapicClient->reveal()
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

    public function testCollection()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'collection');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('collection');
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal());
    }

    public function testCollections()
    {
        $protoResponse = self::generateProto(ListCollectionIdsResponse::class, [
            'collectionIds' => ['users', 'accounts']
        ]);

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn($protoResponse);

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->shouldBeCalled(1)
            ->willReturn($page->reveal());

        $this->gapicClient->listCollectionIds(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($pagedListResponse->reveal());

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

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => sprintf($tpl, self::PROJECT, self::DATABASE, 'john'),
                'fields' => []
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ]
        ]);

        $protoResponse2 = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => sprintf($tpl, self::PROJECT, self::DATABASE, 'dave'),
                'fields' => []
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ]
        ]);

        $this->gapicClient->batchGetDocuments(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse, $protoResponse2]));

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'documents');
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke('documents')->returnVal();

        $this->assertInstanceOf(DocumentSnapshot::class, $res[0]);
        $this->assertEquals('john', $res[0]->id());
    }

    public function testDocumentsDoesntExist()
    {
        $tpl = 'projects/%s/databases/%s/documents/users/%s';

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'missing' => sprintf($tpl, self::PROJECT, self::DATABASE, 'deleted-user'),
            'readTime' => [
                'nanos' => 321,
                'seconds' => 123
            ]
        ]);

        $this->gapicClient->batchGetDocuments(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'documents', 1);
        $snippet->addLocal('firestore', $this->client);
        $res = $snippet->invoke();

        $this->assertEquals('deleted-user Does Not Exist', $res->output());
    }

    public function testCollectionGroup()
    {
        $protoResponses = [
            self::generateProto(RunQueryResponse::class, [
                'document' => [
                    'name' => 'a/b/c/d',
                    'fields' => []
                ]
            ]),
            self::generateProto(RunQueryResponse::class, [
                'document' => [
                    'name' => 'c/d',
                    'fields' => []
                ]
            ])
        ];

        $this->gapicClient->runQuery(Argument::any(), Argument::any())
            ->willReturn($this->getServerStreamMock($protoResponses));

        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'collectionGroup');
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('2 documents found!', $res->output());
    }

    public function testRunTransaction()
    {
        $from = sprintf('projects/%s/databases/%s/documents/users/john', self::PROJECT, self::DATABASE);
        $to = sprintf('projects/%s/databases/%s/documents/users/dave', self::PROJECT, self::DATABASE);

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new BeginTransactionResponse(['transaction' => 'foo']));

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => $from,
                'fields' => [
                    'balance' => [
                        'doubleValue' => 1000.00
                    ]
                ]
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ],
        ]);

        $protoResponse2 = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => $to,
                'fields' => [
                    'balance' => [
                        'doubleValue' => 1000.00
                    ]
                ]
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ],
        ]);

        $callNumber = 0;

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($from, $to, &$callNumber) {
                $toAssert = [$from, $to];
                $this->assertEquals($toAssert[$callNumber], $request->getDocuments()[0]);
                $callNumber++;
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()
            ->willReturn(
                $this->getServerStreamMock([$protoResponse]),
                $this->getServerStreamMock([$protoResponse2])
            );

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

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
