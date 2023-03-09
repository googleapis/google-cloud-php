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

use Google\Cloud\Core\Report\SimpleMetadataProvider;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Google\Cloud\Debugger\Daemon;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\DebuggerClient;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group debugger
 */
class DaemonTest extends TestCase
{
    private $client;
    private $debuggee;
    private $storage;

    public function set_up()
    {
        $this->client = $this->prophesize(DebuggerClient::class);
        $this->debuggee = $this->prophesize(Debuggee::class);
        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
    }

    public function testSpecifyUniquifier()
    {
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::withEntry('uniquifier', 'some uniquifier'))
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'storage' => $this->storage->reveal(),
            'uniquifier' => 'some uniquifier'
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testGeneratesDefaultUniquifier()
    {
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::that(function ($options) {
            return preg_match('/[a-z0-9]{32}/', $options['uniquifier']);
        }))->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'sourceRoot' => implode(DIRECTORY_SEPARATOR, [__DIR__, 'data']),
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testSpecifyDescription()
    {
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::withEntry('description', 'some description'))
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'client' => $this->client->reveal(),
            'storage' => $this->storage->reveal(),
            'description' => 'some description'
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testSpecifyExtSourceContext()
    {
        $context = [
            'context' => [
                'git' => [
                    'url' => 'https://github.com/googleapis/google-cloud-php',
                    'revisionId' => 'master'
                ]
            ],
            'labels' => []
        ];
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::withEntry('extSourceContexts', [$context]))
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'storage' => $this->storage->reveal(),
            'extSourceContext' => $context
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testEmptyDefaultSourceContext()
    {
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::withEntry('extSourceContexts', []))
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testDefaultSourceContext()
    {
        $expectedSourceContext = [
            'context' => [
                'git' => [
                    'revisionId' => '81b20d097da02ebb6c6fdfbf6900c67a90f2c54b',
                    'url' => 'https://github.com/googleapis/google-cloud-php.git'
                ]
            ]
        ];
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->client->debuggee(null, Argument::withEntry('extSourceContexts', [$expectedSourceContext]))
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $root = implode(DIRECTORY_SEPARATOR, [__DIR__, 'data']);
        $daemon = new Daemon([
            'sourceRoot' => $root,
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testFetchesBreakpoints()
    {
        $resp = [
            'breakpoints' => [new Breakpoint(['id' => 'breakpoint1'])],
            'nextWaitToken' => 'abc123'
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->debuggee->updateBreakpointBatch(Argument::any())
            ->willReturn(true);
        $this->client->debuggee(null, Argument::any())
            ->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon([
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run($this->client->reveal(), false);
    }

    public function testDetectsLabelsFromEnvironment()
    {
        $resp = [
            'breakpoints' => [],
            'nextWaitToken' => 'abc123'
        ];
        $provider = new SimpleMetadataProvider([], 'project1', 'service1', 'version1');
        $expectedLabels = [
            'module' => 'service1',
            'projectid' => 'project1',
            'version' => 'version1'
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpointsWithWaitToken([])
            ->willReturn($resp);
        $this->debuggee->updateBreakpointBatch(Argument::any())
            ->willReturn(true);
        $this->client->debuggee(null, Argument::withEntry('labels', $expectedLabels))
            ->willReturn($this->debuggee->reveal())
            ->shouldBeCalled();

        $daemon = new Daemon([
            'metadataProvider' => $provider,
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run($this->client->reveal(), false);
    }
}
