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

use Exception;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use InvalidArgumentException;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @group firestore
 * @group firestore-documentsnapshot
 */
class DocumentSnapshotTest extends TestCase
{
    use ProphecyTrait;

    const NAME = 'projects/example_project/databases/(default)/documents/a/b';
    const ID = 'b';
    const PATH = 'a/b';

    private $ref;
    private $valueMapper;

    public function setUp(): void
    {
        $this->ref = $this->prophesize(DocumentReference::class);
        $this->valueMapper = new ValueMapper(
            $this->prophesize(FirestoreClient::class)->reveal(),
            false
        );
    }

    public function testReference()
    {
        $snapshot = $this->getSnapshot();
        $this->assertEquals($this->ref->reveal(), $snapshot->reference());
    }

    public function testName()
    {
        $this->ref->name()->willReturn(self::NAME);
        $snapshot = $this->getSnapshot();
        $this->assertEquals(self::NAME, $snapshot->name());
    }

    public function testPath()
    {
        $this->ref->path()->willReturn(self::PATH);
        $snapshot = $this->getSnapshot();
        $this->assertEquals(self::PATH, $snapshot->path());
    }

    public function testId()
    {
        $this->ref->id()->willReturn(self::ID);
        $snapshot = $this->getSnapshot();
        $this->assertEquals(self::ID, $snapshot->id());
    }

    /**
     * @dataProvider timestampMethods
     */
    public function testTimestampMethods($method)
    {
        $ts = new Timestamp(new \DateTime);
        $info = [$method => $ts];
        $snapshot = $this->getSnapshot($info);

        $res = $snapshot->$method();
        $this->assertEquals($ts, $res);

        $snapshot = $this->getSnapshot();
        $res = $snapshot->$method();
        $this->assertNull($res);
    }

    public function timestampMethods()
    {
        return [
            ['readTime'],
            ['updateTime'],
            ['createTime']
        ];
    }

    public function testData()
    {
        $data = ['foo' => 'bar'];
        $snapshot = $this->getSnapshot([], $data);
        $this->assertEquals($data, $snapshot->data());
    }

    public function testDataDocumentDoesntExist()
    {
        $data = ['foo' => 'bar'];
        $snapshot = $this->getSnapshot([], $data, false);
        $this->assertNull($snapshot->data());
    }

    public function testExists()
    {
        $snapshot = $this->getSnapshot();
        $this->assertTrue($snapshot->exists());

        $snapshot = $this->getSnapshot([], [], false);
        $this->assertFalse($snapshot->exists());
    }

    public function testGet()
    {
        $fields = [
            'foo' => 'bar',
            'a' => [
                'b' => 'c',
                'd' => [
                    'e' => 'f'
                ]
            ],
            'null' => null,
        ];

        $snapshot = $this->getSnapshot([], $fields);

        $this->assertEquals('bar', $snapshot->get('foo'));
        $this->assertEquals('c', $snapshot->get('a.b'));
        $this->assertEquals('f', $snapshot->get('a.d.e'));
        $this->assertNull($snapshot->get('null'));
    }

    public function testGetWithFieldPath()
    {
        $fields = [
            'foo' => 'bar',
            'a' => [
                'b' => 'c',
                'd' => [
                    'e' => 'f'
                ]
            ],
            'null' => null,
        ];

        $snapshot = $this->getSnapshot([], $fields);

        $this->assertEquals('bar', $snapshot->get(new FieldPath(['foo'])));
        $this->assertEquals('c', $snapshot->get(new FieldPath(['a', 'b'])));
        $this->assertEquals('f', $snapshot->get(new FieldPath(['a', 'd', 'e'])));
        $this->assertNull($snapshot->get(new FieldPath(['null'])));
    }

    public function testGetInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->getSnapshot()->get('foo');
    }

    public function testGetInvalidArgumentType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->getSnapshot()->get(1234);
    }

    public function testArrayAccessRead()
    {
        $snapshot = $this->getSnapshot([], ['foo' => 'bar']);
        $this->assertEquals('bar', $snapshot['foo']);
        $this->assertArrayHasKey('foo', $snapshot);
        $this->assertArrayNotHasKey('baz', $snapshot);
    }

    public function testArrayAccessSetDisabled()
    {
        $this->expectException(\BadMethodCallException::class);

        $snapshot = $this->getSnapshot();
        $snapshot['name'] = 'bob';
    }

    public function testArrayAccessUnsetDisabled()
    {
        $this->expectException(\BadMethodCallException::class);

        $snapshot = $this->getSnapshot();
        unset($snapshot['name']);
    }

    public function testArrayAccessNonExistentIndex()
    {
        set_error_handler(static function (int $errno, string $errstr): never {
            throw new Exception($errstr, $errno);
        }, E_USER_NOTICE);
        $this->expectException(Exception::class);

        try {
            $snapshot = $this->getSnapshot();
            $snapshot['name'];
        } finally {
            restore_error_handler();
        }
    }

    private function getSnapshot(array $info = [], array $data = [], bool $exists = true)
    {
        return new DocumentSnapshot(
            $this->ref->reveal(),
            $this->valueMapper,
            $info,
            $data,
            $exists
        );
    }
}
