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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\SnapshotTrait;
use Google\Cloud\Firestore\ValueMapper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-snapshottrait
 */
class SnapshotTraitTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $mapper;
    private $impl;
    private $valueMapper;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->impl = TestHelpers::impl(SnapshotTrait::class);

        $this->valueMapper = new ValueMapper($this->connection->reveal(), false);
    }

    public function testCreateSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
            ['found' => [
                'name' => self::NAME,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ]]
        ]));

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $res = $this->impl->call('createSnapshot', [
            $this->connection->reveal(),
            $this->valueMapper,
            $ref->reveal()
        ]);

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
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
            ['missing' => self::NAME]
        ]));

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $res = $this->impl->call('createSnapshot', [
            $this->connection->reveal(),
            $this->valueMapper,
            $ref->reveal()
        ]);

        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertFalse($res->exists());
    }

    public function testGetSnapshot()
    {
        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
            ['found' => 'foo']
        ]));

        $this->assertEquals('foo', $this->impl->call('getSnapshot', [
            $this->connection->reveal(),
            self::NAME
        ]));
    }

    public function testGetSnapshotReadTime()
    {
        $timestamp = [
            'seconds' => 100,
            'nanos' => 501
        ];

        $this->connection->batchGetDocuments(Argument::withEntry('readTime', $timestamp))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                ['found' => 'foo']
            ]));

        $this->impl->call('getSnapshot', [
            $this->connection->reveal(),
            self::NAME,
            [
                'readTime' => new Timestamp(
                    \DateTimeImmutable::createFromFormat('U', (string) $timestamp['seconds']),
                    $timestamp['nanos']
                )
            ]
        ]);
    }

    public function testGetSnapshotReadTimeInvalidReadTime()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->impl->call('getSnapshot', [
            $this->connection->reveal(),
            self::NAME,
            ['readTime' => 'foo']
        ]);
    }

    public function testGetSnapshotNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->connection->batchGetDocuments([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => [self::NAME]
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([
            ['missing' => self::NAME]
        ]));

        $this->impl->call('getSnapshot', [
            $this->connection->reveal(),
            self::NAME
        ]);
    }
}
