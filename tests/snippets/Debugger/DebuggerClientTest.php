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
use Google\Cloud\Debugger\Debuggee;
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

    public function testDebuggee()
    {
        $this->connection->registerDebuggee(Argument::any())->willReturn([
            'debuggee' => [
                'id' => 'debuggee1'
            ]
        ]);
        $snippet = $this->snippetFromMethod(DebuggerClient::class, 'debuggee');
        $snippet->addLocal('client', $this->client);
        $res = $snippet->invoke('debuggee');
        $this->assertEquals('debuggee1', $res->returnVal()->id());
    }

    public function testDebuggeeWithId()
    {
        $snippet = $this->snippetFromMethod(DebuggerClient::class, 'debuggee', 1);
        $snippet->addLocal('client', $this->client);
        $res = $snippet->invoke('debuggee');
        $this->assertEquals('debuggee-id', $res->returnVal()->id());
    }

    public function testDebuggees()
    {
        $this->connection->listDebuggees(Argument::any())->willReturn([
            'debuggees' => [
                ['id' => 'debuggee1', 'project' => 'projectId']
            ]
        ]);
        $snippet = $this->snippetFromMethod(DebuggerClient::class, 'debuggees');
        $snippet->addLocal('client', $this->client);
        $res = $snippet->invoke('debuggees');
        $debuggees = $res->returnVal();
        $this->assertCount(1, $debuggees);
        foreach ($debuggees as $debuggee) {
            $this->assertInstanceOf(Debuggee::class, $debuggee);
        }
    }
}
