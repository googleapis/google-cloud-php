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

use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-collectionreference
 */
class CollectionReferenceTest extends TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const PARENT = 'projects/example_project/databases/(default)/documents/a';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $collection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->collection = \Google\Cloud\Dev\stub(CollectionReference::class, [
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
        $this->assertEquals('a/b', $this->collection->path());
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
            if ($args !== $expected) return false;

            return true;
        }))->shouldBeCalled()->willReturn([[]]);

        $this->collection->___setProperty('connection', $this->connection->reveal());

        $this->collection->add(['hello' => 'world']);
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
        $collection = \Google\Cloud\Dev\stub(CollectionReference::class, [
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
}
