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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\ValueMapper;
use Prophecy\Argument;

/**
 * @group spanner
 */
class SnapshotTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

    const TRANSACTION = 'my-transaction';

    private $connection;
    private $snapshot;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $operation = $this->prophesize(Operation::class);
        $session = $this->prophesize(Session::class);

        $this->snapshot = TestHelpers::stub(Snapshot::class, [
            $operation->reveal(),
            $session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(new \DateTime)
            ]
        ], ['operation']);
    }

    public function testClass()
    {
        $database = $this->prophesize(Database::class);
        $database->snapshot()->shouldBeCalled()->willReturn('foo');

        $snippet = $this->snippetFromClass(Snapshot::class);
        $snippet->replace('$database =', '//$database =');
        $snippet->addLocal('database', $database->reveal());

        $res = $snippet->invoke('transaction');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMagicMethod(Snapshot::class, 'id');
        $snippet->addLocal('transaction', $this->snapshot);

        $res = $snippet->invoke('id');
        $this->assertEquals(self::TRANSACTION, $res->returnVal());
    }

    public function testReadTimestamp()
    {
        $snippet = $this->snippetFromMethod(Snapshot::class, 'readTimestamp');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
