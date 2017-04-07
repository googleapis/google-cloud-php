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
use Prophecy\Argument;

/**
 * @group spanner
 */
class ResultTest extends SnippetTestCase
{
    private $database;
    private $result;

    public function setUp()
    {
        $result = $this->prophesize(Result::class);
        $database = $this->prophesize(Database::class);
        $result->rows()
            ->willReturn($this->resultGenerator());
        $result->metadata()
            ->willReturn([]);
        $result->snapshot()
            ->willReturn($this->prophesize(Snapshot::class)->reveal());
        $result->transaction()
            ->willReturn($this->prophesize(Transaction::class)->reveal());
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

    public function testMetadata()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'metadata');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('metadata');
        $this->assertInternalType('array', $res->returnVal());
    }

    public function testStats()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'metadata');
        $snippet->addLocal('result', $this->result);
        $res = $snippet->invoke('metadata');
        $this->assertInternalType('array', $res->returnVal());
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
