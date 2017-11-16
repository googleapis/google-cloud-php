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

namespace Google\Cloud\Tests\Snippets\Firestore;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-documentreference
 */
class DocumentReferenceTest extends SnippetTestCase
{
    use GrpcTestTrait;
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $document;
    private $batch;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->document = \Google\Cloud\Dev\stub(DocumentReferenceStub::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            $this->prophesize(CollectionReference::class)->reveal(),
            self::DOCUMENT
        ]);
        $this->batch = $this->prophesize(WriteBatch::class);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(DocumentReference::class);
        $res = $snippet->invoke('document');
        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testParent()
    {
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'parent');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('parent');
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'name');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('name');
        $this->assertEquals(self::DOCUMENT, $res->returnVal());
    }

    public function testPath()
    {
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'path');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('path');
        $this->assertEquals('a/b', $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'id');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('id');
        $parts = explode('/', self::DOCUMENT);
        $this->assertEquals(array_pop($parts), $res->returnVal());
    }

    public function testCreate()
    {
        $this->batch->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);

        $this->batch->create(self::DOCUMENT, Argument::any(), Argument::any())
            ->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'create');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testSet()
    {
        $this->batch->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);

        $this->batch->set(self::DOCUMENT, Argument::any(), Argument::any())
            ->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'set');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->batch->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);

        $this->batch->update(self::DOCUMENT, Argument::any(), Argument::any())
            ->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdateSentinels()
    {
        $this->batch->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);

        $this->batch->update(self::DOCUMENT, [
            ['path' => 'country', 'value' => FieldValue::deleteField()],
            ['path' => 'lastLogin', 'value' => FieldValue::serverTimestamp()]
        ], Argument::any())->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update', 1);
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdateSpecialChars()
    {
        $this->batch->commit(Argument::any())
        ->shouldBeCalled()
        ->willReturn([[]]);

        $this->batch->update(self::DOCUMENT, Argument::any(), Argument::any())
            ->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update', 2);
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testDelete()
    {
        $this->batch->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([[]]);

        $this->batch->delete(self::DOCUMENT, Argument::any())
            ->shouldBeCalled()->willReturn($this->batch->reveal());

        $this->document->setBatch($this->batch->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'delete');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testSnapshot()
    {
        $this->connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                [
                    'found' => [
                        'name' => self::DOCUMENT,
                        'fields' => [],
                        'readTime' => ['seconds' => time()]
                    ]
                ]
            ]));

        $this->document->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'snapshot');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(DocumentSnapshot::class, $res->returnVal());
    }

    public function testCollection()
    {
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'collection');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('child');
        $this->assertInstanceOf(CollectionReference::class, $res->returnVal());
    }

    public function testCollections()
    {
        $this->connection->listCollectionIds(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['collectionIds' => ['foo','bar']]);

        $this->document->___setProperty('connection', $this->connection->reveal());
        $snippet = $this->snippetFromMethod(DocumentReference::class, 'collections');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('collections');
        $this->assertContainsOnlyInstancesOf(CollectionReference::class, $res->returnVal());
    }
}

class DocumentReferenceStub extends DocumentReference
{
    private $batch;

    public function setBatch(WriteBatch $batch)
    {
        $this->batch = $batch;
    }

    protected function batchFactory()
    {
        return $this->batch;
    }
}
