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

namespace Google\Cloud\Tests\Datastore;

use Google\Cloud\Datastore\Key;

/**
 * @group datastore
 */
class KeyTest extends \PHPUnit_Framework_TestCase
{
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

    public function testPathElement()
    {
        $key = new Key('foo');

        $this->assertEmpty($key->keyObject()['path']);

        $key->pathElement('foo', 'bar');

        $this->assertEquals(1, count($key->keyObject()['path']));
        $this->assertEquals(['kind' => 'foo', 'name' => 'bar'], $key->keyObject()['path'][0]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPathElementAddition()
    {
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

    public function testPathElementForceType()
    {
        $key = new Key('foo');
        $key->pathElement('Robots', '1000', Key::TYPE_NAME);
        $key->pathElement('Robots', '1000');

        $this->assertEquals(['kind' => 'Robots', 'name' => '1000'], $key->keyObject()['path'][0]);
        $this->assertEquals(['kind' => 'Robots', 'id' => '1000'], $key->keyObject()['path'][1]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPathElementInvalidIdentifierType()
    {
        $key = new Key('foo');
        $key->pathElement('Robots', '1000', 'nothanks');
    }

    public function testNormalizedPath()
    {
        $key = new Key('foo', [
            'path' => ['kind' => 'foo', 'id' => 1]
        ]);

        $this->assertEquals([['kind' => 'foo', 'id' => 1]], $key->path());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMissingKind()
    {
        $key = new Key('foo', [
            'path' => [
                ['id' => '1']
            ]
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testElementMissingIdentifier()
    {
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
        $key->pathElement('Robots', '1000', Key::TYPE_NAME);

        $this->assertEquals($key->jsonSerialize(), $key->keyObject());
    }
}
