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
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\Serializer;
use Google\Cloud\Firestore\SnapshotTrait;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
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
    use GenerateProtoTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $gapicClient;
    private $mapper;
    private TraitClass $traitClass;
    private $valueMapper;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->traitClass = new TraitClass();
        $this->valueMapper = new ValueMapper($this->gapicClient->reveal(), false);
    }

    public function testCreateSnapshot()
    {
        $response = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => self::NAME,
                'fields' => [
                    'hello' => [
                        'stringValue' => 'world'
                    ]
                ]
            ]
        ]);

        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()->willReturn(new ArrayIterator([$response]));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals([self::NAME], iterator_to_array($request->getDocuments()));

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($serverStream->reveal());

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);

        $response = $this->traitClass->createSnapshot(
            $this->gapicClient->reveal(),
            $this->valueMapper,
            $ref->reveal()
        );

        $this->assertInstanceOf(DocumentSnapshot::class, $response);
        $this->assertEquals('world', $response['hello']);
        $this->assertEquals(self::NAME, $response->name());
        $this->assertTrue($response->exists());
    }

    public function testCreateSnapshotNonExistence()
    {
        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, ['missing' => self::NAME]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals([self::NAME], iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock([$protoResponse]));

        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);

        $res = $this->traitClass->createSnapshot(
            $this->gapicClient->reveal(),
            $this->valueMapper,
            $ref->reveal()
        );

        $this->assertInstanceOf(DocumentSnapshot::class, $res);
        $this->assertEquals(self::NAME, $res->name());
        $this->assertFalse($res->exists());
    }

    public function testGetSnapshot()
    {
        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, ['found' => ['name' => 'foo']]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals([self::NAME], iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock([$protoResponse]));

        $response = $this->traitClass->getSnapshot(
            $this->gapicClient->reveal(),
            self::NAME
        );

        $this->assertEquals('foo', $response['name']);
    }

    public function testGetSnapshotReadTime()
    {
        $timestamp = [
            'seconds' => 100,
            'nanos' => 501
        ];

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, ['found' => ['name' => 'foo']]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) use ($timestamp) {
                $this->assertEquals($timestamp['seconds'], $request->getReadTime()->getSeconds());
                $this->assertEquals($timestamp['nanos'], $request->getReadTime()->getNanos());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $this->traitClass->getSnapshot(
            $this->gapicClient->reveal(),
            self::NAME,
            [
                'readTime' => new Timestamp(
                    \DateTimeImmutable::createFromFormat('U', (string) $timestamp['seconds']),
                    $timestamp['nanos']
                )
            ]
        );
    }

    public function testGetSnapshotReadTimeInvalidReadTime()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->traitClass->getSnapshot(
            $this->gapicClient->reveal(),
            self::NAME,
            ['readTime' => 'foo']
        );
    }

    public function testGetSnapshotNotFound()
    {
        $this->expectException(NotFoundException::class);

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, ['missing' => self::NAME]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->getDbName(), $request->getDatabase());
                $this->assertEquals([self::NAME], iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($this->getServerStreamMock([$protoResponse]));

        $this->traitClass->getSnapshot(
            $this->gapicClient->reveal(),
            self::NAME
        );
    }

    private function getDbName(): string
    {
        return sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
    }

    private function getServerStreamMock(array $response): ServerStream
    {
        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()->willReturn(new ArrayIterator($response));

        return $serverStream->reveal();
    }
}

class TraitClass
{
    use SnapshotTrait {
        createSnapshot as public;
        getSnapshot as public;
    }

    private Serializer $serializer;
    private OptionsValidator $optionsValidator;

    public function __construct()
    {
        $this->serializer = new Serializer();
        $this->optionsValidator = new OptionsValidator($this->serializer);
    }
}
