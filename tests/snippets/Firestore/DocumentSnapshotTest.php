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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-documentsnapshot
 */
class DocumentSnapshotTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $snapshot;

    public function setUp()
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::DOCUMENT);
        $parts = explode('/', self::DOCUMENT);
        $ref->id()->willReturn(array_pop($parts));
        $ref->path()->willReturn(explode('/documents/', self::DOCUMENT)[1]);

        $this->snapshot = \Google\Cloud\Dev\stub(DocumentSnapshot::class, [
            $ref->reveal(),
            new ValueMapper($this->prophesize(ConnectionInterface::class)->reveal(), false),
            [],
            [],
            true
        ], ['info', 'fields', 'exists']);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                ['missing' => self::DOCUMENT]
            ]));

        $client = \Google\Cloud\Dev\stub(FirestoreClient::class);
        $client->___setProperty('connection', $connection->reveal());
        $snippet = $this->snippetFromClass(DocumentSnapshot::class);
        $snippet->setLine(2, '');
        $snippet->addLocal('firestore', $client);
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(DocumentSnapshot::class, $res->returnVal());
    }

    public function testClassArrayAccess()
    {
        $fields = ['wallet' => ['cryptoCurrency' => ['bitcoin' => 1]]];
        $this->snapshot->___setProperty('fields', $fields);

        $snippet = $this->snippetFromClass(DocumentSnapshot::class, 1);
        $snippet->addLocal('snapshot', $this->snapshot);
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
        $this->snapshot->___setProperty('info', $info);

        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, $method);
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke($method);

        $this->assertEquals($ts, $res->returnVal());

        $this->snapshot->___setProperty('info', []);
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

    public function testFields()
    {
        $fields = ['foo' => 'bar'];
        $this->snapshot->___setProperty('fields', $fields);
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'fields');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('fields');
        $this->assertEquals($fields, $res->returnVal());
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

        $this->snapshot->___setProperty('fields', $fields);
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'get');
        $snippet->addLocal('snapshot', $this->snapshot);
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

        $this->snapshot->___setProperty('fields', $fields);
        $snippet = $this->snippetFromMethod(DocumentSnapshot::class, 'get', 1);
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('value');
        $this->assertEquals(1, $res->returnVal());
    }
}
