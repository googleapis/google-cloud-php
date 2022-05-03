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

use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * @group firestore
 * @group firestore-collectionreference
 */
class CollectionReferenceTest extends TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const COLLECTION_PARENT = 'projects/example_project/databases/(default)/documents/a/doc';
    const NAME = 'projects/example_project/databases/(default)/documents/a/doc/b';

    private $connection;
    private $collection;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->collection = TestHelpers::stub(CollectionReference::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::NAME
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->collection->name());
    }

    public function testPath()
    {
        $this->assertEquals('a/doc/b', $this->collection->path());
    }

    public function testId()
    {
        $this->assertEquals(array_reverse(explode('/', self::NAME))[0], $this->collection->id());
    }

    public function testDocument()
    {
        $id = 'foo';

        $doc = $this->collection->document($id);
        $this->assertInstanceOf(DocumentReference::class, $doc);
        $this->assertEquals(self::NAME .'/'. $id, $doc->name());
    }

    public function testNewDocument()
    {
        $doc = $this->collection->newDocument();
        $this->assertInstanceOf(DocumentReference::class, $doc);

        $parent = explode('/', $doc->name());
        $id = array_pop($parent);
        $this->assertEquals(self::NAME, implode('/', $parent));
        $this->assertEquals(20, strlen($id));
    }

    public function testAdd()
    {
        $this->connection->commit(Argument::that(function ($args) {
            $expected = [
                'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                'writes' => [
                    [
                        'currentDocument' => ['exists' => false],
                        'update' => [
                            'fields' => [
                                'hello' => [
                                    'stringValue' => 'world'
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            unset($args['writes'][0]['update']['name']);

            return $args === $expected;
        }))->shouldBeCalled()->willReturn([[]]);

        $this->collection->___setProperty('connection', $this->connection->reveal());

        $this->collection->add(['hello' => 'world']);
    }

    public function testListDocuments()
    {
        $parts = explode('/', self::NAME);
        $id = end($parts);

        $docName = self::NAME . '/foo';

        $this->connection->listDocuments(Argument::allOf(
            Argument::withEntry('parent', self::COLLECTION_PARENT),
            Argument::withEntry('collectionId', $id),
            Argument::withEntry('mask', [])
        ))->shouldBeCalled()->willReturn([
            'documents' => [
                [
                    'name' => $docName
                ]
            ]
        ]);

        $this->collection->___setProperty('connection', $this->connection->reveal());

        $res = $this->collection->listDocuments();
        $docs = iterator_to_array($res);

        $this->assertInstanceOf(ItemIterator::class, $res);
        $this->assertInstanceOf(DocumentReference::class, $docs[0]);
        $this->assertEquals($docName, $docs[0]->name());
    }

    public function testExtends()
    {
        $this->assertInstanceOf(Query::class, $this->collection);
    }

    /**
     * @dataProvider randomNames
     */
    public function testRandomNames(DocumentReference $doc)
    {
        $id = $doc->id();
        $this->assertEquals(1, preg_match('/[0-9a-zA-Z]{20}/', $id));
    }

    public function randomNames()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $collection = TestHelpers::stub(CollectionReference::class, [
            $connection->reveal(),
            new ValueMapper($connection->reveal(), false),
            self::NAME
        ]);

        $res = [];
        for ($i = 0; $i < 50; $i++) {
            $res[] = [$collection->newDocument()];
        }

        return $res;
    }

    /**
     * @group firestore-parent
     */
    public function testParent()
    {
        $parent = $this->collection->parent();
        $this->assertInstanceOf(DocumentReference::class, $parent);
        $this->assertEquals(self::COLLECTION_PARENT, $parent->name());
    }

    /**
     * @group firestore-parent
     */
    public function testParentForRootCollection()
    {
        $collectionName = 'projects/example_project/databases/(default)/documents/foo';
        $collection = TestHelpers::stub(CollectionReference::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            $collectionName
        ]);
        $this->assertNull($collection->parent());
    }
}
