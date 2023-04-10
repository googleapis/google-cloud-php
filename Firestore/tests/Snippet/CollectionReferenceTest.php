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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * @group firestore
 * @group firestore-collectionreference
 */
class CollectionReferenceTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const NAME = 'projects/example_project/databases/(default)/documents/users';

    private $connection;
    private $collection;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->collection = TestHelpers::stub(CollectionReference::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::NAME
        ]);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(CollectionReference::class);
        $res = $snippet->invoke('collection');
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal());
    }

    public function testParent()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'parent');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('parent');
        $this->assertNull($res->returnVal());
    }

    public function testSubCollectionParent()
    {
        $subCollection = TestHelpers::stub(CollectionReference::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::NAME . '/doc/sub-collection',
        ]);

        $snippet = $this->snippetFromMethod(CollectionReference::class, 'parent');
        $snippet->addLocal('collection', $subCollection);
        $res = $snippet->invoke('parent');
        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
        $this->assertEquals('users/doc', $res->returnVal()->path());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'name');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('name');
        $this->assertEquals(self::NAME, $res->returnVal());
    }

    public function testPath()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'path');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('path');
        $this->assertEquals('users', $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'id');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('id');
        $parts = explode('/', self::NAME);
        $this->assertEquals(array_pop($parts), $res->returnVal());
    }

    public function testDocument()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'document');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('newUser');

        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testNewDocument()
    {
        $snippet = $this->snippetFromMethod(CollectionReference::class, 'newDocument');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('newUser');

        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testAdd()
    {
        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);
        $this->collection->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(CollectionReference::class, 'add');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('newUser');

        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testListDocuments()
    {
        $parts = explode('/', self::NAME);
        $id = end($parts);

        $docName = self::NAME . '/foo';

        $this->connection->listDocuments(Argument::any())->shouldBeCalled()->willReturn([
            'documents' => [
                [
                    'name' => $docName
                ]
            ]
        ]);

        $this->collection->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(CollectionReference::class, 'listDocuments');
        $snippet->addLocal('collection', $this->collection);
        $res = $snippet->invoke('documents');
        $docs = iterator_to_array($res->returnVal());

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(DocumentReference::class, $docs);
        $this->assertEquals($docName, $docs[0]->name());

        $this->assertEquals($docName . PHP_EOL, $res->output());
    }
}
