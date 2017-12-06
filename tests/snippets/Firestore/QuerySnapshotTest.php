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
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-querysnapshot
 */
class QuerySnapshotTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->snapshot = \Google\Cloud\Dev\stub(QuerySnapshot::class, [
            $this->prophesize(Query::class)->reveal(),
            []
        ], ['rows']);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([]));

        $client = \Google\Cloud\Dev\stub(FirestoreClient::class);
        $client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromClass(QuerySnapshot::class);
        $snippet->setLine(2, '');
        $snippet->addLocal('firestore', $client);
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(QuerySnapshot::class, $res->returnVal());
    }

    public function testClassIteratorExample()
    {
        $snippet = $this->snippetFromClass(QuerySnapshot::class, 1);
        $snippet->addLocal('snapshot', $this->snapshot);

        $this->snapshot->___setProperty('rows', [
            ['name' => 'John']
        ]);

        $res = $snippet->invoke();
        $this->assertEquals('John', trim($res->output()));
    }

    public function testRows()
    {
        $snippet = $this->snippetFromMethod(QuerySnapshot::class, 'rows');
        $snippet->addLocal('snapshot', $this->snapshot);
        $res = $snippet->invoke('rows');
        $this->assertEquals([], $res->returnVal());
    }

    public function testIsEmpty()
    {
        $snippet = $this->snippetFromMethod(QuerySnapshot::class, 'isEmpty');
        $snippet->addLocal('snapshot', $this->snapshot);
        $this->assertTrue($snippet->invoke('empty')->returnVal());
    }

    public function testSize()
    {
        $snippet = $this->snippetFromMethod(QuerySnapshot::class, 'size');
        $snippet->addLocal('snapshot', $this->snapshot);
        $this->assertEquals(0, $snippet->invoke('size')->returnVal());
    }
}
