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

namespace Google\Cloud\Trace\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Trace;
use Google\Cloud\Trace\TraceClient;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;

/**
 * @group trace
 */
class TraceClientTest extends SnippetTestCase
{
    use AssertionRenames;

    private $connection;
    private $client;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(TraceClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(TraceClient::class);
        $res = $snippet->invoke('trace');
        $this->assertInstanceOf(TraceClient::class, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(TraceClient::class, 'insert');
        $snippet->addLocal('traceClient', $this->client);
        $res = $snippet->invoke('result');
        $this->assertEquals(true, $res->returnVal());
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(TraceClient::class, 'insertBatch');
        $snippet->addLocal('traceClient', $this->client);
        $res = $snippet->invoke('result');
        $this->assertEquals(true, $res->returnVal());
    }

    public function testTrace()
    {
        $snippet = $this->snippetFromMethod(TraceClient::class, 'trace');
        $snippet->addLocal('traceClient', $this->client);
        $res = $snippet->invoke('trace');
        $trace = $res->returnVal();
        $this->assertInstanceOf(Trace::class, $trace);
        $this->assertMatchesRegularExpression('/[0-9a-f]{32}/', $trace->traceId());
    }

    public function testTraceWithTraceId()
    {
        $snippet = $this->snippetFromMethod(TraceClient::class, 'trace', 1);
        $snippet->addLocal('traceClient', $this->client);
        $res = $snippet->invoke('trace');
        $trace = $res->returnVal();
        $this->assertInstanceOf(Trace::class, $trace);
        $this->assertEquals('1234abcd', $trace->traceId());
    }
}
