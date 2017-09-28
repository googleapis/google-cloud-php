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
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\SnapshotTrait;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * @group firestore
 * @group firestore-snapshottrait
 */
class SnapshotTraitTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $impl;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->impl = \Google\Cloud\Dev\impl(SnapshotTrait::class, ['connection', 'valueMapper']);

        $mapper = new ValueMapper($this->connection->reveal(), false);
        $this->impl->___setProperty('valueMapper', $mapper);
    }

    public function testCreateSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn([
            ['found' => [
                'name' => self::NAME,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ]]
        ]);

        $this->impl->___setProperty('connection', $this->connection->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $res = $this->impl->call('createSnapshot', [$ref->reveal()]);

        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals('world', $res['hello']);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertTrue($res->exists());
    }

    public function testCreateSnapshotNonExistence()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn([
            ['missing' => self::NAME]
        ]);

        $this->impl->___setProperty('connection', $this->connection->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $res = $this->impl->call('createSnapshot', [$ref->reveal()]);

        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertFalse($res->exists());
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testCreateSnapshotNonExistenceThrowsException()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn([
            ['missing' => self::NAME]
        ]);

        $this->impl->___setProperty('connection', $this->connection->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $res = $this->impl->call('createSnapshot', [$ref->reveal(), ['allowNonExistence' => false]]);
    }

    public function testCreateSnapshotProvidedData()
    {
        $this->connection->batchGetDocuments()->shouldNotBeCalled();
        $this->impl->___setProperty('connection', $this->connection->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);

        $res = $this->impl->call('createSnapshot', [$ref->reveal(), [
            'data' => [
                'name' => self::NAME,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ]
        ]]);

        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals('world', $res['hello']);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertTrue($res->exists());
    }

    public function testCreateSnapshotExistsSetToFalse()
    {
        $this->connection->batchGetDocuments()->shouldNotBeCalled();
        $this->impl->___setProperty('connection', $this->connection->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);

        $res = $this->impl->call('createSnapshot', [$ref->reveal(), ['exists' => false, 'data' => []]]);
        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertFalse($res->exists());
    }

    public function testGetSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn([
            ['found' => 'foo']
        ]);

        $this->impl->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals('foo', $this->impl->call('getSnapshot', [self::NAME]));
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testGetSnapshotNotFound()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn([
            ['missing' => self::NAME]
        ]);

        $this->impl->___setProperty('connection', $this->connection->reveal());

        $this->impl->call('getSnapshot', [self::NAME]);
    }

    public function testTransformSnapshotTimestampsEmpty()
    {
        $res = $this->impl->call('transformSnapshotTimestamps', [[]]);
        $this->assertEquals([
            'createTime' => null,
            'updateTime' => null,
            'readTime' => null
        ], $res);
    }

    public function testTransformSnapshotTimestamps()
    {
        $now = time();
        $ts = [
            'seconds' => $now,
            'nanos' => 100
        ];

        $input = [
            'createTime' => $ts,
            'updateTime' => $ts,
            'readTime' => $ts
        ];

        $res = $this->impl->call('transformSnapshotTimestamps', [$input]);

        $timestamp = new Timestamp(\DateTimeImmutable::createFromFormat('U', $now), $ts['nanos']);

        $expected = [
            'createTime' => $timestamp,
            'updateTime' => $timestamp,
            'readTime' => $timestamp
        ];

        $this->assertEquals($expected, $res);
    }
}
