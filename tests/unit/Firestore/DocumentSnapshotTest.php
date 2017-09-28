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

use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\DocumentReference;

/**
 * @group firestore
 * @group firestore-documentsnapshot
 */
class DocumentSnapshotTest extends \PHPUnit_Framework_TestCase
{
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';
    const ID = 'b';

    private $snapshot;

    public function setUp()
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::NAME);
        $ref->id()->willReturn(self::ID);

        $this->snapshot = \Google\Cloud\Dev\stub(DocumentSnapshot::class, [
            $ref->reveal(),
            [], [], true
        ], ['info', 'fields', 'exists']);
    }

    public function testReference()
    {
        $this->assertInstanceOf(DocumentReference::class, $this->snapshot->reference());
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->snapshot->name());
    }

    public function testId()
    {
        $this->assertEquals(self::ID, $this->snapshot->id());
    }

    public function testInfo()
    {
        $i = ['foo' => 'bar'];

        $this->snapshot->___setProperty('info', $i);
        $this->assertEquals($i, $this->snapshot->info());
    }

    public function testFields()
    {
        $fields = ['foo' => 'bar'];

        $this->snapshot->___setProperty('fields', $fields);
        $this->assertEquals($fields, $this->snapshot->fields());
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
            ]
        ];

        $this->snapshot->___setProperty('fields', $fields);

        $this->assertEquals('bar', $this->snapshot->get('foo'));
        $this->assertEquals('c', $this->snapshot->get('a.b'));
        $this->assertEquals('f', $this->snapshot->get('a.d.e'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetInvalid()
    {
        $this->snapshot->get('foo');
    }

    public function testArrayAccessRead()
    {
        $this->snapshot->___setProperty('fields', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->snapshot['foo']);
        $this->assertTrue(isset($this->snapshot['foo']));
        $this->assertFalse(isset($this->snapshot['baz']));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testArrayAccessSetDisabled()
    {
        $this->snapshot['name'] = 'bob';
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testArrayAccessUnsetDisabled()
    {
        unset($this->snapshot['name']);
    }
}
