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

namespace Google\Cloud\Tests\Unit\Firestore;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-documentreference
 */
class DocumentReferenceTest extends TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const COLLECTION = 'projects/example_project/databases/(default)/documents/a';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $document;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $valueMapper = new ValueMapper($this->connection->reveal(), false);
        $this->document = \Google\Cloud\Dev\stub(DocumentReference::class, [
            $this->connection->reveal(),
            $valueMapper,
            new CollectionReference($this->connection->reveal(), $valueMapper, self::COLLECTION),
            self::NAME
        ]);
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
        $this->connection->commit([
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
        ])->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('connection', $this->connection->reveal());

        $this->document->create(['hello' => 'world']);
    }

    public function testSet()
    {
        $this->connection->commit([
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
        ])->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('connection', $this->connection->reveal());

        $this->document->set(['hello' => 'world']);
    }

    public function testUpdate()
    {
        $this->connection->commit([
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
        ])->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('connection', $this->connection->reveal());

        $this->document->update([
            ['path' => 'hello', 'value' => 'world'],
            ['path' => 'foo.bar', 'value' => 'val'],
            ['path' => new FieldPath(['foo', 'baz']), 'value' => 'val']
        ]);
    }

    public function testDelete()
    {
        $this->connection->commit([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => self::NAME
                ]
            ]
        ])->shouldBeCalled()->willReturn([[]]);

        $this->document->___setProperty('connection', $this->connection->reveal());

        $this->document->delete();
    }

    public function testSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
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

        $this->document->___setProperty('connection', $this->connection->reveal());

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
        $this->connection->listCollectionIds([
            'parent' => self::NAME
        ])->shouldBeCalled()->will(function ($args, $mock) {
            $mock->listCollectionIds([
                'parent' => self::NAME,
                'pageToken' => 'token'
            ])->shouldBeCalled()->willReturn([
                'collectionIds' => ['e']
            ]);

            return [
                'collectionIds' => ['c', 'd'],
                'nextPageToken' => 'token'
            ];
        });

        $this->document->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'writeResults' => [
                    [
                        'updateTime' => [
                            'seconds' => $time
                        ]
                    ], [
                        'updateTime' => [
                            'seconds' => $time + 100
                        ]
                    ]
                ],
                'commitTime' => ['seconds' => $time]
            ]);

        $this->document->___setProperty('connection', $this->connection->reveal());

        $res = $this->document->set(['foo' => 'bar']);
        $this->assertInstanceOf(Timestamp::class, $res['updateTime']);
        $this->assertEquals($time + 100, $res['updateTime']->get()->format('U'), '', 3);
    }
}
