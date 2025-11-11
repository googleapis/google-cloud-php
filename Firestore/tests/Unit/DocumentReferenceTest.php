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
use DateTime;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\ListCollectionIdsRequest;
use Google\Cloud\Firestore\V1\ListCollectionIdsResponse;
use Google\Cloud\Firestore\V1\Value;
use Google\Cloud\Firestore\ValueMapper;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

use function PHPSTORM_META\map;

/**
 * @group firestore
 * @group firestore-documentreference
 */
class DocumentReferenceTest extends TestCase
{
    use GenerateProtoTrait;
    use ProphecyTrait;
    use TimeTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const COLLECTION = 'projects/example_project/databases/(default)/documents/a';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $gapicClient;
    private $document;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);

        $valueMapper = new ValueMapper($this->gapicClient->reveal(), false);
        $this->document = new DocumentReference(
            $this->gapicClient->reveal(),
            $valueMapper,
            new CollectionReference($this->gapicClient->reveal(), $valueMapper, self::COLLECTION),
            self::NAME
        );
    }

    public function testParent()
    {
        $this->assertInstanceOf(CollectionReference::class, $this->document->parent());
        $this->assertEquals(self::COLLECTION, $this->document->parent()->name());
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->document->name());
    }

    public function testPath()
    {
        $this->assertEquals('a/b', $this->document->path());
    }

    public function testId()
    {
        $this->assertEquals(array_reverse(explode('/', self::NAME))[0], $this->document->id());
    }

    public function testCreate()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                    'writes' => [
                        [
                            'currentDocument' => ['exists' => false],
                            'update' => [
                                'name' => self::NAME,
                                'fields' => [
                                    'hello' => [
                                        'stringValue' => 'world'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'writeResults' => [[]]
        ]));

        $this->document->create(['hello' => 'world']);
    }

    public function testSet()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                    'writes' => [
                        [
                            'update' => [
                                'name' => self::NAME,
                                'fields' => [
                                    'hello' => [
                                        'stringValue' => 'world'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'writeResults' => [[]]
        ]));

        $this->document->set(['hello' => 'world']);
    }

    public function testUpdate()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                    'writes' => [
                        [
                            'updateMask' => [
                                'fieldPaths' => [
                                    "foo.bar",
                                    "foo.baz",
                                    "hello",
                                ]
                            ],
                            'currentDocument' => ['exists' => true],
                            'update' => [
                                'name' => self::NAME,
                                'fields' => [
                                    'hello' => [
                                        'stringValue' => 'world'
                                    ],
                                    'foo' => [
                                        'mapValue' => [
                                            'fields' => [
                                                'bar' => [
                                                    'stringValue' => 'val'
                                                ],
                                                'baz' => [
                                                    'stringValue' => 'val'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, [
            'writeResults' => [[]]
        ]));

        $this->document->update([
            ['path' => 'hello', 'value' => 'world'],
            ['path' => 'foo.bar', 'value' => 'val'],
            ['path' => new FieldPath(['foo', 'baz']), 'value' => 'val']
        ]);
    }

    public function testDelete()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                    'writes' => [
                        [
                            'delete' => self::NAME
                        ]
                    ]
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'writeResults' => [[]]
        ]));

        $this->document->delete();
    }

    public function testSnapshot()
    {
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn(new ArrayIterator([
            new BatchGetDocumentsResponse([
                'found' => new Document([
                    'name' => self::NAME,
                    'fields' => [
                        'hello' => new Value([
                            'string_value' => 'world'
                        ])
                    ]
                ])
            ])
        ]));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $expectedDatabase = sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
                $this->assertEquals($expectedDatabase, $request->getDatabase());
                $this->assertEquals([self::NAME], iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($stream->reveal());

        $snapshot = $this->document->snapshot();
        $this->assertInstanceOf(DocumentSnapshot::class, $snapshot);
        $this->assertEquals($this->document, $snapshot->reference());
        $this->assertEquals(self::NAME, $snapshot->name());
    }

    public function testCollection()
    {
        $collection = $this->document->collection('c');

        $this->assertInstanceOf(CollectionReference::class, $collection);
        $this->assertEquals(self::NAME .'/c', $collection->name());
    }

    public function testCollections()
    {
        $currentPage = 0;

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->shouldBeCalled(1)
            ->willReturn(self::generateProto(ListCollectionIdsResponse::class, [
                'collectionIds' => ['c', 'd'],
                'nextPageToken' => 'token'
            ]));

        $page2 = $this->prophesize(Page::class);
        $page2->getResponseObject()
            ->shouldBeCalled(1)
            ->willReturn(self::generateProto(ListCollectionIdsResponse::class, [
                'collectionIds' => ['e'],
            ]));


        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->shouldBeCalled()
            ->will(function () use (&$currentPage, $page, $page2) {
                $currentPage++;

                if ($currentPage == 1) {
                    return $page->reveal();
                }

                return $page2->reveal();
            });

        $this->gapicClient->listCollectionIds(
            Argument::that(function (ListCollectionIdsRequest $request) {
                $this->assertEquals(self::NAME, $request->getParent());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($pagedListResponse->reveal());

        $collections = iterator_to_array($this->document->collections());
        $this->assertContainsOnlyInstancesOf(CollectionReference::class, $collections);
        $this->assertCount(3, $collections);
        $this->assertEquals(self::NAME .'/c', $collections[0]->name());
        $this->assertEquals(self::NAME .'/d', $collections[1]->name());
        $this->assertEquals(self::NAME .'/e', $collections[2]->name());
    }

    public function testWriteResult()
    {
        $time = time();
        $ts = new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $time));
        $ts2 = new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $time + 100));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'writeResults' => [
                    [
                        'updateTime' => new ProtobufTimestamp($ts->formatForApi())
                    ], [
                        'updateTime' => new ProtobufTimestamp($ts2->formatForApi())
                    ]
                ],
                'commitTime' => new ProtobufTimestamp($ts->formatForApi())
            ]));

        $res = $this->document->set(['foo' => 'bar']);
        $this->assertInstanceOf(Timestamp::class, $res['updateTime']);
        $this->assertEqualsWithDelta($time + 100, $res['updateTime']->get()->format('U'), 3);
    }
}
