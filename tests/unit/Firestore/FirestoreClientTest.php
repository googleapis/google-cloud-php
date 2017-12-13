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

use Google\Cloud\Core\Blob;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Tests\GrpcTestTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-client
 */
class FirestoreClientTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(FirestoreClient::class);
    }

    public function testBatch()
    {
        $this->assertInstanceOf(WriteBatch::class, $this->client->batch());
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

        $this->connection->listCollectionIds(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'collectionIds' => $collectionIds
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $collections = $this->client->collections([
            'foo' => 'bar'
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

        $this->connection->listCollectionIds(Argument::that(function ($options) {
            if ($options['foo'] !== 'bar') return false;
            if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                return false;
            }

            return true;
        }))->willReturn([
            'collectionIds' => $collectionIds,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $collections = $this->client->collections([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($collections as $collection) {
            $i++;
            $arr[] = $collection;
            if ($i == 6) break;
        }

        $this->assertCount(6, $arr);
    }

    public function testDocument()
    {
        $document = $this->client->document('a/b');

        $this->assertInstanceOf(DocumentReference::class, $document);
        $this->assertEquals('b', $document->id());
    }

    /**
     * @dataProvider paths
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPath($method, $name)
    {
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
        $name = function ($name) {
            return sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, $name);
        };

        $res = [
            [
                'found' => [
                    'name' => $names[0],
                    'fields' => [
                        'hello' => [
                            'stringValue' => 'world'
                        ]
                    ]
                ],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[1],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[2],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ]
        ];

        $this->connection->batchGetDocuments(Argument::withEntry('documents', $names))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->documents($input);

        $this->assertEquals('world', $res[0]['hello']);
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

        $res = [
            [
                'missing' => $names[2],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[1],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ], [
                'missing' => $names[0],
                'readTime' => ['seconds' => 1, 'nanos' => 0]
            ]
        ];

        $this->connection->batchGetDocuments(Argument::withEntry('documents', $names))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->documents($names);
        $this->assertEquals($names[0], $res[0]->name());
        $this->assertEquals($names[1], $res[1]->name());
        $this->assertEquals($names[2], $res[2]->name());
    }

    public function testRunTransaction()
    {
        $transactionId = 'foobar';
        $timestamp = ['seconds' => date('U')];

        $this->connection->beginTransaction([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE
        ])->shouldBeCalled()->willReturn([
            'transaction' => $transactionId
        ]);

        $this->connection->rollback([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE,
            'transaction' => $transactionId
        ])->shouldBeCalled();

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->runTransaction(function ($t) {});
    }

    public function testRunTransactionRetryable()
    {
        $transactionId = 'foobar';
        $transactionId2 = 'barfoo';
        $timestamp = ['seconds' => date('U')];

        $this->connection->beginTransaction([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE
        ])->shouldBeCalled()->will(function($args, $mock) use ($transactionId, $transactionId2) {
            $mock->beginTransaction(Argument::withEntry('retryTransaction', $transactionId))->willReturn([
                'transaction' => $transactionId2
            ]);

            return [
                'transaction' => $transactionId
            ];
        });

        $this->connection->commit(Argument::that(function ($args) use ($transactionId) {
            if ($args['database'] !== 'projects/'. self::PROJECT .'/databases/'. self::DATABASE) return false;
            if ($args['transaction'] !== $transactionId) return false;

            return true;
        }))
            ->shouldBeCalled()
            ->will(function ($args, $mock) use ($timestamp, $transactionId2) {
                $mock->commit(Argument::that(function ($args) use ($transactionId2) {
                    if ($args['database'] !== 'projects/'. self::PROJECT .'/databases/'. self::DATABASE) return false;
                    if ($args['transaction'] !== $transactionId2) return false;

                    return true;
                }))->willReturn([
                    'commitTime' => $timestamp,
                ]);

            throw new AbortedException('');
        });

        $this->connection->rollback([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE,
            'transaction' => $transactionId
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);

            return 'foo';
        });
        $this->assertEquals('foo', $res);
    }

    /**
     * @expectedException RangeException
     * @expectedExceptionMessage foo
     */
    public function testRunTransactionNotRetryable()
    {
        $transactionId = 'foobar';
        $timestamp = ['seconds' => date('U')];

        $this->connection->beginTransaction([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE
        ])->shouldBeCalled()->willReturn([
            'transaction' => $transactionId
        ]);

        $this->connection->commit()->shouldNotBeCalled();

        $this->connection->rollback([
            'database' => 'projects/'. self::PROJECT .'/databases/'. self::DATABASE,
            'transaction' => $transactionId
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->runTransaction(function ($t) { throw new \RangeException('foo'); });
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\AbortedException
     */
    public function testRunTransactionExceedsMaxRetries()
    {
        $transactionId = 'foobar';
        $timestamp = ['seconds' => date('U')];

        $this->connection->beginTransaction(Argument::any())->shouldBeCalledTimes(6)->willReturn([
            'transaction' => $transactionId
        ]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalledTimes(6)
            ->willThrow(new AbortedException('foo'));

        $this->connection->rollback(Argument::any())->shouldBeCalledTimes(6);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);
        });
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\AbortedException
     */
    public function testRunTransactionExceedsMaxRetriesLowerLimit()
    {
        $transactionId = 'foobar';
        $timestamp = ['seconds' => date('U')];

        $this->connection->beginTransaction(Argument::any())->shouldBeCalledTimes(3)->willReturn([
            'transaction' => $transactionId
        ]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalledTimes(3)
            ->willThrow(new AbortedException('foo'));

        $this->connection->rollback(Argument::any())->shouldBeCalledTimes(3);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->runTransaction(function ($t) {
            $doc = $this->prophesize(DocumentReference::class);
            $doc->name('foo');
            $t->create($doc->reveal(), ['foo'=>'bar']);
        }, ['maxRetries' => 2]);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testInvalidNestedTransaction()
    {
        $transactionId = 'foobar';
        $this->connection->beginTransaction(Argument::any())->willReturn([
            'transaction' => $transactionId
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->runTransaction(function ($t) {
            $this->client->runTransaction(function (){});
        });
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
}
