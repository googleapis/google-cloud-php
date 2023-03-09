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

namespace Google\Cloud\Debugger\Tests\Unit;

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\SourceContext;
use Google\Cloud\Debugger\ExtendedSourceContext;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group debugger
 */
class DebuggeeTest extends TestCase
{
    private $connection;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testFetchesBreakpoints()
    {
        $this->connection->listBreakpoints(['debuggeeId' => 'debuggee1'])->willReturn([
            'breakpoints' => [
                ['id' => 'breakpoint1'],
                ['id' => 'breakpoint2']
            ]
        ]);
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);
        $breakpoints = $debuggee->breakpoints();
        $this->assertCount(2, $breakpoints);
        $this->assertEquals('breakpoint1', $breakpoints[0]->id());
        $this->assertEquals('breakpoint2', $breakpoints[1]->id());
    }

    public function testFetchesEmptyBreakpoints()
    {
        $this->connection->listBreakpoints(['debuggeeId' => 'debuggee1'])->willReturn([]);
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);
        $breakpoints = $debuggee->breakpoints();
        $this->assertCount(0, $breakpoints);
    }

    public function testFetchesBreakpointsWithWaitToken()
    {
        $this->connection->listBreakpoints(['debuggeeId' => 'debuggee1'])->willReturn([
            'breakpoints' => [
                ['id' => 'breakpoint1'],
                ['id' => 'breakpoint2']
            ],
            'nextWaitToken' => 'token'
        ]);
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);
        $resp = $debuggee->breakpointsWithWaitToken();
        $this->assertArrayHasKey('breakpoints', $resp);
        $this->assertCount(2, $resp['breakpoints']);
        $this->assertArrayHasKey('nextWaitToken', $resp);
        $this->assertEquals('token', $resp['nextWaitToken']);
    }

    public function testFetchesEmptyBreakpointsWithWaitToken()
    {
        $this->connection->listBreakpoints(['debuggeeId' => 'debuggee1'])->willReturn([
            'nextWaitToken' => 'token'
        ]);
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);
        $resp = $debuggee->breakpointsWithWaitToken();
        $this->assertArrayHasKey('breakpoints', $resp);
        $this->assertCount(0, $resp['breakpoints']);
        $this->assertArrayHasKey('nextWaitToken', $resp);
        $this->assertEquals('token', $resp['nextWaitToken']);
    }

    public function testUpdatesBreakpoint()
    {
        $this->connection->updateBreakpoint(Argument::that(function ($args) {
            return $args['id'] == 'breakpoint1';
        }))->willReturn([])->shouldBeCalled();
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);

        $breakpoint = new Breakpoint([
            'id' => 'breakpoint1'
        ]);
        $debuggee->updateBreakpoint($breakpoint);
    }

    public function testSetsBreakpoint()
    {
        $this->connection->setBreakpoint(Argument::that(function ($args) {
            return $args['debuggeeId'] == 'debuggee1' &&
                $args['location']['path'] == '/path/to/file.php' &&
                $args['location']['line'] == 10;
        }))->willReturn(['breakpoint' => ['id' => 'breakpoint1']]);
        $debuggee = new Debuggee($this->connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);

        $breakpoint = $debuggee->setBreakpoint('/path/to/file.php', 10);
        $this->assertInstanceOf(Breakpoint::class, $breakpoint);
        $this->assertEquals('breakpoint1', $breakpoint->id());
    }

    // Debug agents should populate both sourceContexts and extSourceContexts.
    public function testProvidesDeprecatedSourceContext()
    {
        $sourceContext = $this->prophesize(SourceContext::class);
        $sourceContext->info()->willReturn([]);
        $extSourceContext = $this->prophesize(ExtendedSourceContext::class);
        $extSourceContext->context()->willReturn($sourceContext->reveal());
        $extSourceContext->info()->willReturn([]);
        $debuggee = new Debuggee($this->connection->reveal(), [
            'project' => 'project1',
            'extSourceContexts' => [$extSourceContext->reveal()]
        ]);
        $json = $debuggee->info();
        $this->assertArrayHasKey('extSourceContexts', $json);
        $this->assertCount(1, $json['extSourceContexts']);
        $this->assertArrayHasKey('sourceContexts', $json);
        $this->assertCount(1, $json['sourceContexts']);
    }

    public function testRegisterSetsDebuggeeId()
    {
        $this->connection->registerDebuggee(Argument::that(function ($args) {
            return !isset($args['debuggee']['id']);
        }), Argument::any())->willReturn([
            'debuggee' => [
                'id' => 'debuggee1'
            ]
        ]);

        $debuggee = new Debuggee($this->connection->reveal(), ['project' => 'project1']);
        $this->assertTrue($debuggee->register());
        $this->assertEquals('debuggee1', $debuggee->id());
    }

    public function testDebuggeeExtendedSourceContextSerialization()
    {
        $debuggee = new Debuggee($this->connection->reveal(), [
            'project' => 'project1',
            'extSourceContexts' => [
                [
                    'context' => []
                ]
            ]
        ]);
        $info = $debuggee->info();
        $this->assertArrayHasKey('extSourceContexts', $info);
        $this->assertCount(1, $info['extSourceContexts']);
        $this->assertArrayHasKey('sourceContexts', $info);
        $this->assertCount(1, $info['sourceContexts']);
    }

    public function testDebuggeeOmitsId()
    {
        $debuggee = new Debuggee($this->connection->reveal(), []);
        $this->assertArrayNotHasKey('id', $debuggee->info());

        $debuggee = new Debuggee($this->connection->reveal(), [
            'id' => 'foo'
        ]);
        $this->assertArrayHasKey('id', $debuggee->info());
    }
}
