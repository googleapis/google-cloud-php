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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class ResultTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $database;
    private $result;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $result = $this->prophesize(Result::class);
        $database = $this->prophesize(Database::class);
        $result->rows()
            ->willReturn($this->resultGenerator());
        $result->metadata()
            ->willReturn([]);
        $result->columns()
            ->willReturn([]);
        $result->session()
            ->willReturn($this->prophesize(Session::class)->reveal());
        $result->snapshot()
            ->willReturn($this->prophesize(Snapshot::class)->reveal());
        $result->transaction()
            ->willReturn($this->prophesize(Transaction::class)->reveal());
        $result->stats()
            ->willReturn([]);
        $this->result = $result->reveal();
        $database->execute(Argument::any())
            ->willReturn($this->result);
        $this->database = $database->reveal();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Result::class);
        $snippet->replace('$database =', '//$database =');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testRows()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'rows');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('rows');
        $this->assertInstanceOf(\Generator::class, $res->returnVal());
    }

    public function testColumns()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'columns');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('columns');
        $this->assertInternalType('array', $res->returnVal());
    }

    public function testMetadata()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'metadata');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('metadata');
        $this->assertInternalType('array', $res->returnVal());
    }

    public function testSession()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'session');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('session');
        $this->assertInstanceOf(Session::class, $res->returnVal());
    }

    public function testStats()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'stats');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('stats');
        $this->assertInternalType('array', $res->returnVal());
    }

    public function testQueryWithStats()
    {
        $db = $this->prophesize(Database::class);
        $db->execute(Argument::any(), ['queryMode' => 'PROFILE']);

        $snippet = $this->snippetFromMethod(Result::class, 'stats', 1);
        $snippet->addLocal('database', $db->reveal());
        $snippet->invoke();
    }

    public function testSnapshot()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'snapshot');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testTransaction()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'transaction');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    private function resultGenerator()
    {
        yield [];
    }
}
