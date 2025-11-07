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

use ArrayIterator;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Blob;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as GapicFirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\ListCollectionIdsRequest;
use Google\ApiCore\ServerStream;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1\Document as GapicDocument;
use Google\Cloud\Firestore\V1\RollbackRequest;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

use function PHPUnit\Framework\assertEquals;

/**
 * @group firestore
 * @group firestore-client
 */
class FirestoreClientTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use GenerateProtoTrait;

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
            'database' => self::DATABASE,
            'firestoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testCollection()
    {
        $collection = $this->client->collection('collectionName');

        $this->assertInstanceOf(CollectionReference::class, $collection);
        $this->assertEquals('collectionName', $collection->id());
    }

    public function testCollections()
    {
        $collectionIds = [
            'collection-a',
            'collection-b',
            'collection-c',
        ];

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getIterator()
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                'collectionIds' => $collectionIds
            ]));

        $this->gapicClient->listCollectionIds(Argument::type(ListCollectionIdsRequest::class), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($pagedListResponse->reveal());

        $collections = $this->client->collections([
            'resultLimit' => 3
        ]);

        $this->assertInstanceOf(ItemIterator::class, $collections);

        $arr = iterator_to_array($collections);
        $this->assertInstanceOf(CollectionReference::class, $arr[0]);
        $this->assertEquals($arr[0]->id(), $collectionIds[0]);
        $this->assertEquals($arr[1]->id(), $collectionIds[1]);
        $this->assertEquals($arr[2]->id(), $collectionIds[2]);
    }

    public function testCollectionsPaged()
    {
        $collectionIds = [
            'collection-a',
            'collection-b',
            'collection-c',
        ];

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getIterator()
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                'collectionIds' => $collectionIds,
                'nextPageToken' => 'nextPageTokenValue'
            ]));

        $this->gapicClient->listCollectionIds(
            Argument::that(function (ListCollectionIdsRequest $request) {
                if (!empty($request->getPageToken()) && $request->getPageToken() !== 'nextPageTokenValue') {
                    $this->fail('The pageToken value is the incorrect value');
                }
                return true;
            }),
            Argument::any()
        )->willReturn($pagedListResponse->reveal())->shouldBeCalledTimes(2);

        $collections = $this->client->collections();

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($collections as $collection) {
            $i++;
            $arr[] = $collection;
            if ($i == 6) {
                break;
            }
        }

        $this->assertCount(6, $arr);
    }

    public function testDocument()
    {
        $document = $this->client->document('a/b');

        $this->assertInstanceOf(DocumentReference::class, $document);
        $this->assertEquals('b', $document->id());
    }

    // public function testDocumentPathSpecialChars()
    // {
    //     $id = 'a!@#$%^&*(){[{}]+=-_|';
    //     $document = $this->client->document('a/' . $id);

    //     $this->assertInstanceOf(DocumentReference::class, $document);
    //     $this->assertEquals($id, $document->id());
    // }

    /**
     * @dataProvider paths
     */
    public function testInvalidPath($method, $name)
    {
        $this->expectException(InvalidArgumentException::class);

        call_user_func([$this->client, $method], $name);
    }

    public function paths()
    {
        return [
            ['collection', 'a/b'],
            ['collection', 'a/b/c/d'],
            ['document', 'a'],
            ['document', 'a/b/c']
        ];
    }

    /**
     * @dataProvider documents
     */
    public function testDocuments(array $input, array $names)
    {
        $responses = [
            (new BatchGetDocumentsResponse([
                'found' => self::generateProto(GapicDocument::class, [
                    'name' => $names[0],
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ]),
                'read_time' => new ProtobufTimestamp(),
            ])),
            (new BatchGetDocumentsResponse([
                'missing' => $names[1],
                'read_time' => new ProtobufTimestamp()
            ])),
            (new BatchGetDocumentsResponse([
                'missing' => $names[2],
                'read_time' => new ProtobufTimestamp()
            ]))
        ];

        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new \ArrayIterator($responses));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($names) {
                $this->assertNotEmpty($request->getDocuments());
                $this->assertEquals($names, iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($stream->reveal());

        $res = $this->client->documents($input);

        $this->assertEquals('world', $res[0]['hello']);
        $this->assertFalse($res[1]->exists());
        $this->assertFalse($res[2]->exists());
    }

    public function testDocumentsInvalidInputType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->documents([
            10
        ]);
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

        $responses = [
            new BatchGetDocumentsResponse([
                'missing' => $names[2],
                'read_time' => new ProtobufTimestamp()
            ]),
            new BatchGetDocumentsResponse([
                'missing' => $names[1],
                'read_time' => new ProtobufTimestamp()
            ]),
            new BatchGetDocumentsResponse([
                'missing' => $names[0],
                'read_time' => new ProtobufTimestamp()
            ])
        ];

        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new \ArrayIterator($responses));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($names) {
                $this->assertNotEmpty($request->getDocuments());
                $this->assertEquals($names, iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($stream->reveal());

        $res = $this->client->documents($names);
        $this->assertEquals($names[0], $res[0]->name());
        $this->assertEquals($names[1], $res[1]->name());
        $this->assertEquals($names[2], $res[2]->name());
    }

    public function testCollectionGroup()
    {
        $responses = [
            new RunQueryResponse([
                'document' => new GapicDocument([
                    'name' => 'a/b/c/d',
                    'fields' => []
                ]),
                'read_time' => null,
            ]),
            new RunQueryResponse([
                'document' => new GapicDocument([
                    'name' => 'c/d',
                    'fields' => []
                ]),
                'read_time' => null,
            ])
        ];

        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()
            ->willReturn(new ArrayIterator($responses));

        $this->gapicClient->runQuery(
            Argument::that(function (RunQueryRequest $request) {
                $this->assertNotEmpty($request->getStructuredQuery());
                $this->assertEquals($request->getParent(), 'projects/'. self::PROJECT .'/databases/'. self::DATABASE .'/documents');
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($serverStream->reveal());

        $query = $this->client->collectionGroup('foo');

        $this->assertInstanceOf(Query::class, $query);
        $query->documents();
    }

    public function testCollectionGroupInvalidId()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->collectionGroup('foo/bar');
    }

    public function testRunTransaction()
    {
        $transactionId = 'transactionId';
        $timestamp = new Timestamp(new \DateTimeImmutable);
        $expectedDatabase = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE;

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) use ($expectedDatabase){
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(BeginTransactionResponse::class, [
            'transaction' => $transactionId
        ]));

        $this->gapicClient->rollback(
            Argument::that(function (RollbackRequest $request) use ($expectedDatabase) {
                $this->assertEquals('transactionId', $request->getTransaction());
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled();

        $this->client->runTransaction($this->noop());
    }

    public function testRunTransactionRetryable()
    {
        $transactionId = 'transaction1';
        $transactionId2 = 'transaction2';
        $expectedDatabase = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE;

        $beginTransactionCount = 0;
        $this->gapicClient->beginTransaction(
            Argument::that(
                function (BeginTransactionRequest $request) use (
                    $expectedDatabase,
                    $transactionId,
                    &$beginTransactionCount
                ) {
                    $beginTransactionCount++;
                    if ($beginTransactionCount == 2) {
                        $this->assertEquals(
                            $transactionId,
                            $request->getOptions()->getReadWrite()->getRetryTransaction()
                        );
                    }
                    $this->assertEquals($expectedDatabase, $request->getDatabase());
                    return true;
                }
            ),
            Argument::any()
        )->shouldBeCalled()
            ->will(function () use ($transactionId, $transactionId2, &$beginTransactionCount) {
                if ($beginTransactionCount == 1) {
                    return new BeginTransactionResponse(['transaction' => $transactionId]);
                }

                if ($beginTransactionCount == 2) {
                    return new BeginTransactionResponse(['transaction' => $transactionId2]);
                }
            });

        $this->gapicClient->rollback(
            Argument::that(function (RollbackRequest $request) use ($expectedDatabase, $transactionId) {
                $this->assertEquals($transactionId, $request->getTransaction());
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1);

        $callCount = 0;

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) use (
                &$callCount,
                $expectedDatabase,
                $transactionId,
                $transactionId2
                ) {
                    $callCount++;
                    if ($callCount === 1) {
                        // Assertions for the first call
                        $this->assertEquals($expectedDatabase, $request->getDatabase());
                        $this->assertEquals($transactionId, $request->getTransaction());
                    } elseif ($callCount === 2) {
                        // Assertions for the second call
                        $this->assertEquals($expectedDatabase, $request->getDatabase());
                        $this->assertEquals($transactionId2, $request->getTransaction());
                    }

                    return true; // The arguments are valid for the current call number
                }
            ),
            Argument::any()
        )->shouldBeCalledTimes(2)
        ->will(function () use (&$callCount) {
            if ($callCount === 1) {
                // Action for the first call
                throw new AbortedException('');
            }

            // Action for the second call
            return new CommitResponse([
                'commit_time' => new ProtobufTimestamp()
            ]);
        });

        $res = $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name()->willReturn('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);

            return 'foo';
        });
        $this->assertEquals('foo', $res);
    }

    public function testRunTransactionNotRetryable()
    {
        $this->expectException(\RangeException::class);
        $this->expectExceptionMessage('foo');

        $transactionId = 'foobar';
        $expectedDatabase = 'projects/'. self::PROJECT .'/databases/'. self::DATABASE;

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) use ($expectedDatabase) {
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(new BeginTransactionResponse([
            'transaction' => $transactionId
        ]));

        $this->gapicClient->commit()->shouldNotBeCalled();

        $this->gapicClient->rollback(
            Argument::that(function (RollbackRequest $request) use ($expectedDatabase, $transactionId) {
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                $this->assertEquals($transactionId, $request->getTransaction());

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1);

        $this->client->runTransaction(function ($t) {
            throw new \RangeException('foo');
        });
    }

    public function testRunTransactionExceedsMaxRetries()
    {
        $this->expectException(AbortedException::class);

        $transactionId = 'foobar';

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(6)
            ->willReturn(new BeginTransactionResponse([
                'transaction' => $transactionId
            ]));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(6)
            ->willThrow(new AbortedException('foo'));

        $this->gapicClient->rollback(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(6);

        $res = $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name()->willReturn('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);
        });
    }

    public function testRunTransactionExceedsMaxRetriesLowerLimit()
    {
        $this->expectException(AbortedException::class);

        $transactionId = 'foobar';
        $timestamp = new Timestamp(new \DateTimeImmutable);

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(3)
            ->willReturn(new BeginTransactionResponse([
                'transaction' => $transactionId
            ]));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(3)
            ->willThrow(new AbortedException('foo'));

        $this->gapicClient->rollback(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(3);

        $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name()->willReturn('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);
        }, ['maxRetries' => 2]);
    }

    public function testGeoPoint()
    {
        $lat = 1.1;
        $lng = 2.2;
        $point = $this->client->geoPoint($lat, $lng);
        $this->assertInstanceOf(GeoPoint::class, $point);
        $this->assertEquals($lat, $point->latitude());
        $this->assertEquals($lng, $point->longitude());
    }

    public function testBlob()
    {
        $val = 'hello world';
        $blob = $this->client->blob($val);
        $this->assertInstanceOf(Blob::class, $blob);
        $this->assertEquals($val, (string)$blob);
    }

    public function testFieldPath()
    {
        $parts = ['foo', 'bar'];
        $path = $this->client->fieldPath($parts);
        $this->assertInstanceOf(FieldPath::class, $path);
        $this->assertEquals($parts, $path->path());
    }

    public function testSessionHandler()
    {
        $sessionHandler = $this->client->sessionHandler();
        $this->assertInstanceOf(FirestoreSessionHandler::class, $sessionHandler);
    }

    private function noop()
    {
        return function () {
            return;
        };
    }
}
