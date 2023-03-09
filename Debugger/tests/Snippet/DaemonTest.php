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

namespace Google\Cloud\Debugger\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Daemon;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Prophecy\Argument;

/**
 * @group debugger
 */
class DaemonTest extends SnippetTestCase
{
    private $client;
    private $debuggee;
    private $storage;

    public function set_up()
    {
        $this->client = $this->prophesize(DebuggerClient::class);
        $this->debuggee = $this->prophesize(Debuggee::class);
        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
        $this->debuggee->register()->willReturn(true);
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->breakpointsWithWaitToken([])->willReturn($resp);
        $this->client->debuggee(null, Argument::any())->willReturn($this->debuggee->reveal());
    }

    public function testClass()
    {
        $options = [
            'storage' => $this->storage->reveal()
        ];
        $snippet = $this->snippetFromClass(Daemon::class);
        $snippet->replace('new Daemon()', 'new Daemon($options)');
        $snippet->replace('run()', 'run($client, false)');
        $snippet->addLocal('options', $options);
        $snippet->addLocal('client', $this->client->reveal());
        $res = $snippet->invoke('daemon');
        $this->assertInstanceOf(Daemon::class, $res->returnVal());
    }

    public function testRun()
    {
        $options = [
            'storage' => $this->storage->reveal()
        ];
        $daemon = new Daemon($options);
        $snippet = $this->snippetFromMethod(Daemon::class, 'run');
        $snippet->replace('run()', 'run($client, false)');
        $snippet->addLocal('daemon', $daemon);
        $snippet->addLocal('client', $this->client->reveal());
        $res = $snippet->invoke('daemon');
        $this->assertInstanceOf(Daemon::class, $res->returnVal());
    }
}
