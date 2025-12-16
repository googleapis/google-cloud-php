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

use Google\ApiCore\ApiException;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Exception\BadRequestException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\ListDocumentsRequest;
use Google\Cloud\Firestore\V1\ListDocumentsResponse;
use Google\Rpc\Code;

/**
 * @group firestore
 * @group firestore-collectionreference
 */
class CollectionReferenceTest extends TestCase
{
    use GenerateProtoTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const COLLECTION_PARENT = 'projects/example_project/databases/(default)/documents/a/doc';
    const NAME = 'projects/example_project/databases/(default)/documents/a/doc/b';

    private $gapicClient;
    private $collection;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->collection = new CollectionReference(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            self::NAME
        );
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
        $expectedRequest = new CommitRequest();
        $expectedRequest->mergeFromJsonString(json_encode([
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
        ]));

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) use ($expectedRequest) {
                $request->getWrites()[0]->getUpdate()->setName('');
                $this->assertEquals($expectedRequest, $request);

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(new CommitResponse());

        $this->collection->add(['hello' => 'world']);
    }

    public function testListDocuments()
    {
        $parts = explode('/', self::NAME);
        $id = end($parts);

        $docName = self::NAME . '/foo';

        // 1. Create a mock Document proto
        $documentProto = new Document();
        $documentProto->setName($docName);

        // 2. Prophesize Google\ApiCore\Page
        $page = $this->prophesize(Page::class);
        // Configure the Page to yield our Document proto when iterated
        $page->getResponseObject()->willReturn(new ListDocumentsResponse([
            'documents' => [$documentProto],
            'next_page_token' => ''
        ]));


        // 3. Prophesize Google\ApiCore\PagedListResponse
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        // Configure PagedListResponse to return our mocked Page object
        $pagedListResponse->getPage()->willReturn($page->reveal());

        // 4. Configure the gapicClient to return the mocked PagedListResponse
        $this->gapicClient->listDocuments(
            Argument::that(function (ListDocumentsRequest $request) use ($id) {
                $this->assertEquals(self::COLLECTION_PARENT, $request->getParent());
                $this->assertEquals($id, $request->getCollectionId());
                // Assert that the mask is empty (no field paths requested)
                $this->assertEmpty(iterator_to_array($request->getMask()->getFieldPaths()->getIterator()));

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn($pagedListResponse->reveal());

        // Execute the method under test
        $res = $this->collection->listDocuments();
        $docs = iterator_to_array($res);

        // Assertions
        $this->assertInstanceOf(ItemIterator::class, $res);
        $this->assertCount(1, $docs);
        $this->assertInstanceOf(DocumentReference::class, $docs[0]);
        $this->assertEquals($docName, $docs[0]->name());
    }

    public function testListDocumentsRaisesAServiceException()
    {
        $this->expectException(BadRequestException::class);

        $this->gapicClient->listDocuments(
            Argument::any(),
            Argument::any()
        )->shouldBeCalled()->willThrow(new ApiException('Transient Error', Code::INVALID_ARGUMENT));


        $res = $this->collection->listDocuments();
        iterator_to_array($res);
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
        $gapicClient = $this->prophesize(FirestoreClient::class);
        $collection = TestHelpers::stub(CollectionReference::class, [
            $gapicClient->reveal(),
            new ValueMapper($gapicClient->reveal(), false),
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
        $collection = new CollectionReference(
            $this->gapicClient->reveal(),
            new ValueMapper($this->gapicClient->reveal(), false),
            $collectionName
        );
        $this->assertNull($collection->parent());
    }
}
