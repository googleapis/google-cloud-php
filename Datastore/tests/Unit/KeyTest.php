<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Datastore\Key;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group datastore
 */
class KeyTest extends TestCase
{
    use ExpectException;

    public function testWithInitialPath()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'Person']
            ]
        ]);

        $this->assertEquals($key->keyObject()['path'][0]['kind'], 'Person');
    }

    public function testKeyNamespaceId()
    {
        $key = new Key('foo', [
            'namespaceId' => 'MyApp'
        ]);

        $this->assertEquals($key->keyObject()['partitionId'], [
            'projectId' => 'foo',
            'namespaceId' => 'MyApp'
        ]);
    }

    public function testKeyDatabaseId()
    {
        $key = new Key('foo', [
            'databaseId' => 'MyDb',
        ]);

        $this->assertEquals($key->keyObject()['partitionId'], [
            'projectId' => 'foo',
            'databaseId' => 'MyDb'
        ]);
    }

    public function testPathElement()
    {
        $key = new Key('foo');

        $this->assertEmpty($key->keyObject()['path']);

        $key->pathElement('foo', 'bar');

        $this->assertCount(1, $key->keyObject()['path']);
        $this->assertEquals(['kind' => 'foo', 'name' => 'bar'], $key->keyObject()['path'][0]);
    }

    public function testInvalidPathElementAddition()
    {
        $this->expectException('InvalidArgumentException');

        $key = new Key('foo', [
            'path' => [
                ['kind' => 'thing']
            ]
        ]);

        $key->pathElement('foo', 'bar');
    }

    public function testAncestor()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'thing']
            ]
        ]);

        $key->ancestor('Hello', 'World');

        $this->assertEquals(['kind' => 'Hello', 'name' => 'World'], $key->keyObject()['path'][0]);
        $this->assertEquals(['kind' => 'thing'], $key->keyObject()['path'][1]);
    }

    public function testAncestorKey()
    {
        $ancestorPath = [
            ['kind' => 'Kind', 'id' => 'ID']
        ];

        $ancestor = $this->prophesize(Key::class);
        $ancestor->path()->willReturn($ancestorPath);
        $ancestor->state()->willReturn(Key::STATE_NAMED);

        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo']
            ]
        ]);

        $key->ancestorKey($ancestor->reveal());

        $path = $key->path();

        $expected = $ancestorPath;
        $expected[] = ['kind' => 'foo'];

        $this->assertEquals($path, $expected);
    }

    public function testAncestorKeyIncompletePath()
    {
        $this->expectException('InvalidArgumentException');

        $ancestor = $this->prophesize(Key::class);
        $ancestor->state()->willReturn(Key::STATE_INCOMPLETE);

        $key = new Key('foo');

        $key->ancestorKey($ancestor->reveal());
    }

    public function testPathElementForceType()
    {
        $key = new Key('foo');
        $key->pathElement('Robots', '1000', ['identifierType' => Key::TYPE_NAME]);
        $key->pathElement('Robots', '1000');

        $this->assertEquals(['kind' => 'Robots', 'name' => '1000'], $key->keyObject()['path'][0]);
        $this->assertEquals(['kind' => 'Robots', 'id' => '1000'], $key->keyObject()['path'][1]);
    }

    public function testPathElementInvalidIdentifierType()
    {
        $this->expectException('InvalidArgumentException');

        $key = new Key('foo');
        $key->pathElement('Robots', '1000', ['identifierType' => 'nothanks']);
    }

    public function testNormalizedPath()
    {
        $key = new Key('foo', [
            'path' => ['kind' => 'foo', 'id' => 1]
        ]);

        $this->assertEquals([['kind' => 'foo', 'id' => 1]], $key->path());
    }

    public function testMissingKind()
    {
        $this->expectException('InvalidArgumentException');

        $key = new Key('foo', [
            'path' => [
                ['id' => '1']
            ]
        ]);
    }

    public function testElementMissingIdentifier()
    {
        $this->expectException('InvalidArgumentException');

        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo'],
                ['kind' => 'foo', 'id' => 1]
            ]
        ]);
    }

    public function testJsonSerialize()
    {
        $key = new Key('foo');
        $key->pathElement('Robots', '1000', ['identifierType' => Key::TYPE_NAME]);

        $this->assertEquals($key->jsonSerialize(), $key->keyObject());
    }

    public function testStateNamed()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 1]
            ]
        ]);

        $this->assertEquals($key->state(), Key::STATE_NAMED);
    }

    public function testStateIncomplete()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo']
            ]
        ]);

        $this->assertEquals($key->state(), Key::STATE_INCOMPLETE);
    }

    public function testPath()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 1]
            ]
        ]);

        $this->assertEquals($key->path(), [
            ['kind' => 'foo', 'id' => 1]
        ]);
    }

    public function testPathEnd()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'foo', 'id' => 1]
            ]
        ]);

        $this->assertEquals($key->pathEnd(), ['kind' => 'foo', 'id' => 1]);
    }

    public function testSetLastElementIdentifier()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'foo']
            ]
        ]);

        $key->setLastElementIdentifier(1);

        $this->assertEquals($key->path(), [
            ['kind' => 'foo', 'id' => 2],
            ['kind' => 'foo', 'id' => 1]
        ]);
    }

    public function testSetLastElementIdentifierTypeName()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'foo']
            ]
        ]);

        $key->setLastElementIdentifier(1, Key::TYPE_NAME);

        $this->assertEquals($key->path(), [
            ['kind' => 'foo', 'id' => 2],
            ['kind' => 'foo', 'name' => 1]
        ]);
    }

    public function testPathEndIdentifier()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar', 'id' => 10]
            ]
        ]);

        $this->assertEquals(10, $key->pathEndIdentifier());
    }

    public function testPathEndIdentifierName()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar', 'name' => 10]
            ]
        ]);

        $this->assertEquals(10, $key->pathEndIdentifier());
    }

    public function testPathEndIdentifierNull()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar']
            ]
        ]);

        $this->assertNull($key->pathEndIdentifier());
    }

    public function testPathEndIdentifierType()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar', 'id' => 10]
            ]
        ]);

        $this->assertEquals(Key::TYPE_ID, $key->pathEndIdentifierType());
    }

    public function testPathEndIdentifierTypeName()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar', 'name' => 10]
            ]
        ]);

        $this->assertEquals(Key::TYPE_NAME, $key->pathEndIdentifierType());
    }

    public function testPathEndIdentifierTypeNull()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
                ['kind' => 'bar']
            ]
        ]);

        $this->assertNull($key->pathEndIdentifierType());
    }

    public function testToString()
    {
        $key = new Key('foo', [
            'path' => [
                ['kind' => 'foo', 'id' => 2],
            ]
        ]);

        $this->assertEquals('[ [foo: 2] ]', (string) $key);
    }
}
