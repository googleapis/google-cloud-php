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

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\FirestoreTestHelperTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as V1FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\ListCollectionIdsRequest;
use Google\Cloud\Firestore\ValueMapper;
use Google\Protobuf\Timestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-documentreference
 */
class DocumentReferenceTest extends TestCase
{
    use FirestoreTestHelperTrait;
    use ProphecyTrait;

    public const PROJECT = 'example_project';
    public const DATABASE = '(default)';
    public const COLLECTION = 'projects/example_project/databases/(default)/documents/a';
    public const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $requestHandler;
    private $serializer;
    private $document;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = $this->getSerializer();

        $valueMapper = new ValueMapper(
            $this->requestHandler->reveal(),
            $this->serializer,
            false
        );
        $this->document = TestHelpers::stub(DocumentReference::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $valueMapper,
            new CollectionReference(
                $this->requestHandler->reveal(),
                $this->serializer,
                $valueMapper,
                self::COLLECTION
            ),
            self::NAME
        ], ['requestHandler']);
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
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                $expected = [
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
                ];

                return array_replace_recursive($data, $expected) == $data;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->document->create(['hello' => 'world']);
    }

    public function testSet()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                $expected = [
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
                ];

                return array_replace_recursive($data, $expected) == $data;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->document->set(['hello' => 'world']);
    }

    public function testUpdate()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                $expected = [
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
                ];
                return array_replace_recursive($data, $expected) == $data;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->document->update([
            ['path' => 'hello', 'value' => 'world'],
            ['path' => 'foo.bar', 'value' => 'val'],
            ['path' => new FieldPath(['foo', 'baz']), 'value' => 'val']
        ]);
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                $expected = [
                    'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                    'writes' => [
                        [
                            'delete' => self::NAME
                        ]
                    ]
                ];
                return array_replace_recursive($data, $expected) == $data;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->document->delete();
    }

    public function testSnapshot()
    {
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);

                return $data['database'] == sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE)
                    && $data['documents'] == [self::NAME];
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            [
                'found' => [
                    'name' => self::NAME,
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ]
            ]
        ]));

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'listCollectionIds',
            Argument::that(function ($req) {
                return $req->getParent() === self::NAME
                    && empty($req->getPageToken());
            }),
            Argument::cetera()
        )->shouldBeCalled()->will(function ($args, $mock) {
            $mock->sendRequest(
                V1FirestoreClient::class,
                'listCollectionIds',
                Argument::that(function ($req) {
                    return $req->getParent() === self::NAME
                        && $req->getPageToken() === 'token';
                }),
                Argument::cetera()
            )->shouldBeCalled()->willReturn([
                'collectionIds' => ['e']
            ]);

            return [
                'collectionIds' => ['c', 'd'],
                'nextPageToken' => 'token'
            ];
        });

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $collections = iterator_to_array($this->document->collections());
        $this->assertContainsOnlyInstancesOf(CollectionReference::class, $collections);
        $this->assertCount(3, $collections);
        $this->assertEquals(self::NAME .'/c', $collections[0]->name());
        $this->assertEquals(self::NAME .'/d', $collections[1]->name());
        $this->assertEquals(self::NAME .'/e', $collections[2]->name());
    }

    public function testWriteResult()
    {
        $time = [
            'seconds' => 100,
            'nanos' => 10
        ];

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::type(CommitRequest::class),
            Argument::cetera()
        )
            ->shouldBeCalled()
            ->willReturn([
                'writeResults' => [
                    [
                        'updateTime' => $time
                    ], [
                        'updateTime' => ['seconds' => 200] + $time
                    ]
                ],
                'commitTime' => $time
            ]);

        $this->document->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->document->set(['foo' => 'bar']);
        $this->assertIsArray($res['updateTime']);
        $this->assertEqualsWithDelta($time['seconds'], $res['updateTime']['seconds'], 100);
    }
}
