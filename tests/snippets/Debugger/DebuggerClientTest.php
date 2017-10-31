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

namespace Google\Cloud\Debugger\Snippets\Trace;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Google\Cloud\Debugger\DebuggerClient;
use Prophecy\Argument;

/**
 * @group debugger
 */
class DebuggerClientTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(DebuggerClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DebuggerClient::class);
        $res = $snippet->invoke('debugger');
        $this->assertInstanceOf(DebuggerClient::class, $res->returnVal());
    }
}
