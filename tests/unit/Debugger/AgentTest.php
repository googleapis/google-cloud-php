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

use Google\Cloud\Debugger\Agent;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class AgentTest extends TestCase
{
    private $storage;

    public function setUp()
    {
        if (PHP_MAJOR_VERSION < 7) {
            $this->markTestSkipped('Can only run the Agent on PHP 7+');
        }
        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
    }

    public function testSpecifyStorage()
    {
        $this->storage->load()->willReturn('debuggeeId', []);
        $agent = new Agent(['storage' => $this->storage->reveal()]);
    }

    public function testSpecifyLogger()
    {
        $this->storage->load()->willReturn('debuggeeId', []);
        $logger = $this->prophesize(LoggerInterface::class);

        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $logger->reveal()
        ]);
    }

    public function testSpecifyDebuggee()
    {
        $this->storage->load()->willReturn('debuggeeId', []);
        $debuggee = $this->prophesize(Debuggee::class);

        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'debuggee' => $debuggee->reveal()
        ]);
    }
}
