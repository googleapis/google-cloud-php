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

use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\BulkWriter;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\Tests\Unit\ServerStreamMockTrait;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Google\Cloud\Firestore\V1\ListCollectionIdsResponse;
use Google\Cloud\Firestore\ValueMapper;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-documentreference
 */
class DocumentReferenceTest extends SnippetTestCase
{
    use ServerStreamMockTrait;
    use GenerateProtoTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $gapicClient;
    private $document;
    private $batch;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->document = new DocumentReference(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            $this->prophesize(CollectionReference::class)->reveal(),
            self::DOCUMENT
        );
        $this->batch = $this->prophesize(BulkWriter::class);
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
        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'create');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testSet()
    {
        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'set');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdateSentinels()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $writes = $request->getWrites();
                $this->assertCount(2, $writes);

                $this->assertEquals('country', $writes[0]->getUpdateMask()->getFieldPaths()[0]);

                $transform = $writes[1]->getTransform();
                $this->assertNotNull($transform);
                $fieldTransforms = $transform->getFieldTransforms();
                $this->assertCount(1, $fieldTransforms);
                $fieldTransform = $fieldTransforms[0];
                $this->assertEquals('lastLogin', $fieldTransform->getFieldPath());
                $this->assertEquals(
                    ServerValue::REQUEST_TIME,
                    $fieldTransform->getSetToServerValue()
                );

                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update', 1);
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testUpdateSpecialChars()
    {
        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertNotEmpty($request->getWrites()[0]->getUpdate());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'update', 2);
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testDelete()
    {
        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertNotEmpty($request->getWrites()[0]->getDelete());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'delete');
        $snippet->addLocal('document', $this->document);
        $snippet->invoke();
    }

    public function testSnapshot()
    {
        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => self::DOCUMENT,
                'fields' => [],
            ],
            'readTime' => [
                'seconds' => 123,
                'nanos' => 321
            ]
        ]);

        $this->gapicClient->batchGetDocuments(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

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
        $protoResponse = self::generateProto(ListCollectionIdsResponse::class, ['collectionIds' => ['foo','bar']]);

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn($protoResponse);

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->shouldBeCalled()
            ->willReturn($page->reveal());

        $this->gapicClient->listCollectionIds(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($pagedListResponse->reveal());

        $snippet = $this->snippetFromMethod(DocumentReference::class, 'collections');
        $snippet->addLocal('document', $this->document);
        $res = $snippet->invoke('collections');
        $this->assertContainsOnlyInstancesOf(CollectionReference::class, $res->returnVal());
    }
}
