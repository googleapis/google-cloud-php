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

namespace Google\Cloud\Tests\Snippets\Datastore;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group datastore
 */
class KeyTest extends SnippetTestCase
{
    private $key;

    public function setUp()
    {
        $this->key = new Key('my-awesome-project');
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Key::class);

        $res = $snippet->invoke('key');
        $this->assertInstanceOf(Key::class, $res->returnVal());
    }

    public function testClassComplexPath()
    {
        $snippet = $this->snippetFromClass(Key::class, 1);

        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0], 'name' => $args[1]]
                    ]
                ]);
            });

        $snippet->addLocal('datastore', $ds->reveal());

        $res = $snippet->invoke('key');
        $this->assertEquals(3, count($res->returnVal()->path()));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testClassErrorOnAppend()
    {
        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0], 'name' => $args[1]]
                    ]
                ]);
            });

        $snippet = $this->snippetFromClass(Key::class, 2);
        $snippet->addLocal('datastore', $ds->reveal());

        $res = $snippet->invoke();
    }

    public function testPathElement()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'pathElement');
        $snippet->addLocal('key', $this->key);

        $res = $snippet->invoke();

        $this->assertEquals(['kind' => 'Person', 'name' => 'Jane'], $this->key->path()[0]);
    }

    public function testPathElementChooseType()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'pathElement', 1);
        $snippet->addLocal('key', $this->key);
        $snippet->addUse(Key::class);

        $res = $snippet->invoke();

        $this->assertEquals(['kind' => 'Robots', 'name' => '1337'], $this->key->path()[0]);
    }

    public function testAncestor()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'ancestor');
        $snippet->addLocal('key', $this->key);

        $res = $snippet->invoke();

        $this->assertEquals(['kind' => 'Person', 'name' => 'Jane'], $this->key->path()[0]);
    }

    public function testAncestorChooseType()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'ancestor', 1);
        $snippet->addLocal('key', $this->key);
        $snippet->addUse(Key::class);

        $res = $snippet->invoke();

        $this->assertEquals(['kind' => 'Robots', 'name' => '1337'], $this->key->path()[0]);
    }

    public function testAncestorKey()
    {
        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0], 'name' => $args[1]]
                    ]
                ]);
            });

        $snippet = $this->snippetFromMethod(Key::class, 'ancestorKey');
        $snippet->addLocal('key', $this->key);
        $snippet->addLocal('datastore', $ds->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Dad', $this->key->path()[0]['name']);
    }


    public function testStateIncomplete()
    {
        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0], 'id' => $args[1]]
                    ]
                ]);
            });

        $snippet = $this->snippetFromMethod(Key::class, 'state');
        $snippet->addLocal('datastore', $ds->reveal());
        $snippet->addUse(Key::class);

        $res = $snippet->invoke();
        $this->assertEquals('Key is incomplete!', $res->output());
    }

    public function testStateNamed()
    {
        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0], 'id' => $args[1]]
                    ]
                ]);
            });

        $snippet = $this->snippetFromMethod(Key::class, 'state', 1);
        $snippet->addLocal('datastore', $ds->reveal());
        $snippet->addUse(Key::class);

        $res = $snippet->invoke();
        $this->assertEquals('Key is named!', $res->output());
    }

    public function testSetLastElementIdentifier()
    {
        $ds = $this->prophesize(DatastoreClient::class);
        $ds->key(Argument::any(), Argument::any())
            ->will(function($args) {
                return new Key('my-awesome-project', [
                    'path' => [
                        ['kind' => $args[0]]
                    ]
                ]);
            });

        $snippet = $this->snippetFromMethod(Key::class, 'setLastElementIdentifier');
        $snippet->addLocal('datastore', $ds->reveal());
        $snippet->addUse(Key::class);

        $res = $snippet->invoke('key');
        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()->state());
    }

    public function testPath()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'path');
        $snippet->addLocal('key', $this->key);

        $this->key->pathElement('Foo', 'Bar');

        $res = $snippet->invoke('path');
        $this->assertEquals([['kind' => 'Foo', 'name' => 'Bar']], $res->returnVal());
    }

    public function testPathEnd()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'pathEnd');
        $snippet->addLocal('key', $this->key);

        $this->key->pathElement('Foo', 'Bar');
        $this->key->pathElement('Foo', 'Baz');

        $res = $snippet->invoke('lastPathElement');
        $this->assertEquals(['kind' => 'Foo', 'name' => 'Baz'], $res->returnVal());
    }

    public function testPathEndIdentifier()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'pathEndIdentifier');
        $snippet->addLocal('key', $this->key);

        $this->key->pathElement('Foo', 'Bar');
        $this->key->pathElement('Foo', 'Baz');

        $res = $snippet->invoke('lastPathElementIndentifier');
        $this->assertEquals('Baz', $res->returnVal());
    }

    public function testPathEndIdentifierType()
    {
        $snippet = $this->snippetFromMethod(Key::class, 'pathEndIdentifierType');
        $snippet->addLocal('key', $this->key);

        $this->key->pathElement('Foo', 'Bar');
        $this->key->pathElement('Foo', 'Baz');

        $res = $snippet->invoke('lastPathElementIdentifierType');
        $this->assertEquals(Key::TYPE_NAME, $res->returnVal());
    }
}
