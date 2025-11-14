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

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\Tests\Unit\ServerStreamMockTrait;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as GapicFirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use GPBMetadata\Google\Firestore\Admin\V1\Snapshot;
use GPBMetadata\Google\Firestore\V1\Firestore;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-documentsnapshot
 */
class DocumentSnapshotTest extends SnippetTestCase
{
    use GenerateProtoTrait;
    use ServerStreamMockTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $snapshot;

    public function setUp(): void
    {
        $this->snapshot = $this->getSnapshot();
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $gapicClient = $this->prophesize(GapicFirestoreClient::class);
        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, ['missing' => self::DOCUMENT]);

        $gapicClient->batchGetDocuments(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $client = new FirestoreClient(['firestoreClient' => $gapicClient->reveal()]);
        $snippet = $this->snippetFromClass(DocumentSnapshot::class);
        $snippet->setLine(2, '');
        $snippet->addLocal('firestore', $client);
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(DocumentSnapshot::class, $res->returnVal());
    }

    public function testClassArrayAccess()
    {
        $fields = ['wallet' => ['cryptoCurrency' => ['bitcoin' => 1]]];
        $snapshot = $this->getSnapshot($fields);

        $snippet = $this->snippetFromClass(DocumentSnapshot::class, 1);
        $snippet->addLocal('snapshot', $snapshot);
        $res = $snippet->invoke('bitcoinWalletValue');
        $this->assertEquals(1, $res->returnVal());
    }

    public function testReference()
    {
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'reference');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('reference');
        $this->assertInstanceOf(DocumentReference::class, $res->returnVal());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'name');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('name');
        $this->assertEquals(self::DOCUMENT, $res->returnVal());
    }

    public function testPath()
    {
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'path');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('path');
        $this->assertEquals('a/b', $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'id');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('id');

        $parts = explode('/', self::DOCUMENT);
        $id = array_pop($parts);
        $this->assertEquals($id, $res->returnVal());
    }

    /**
     * @dataProvider timestampMethods
     */
    public function testTimestampMethods($method)
    {
        $ts = new Timestamp(new \DateTime);
        $info = [$method => $ts];
        $snapshot = $this->getSnapshot(info: $info);

        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, $method);
        $snippet->addLocal('snapshot', $snapshot);
        $res = $snippet->invoke($method);

        $this->assertEquals($ts, $res->returnVal());

        $snapshot = $this->getSnapshot();
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, $method);
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke($method);

        $this->assertNull($res->returnVal());
    }

    public function timestampMethods()
    {
        return [
            ['readTime'],
            ['updateTime'],
            ['createTime']
        ];
    }

    public function testData()
    {
        $data = ['foo' => 'bar'];
        $snapshot = $this->getSnapshot($data);

        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'data');
        $snippet->addLocal('snapshot', $snapshot);
        $res = $snippet->invoke('data');
        $this->assertEquals($data, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'exists');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke();
        $this->assertEquals("The document exists!", $res->output());
    }

    public function testGet()
    {
        $fields = [
            'wallet' => [
                'cryptoCurrency' => [
                    'bitcoin' => 1
                ]
            ]
        ];

        $snapshot = $this->getSnapshot($fields);
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'get');
        $snippet->addLocal('snapshot', $snapshot);
        $res = $snippet->invoke('value');
        $this->assertEquals(1, $res->returnVal());
    }

    public function testGetFieldPath()
    {
        $fields = [
            'wallet' => [
                'cryptoCurrency' => [
                    'my.coin' => 1
                ]
            ]
        ];

        $snapshot = $this->getSnapshot($fields);

        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'get', 1);
        $snippet->addLocal('snapshot', $snapshot);
        $res = $snippet->invoke('value');
        $this->assertEquals(1, $res->returnVal());
    }

    public function getSnapshot(array $data = [], array $info = []): DocumentSnapshot
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::DOCUMENT);
        $parts = explode('/', self::DOCUMENT);
        $ref->id()->willReturn(array_pop($parts));
        $ref->path()->willReturn(explode('/documents/', self::DOCUMENT)[1]);

        return new DocumentSnapshot(
            $ref->reveal(),
            new ValueMapper($this->prophesize(GapicFirestoreClient::class)->reveal(), false),
            $info,
            $data,
            true
        );
    }
}
