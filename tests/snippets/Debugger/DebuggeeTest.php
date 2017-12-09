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

namespace Google\Cloud\Tests\Snippets\Debugger;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group debugger
 */
class DebuggeeTest extends SnippetTestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Debuggee::class);
        $res = $snippet->invoke('debuggee');
        $this->assertInstanceOf(Debuggee::class, $res->returnVal());
    }

    public function testId()
    {
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project']);
        $snippet = $this->snippetFromMethod(Debuggee::class, 'id');
        $snippet->addLocal('debuggee', $debuggee);

        $res = $snippet->invoke('debuggee');
        $this->assertEquals('debuggee1', $res->output());
    }

    public function testRegister()
    {
        $this->connection->registerDebuggee(Argument::any())->willReturn([
            'debuggee' => [
                'id' => 'debuggee1'
            ]
        ]);
        $debuggee = new Debuggee($this->connection->reveal(), ['project' => 'project']);
        $snippet = $this->snippetFromMethod(Debuggee::class, 'register');
        $snippet->addLocal('debuggee', $debuggee);

        $res = $snippet->invoke('debuggee');
        $this->assertEquals('debuggee1', $res->output());
    }

    public function testBreakpoints()
    {
        $this->connection->listBreakpoints(Argument::any())->willReturn([
            'breakpoints' => [
                ['id' => 'breakpoint1']
            ]
        ]);
        $debuggee = new Debuggee($this->connection->reveal(), ['project' => 'project']);
        $snippet = $this->snippetFromMethod(Debuggee::class, 'breakpoints');
        $snippet->addLocal('debuggee', $debuggee);

        $res = $snippet->invoke('breakpoints');
        $breakpoints = $res->returnVal();
        $this->assertCount(1, $breakpoints);
        foreach ($breakpoints as $breakpoint) {
            $this->assertInstanceOf(Breakpoint::class, $breakpoint);
        }
    }

    public function testUpdateBreakpoint()
    {
        $this->connection->updateBreakpoint(Argument::any())->willReturn(true);
        $debuggee = new Debuggee($this->connection->reveal(), ['project' => 'project']);
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Debuggee::class, 'updateBreakpoint');
        $snippet->addLocal('debuggee', $debuggee);
        $snippet->addLocal('breakpoint', $breakpoint);
        $snippet->invoke('debuggee');
    }

    public function testUpdateBreakpointBatch()
    {
        $this->connection->updateBreakpoint(Argument::any())->willReturn(true)->shouldBeCalledTimes(2);
        $debuggee = new Debuggee($this->connection->reveal(), ['project' => 'project']);
        $breakpoint1 = new Breakpoint(['id' => 'breakpoint1']);
        $breakpoint2 = new Breakpoint(['id' => 'breakpoint2']);
        $snippet = $this->snippetFromMethod(Debuggee::class, 'updateBreakpointBatch');
        $snippet->addLocal('debuggee', $debuggee);
        $snippet->addLocal('breakpoint1', $breakpoint1);
        $snippet->addLocal('breakpoint2', $breakpoint2);
        $snippet->invoke('debuggee');
    }
}
