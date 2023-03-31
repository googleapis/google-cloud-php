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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-documentsnapshot
 */
class DocumentSnapshotTest extends TestCase
{
    use ProphecyTrait;

    const NAME = 'projects/example_project/databases/(default)/documents/a/b';
    const ID = 'b';

    private $snapshot;

    public function setUp(): void
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $ref->id()->willReturn(self::ID);
        $ref->path()->willReturn('a/b');

        $this->snapshot = TestHelpers::stub(DocumentSnapshot::class, [
            $ref->reveal(),
            new ValueMapper($this->prophesize(ConnectionInterface::class)->reveal(), false),
            [], [], true
        ], ['info', 'data', 'exists']);
    }

    public function testReference()
    {
        $this->assertInstanceOf(DocumentReference::class, $this->snapshot->reference());
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->snapshot->name());
    }

    public function testPath()
    {
        $this->assertEquals('a/b', $this->snapshot->path());
    }

    public function testId()
    {
        $this->assertEquals(self::ID, $this->snapshot->id());
    }

    /**
     * @dataProvider timestampMethods
     */
    public function testTimestampMethods($method)
    {
        $ts = new Timestamp(new \DateTime);
        $info = [$method => $ts];
        $this->snapshot->___setProperty('info', $info);

        $res = $this->snapshot->$method();

        $this->assertEquals($ts, $res);

        $this->snapshot->___setProperty('info', []);
        $res = $this->snapshot->$method();

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

        $this->snapshot->___setProperty('data', $data);
        $this->assertEquals($data, $this->snapshot->data());
    }

    public function testDataDocumentDoesntExist()
    {
        $data = ['foo' => 'bar'];

        $this->snapshot->___setProperty('data', $data);
        $this->snapshot->___setProperty('exists', false);

        $this->assertNull($this->snapshot->data());
    }

    public function testExists()
    {
        $this->assertTrue($this->snapshot->exists());
        $this->snapshot->___setProperty('exists', false);
        $this->assertFalse($this->snapshot->exists());
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

        $this->snapshot->___setProperty('data', $fields);

        $this->assertEquals('bar', $this->snapshot->get('foo'));
        $this->assertEquals('c', $this->snapshot->get('a.b'));
        $this->assertEquals('f', $this->snapshot->get('a.d.e'));
        $this->assertNull($this->snapshot->get('null'));
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

        $this->snapshot->___setProperty('data', $fields);

        $this->assertEquals('bar', $this->snapshot->get(new FieldPath(['foo'])));
        $this->assertEquals('c', $this->snapshot->get(new FieldPath(['a', 'b'])));
        $this->assertEquals('f', $this->snapshot->get(new FieldPath(['a', 'd', 'e'])));
        $this->assertNull($this->snapshot->get(new FieldPath(['null'])));
    }

    public function testGetInvalid()
    {
        $this->expectException('InvalidArgumentException');

        $this->snapshot->get('foo');
    }

    public function testGetInvalidArgumentType()
    {
        $this->expectException('InvalidArgumentException');

        $this->snapshot->get(1234);
    }

    public function testArrayAccessRead()
    {
        $this->snapshot->___setProperty('data', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->snapshot['foo']);
        $this->assertArrayHasKey('foo', $this->snapshot);
        $this->assertArrayNotHasKey('baz', $this->snapshot);
    }

    public function testArrayAccessSetDisabled()
    {
        $this->expectException('BadMethodCallException');

        $this->snapshot['name'] = 'bob';
    }

    public function testArrayAccessUnsetDisabled()
    {
        $this->expectException('BadMethodCallException');

        unset($this->snapshot['name']);
    }

    public function testArrayAccessNonExistentIndex()
    {
        $this->expectError();

        $this->snapshot['name'];
    }
}
