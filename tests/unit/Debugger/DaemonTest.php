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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Google\Cloud\Debugger\Daemon;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\DebuggerClient;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class DaemonTest extends TestCase
{
    private $client;
    private $debuggee;
    private $storage;

    public function setUp()
    {
        $this->client = $this->prophesize(DebuggerClient::class);
        $this->debuggee = $this->prophesize(Debuggee::class);
        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
    }

    public function testSpecifyUniquifier()
    {
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->client->debuggee(null, Argument::that(function ($options) {
            return $options['uniquifier'] == 'some uniquifier';
        }))->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon('.', [
            'client' => $this->client->reveal(),
            'storage' => $this->storage->reveal(),
            'uniquifier' => 'some uniquifier'
        ]);
    }

    public function testSpecifyDescription()
    {
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->client->debuggee(null, Argument::that(function ($options) {
            return $options['description'] == 'some description';
        }))->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon('.', [
            'client' => $this->client->reveal(),
            'storage' => $this->storage->reveal(),
            'description' => 'some description'
        ]);
    }

    public function testSpecifyExtSourceContext()
    {
        $context = [
            'context' => [
                'git' => [
                    'url' => 'https://github.com/GoogleCloudPlatform/google-cloud-php',
                    'revisionId' => 'master'
                ]
            ],
            'labels' => []
        ];
        $this->debuggee->register(Argument::any())->shouldBeCalled();
        $this->client->debuggee(null, Argument::that(function ($options) use ($context) {
            return $options['extSourceContexts'] == [$context];
        }))->willReturn($this->debuggee->reveal())->shouldBeCalled();

        $daemon = new Daemon('.', [
            'client' => $this->client->reveal(),
            'storage' => $this->storage->reveal(),
            'extSourceContext' => $context
        ]);
    }

    public function testFetchesBreakpoints()
    {
        $breakpoints = [
            new Breakpoint(['id' => 'breakpoint1'])
        ];
        $this->debuggee->register(Argument::any())
            ->shouldBeCalled();
        $this->debuggee->breakpoints()
            ->willReturn($breakpoints);
        $this->debuggee->updateBreakpointBatch(Argument::any())
            ->willReturn(true);
        $this->client->debuggee(null, Argument::any())
            ->willReturn($this->debuggee->reveal())
            ->shouldBeCalled();

        $daemon = new Daemon('.', [
            'client' => $this->client->reveal(),
            'storage' => $this->storage->reveal()
        ]);
        $daemon->run();
    }
}
