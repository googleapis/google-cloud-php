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

namespace Google\Cloud\Tests\Unit\Debugger\BreakpointStorage;

use Google\Cloud\Debugger\BreakpointStorage\SysvBreakpointStorage;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Core\SysvTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class SysvBreakpointStorageTest extends TestCase
{
    use SysvTrait;

    private $storage;

    public function setUp()
    {
        if (! $this->isSysvIPCLOaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded');
        }
        $this->storage = new SysvBreakpointStorage();
    }

    public function testSaveAndLoad()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $debuggee = new Debuggee($connection->reveal(), ['id' => 'debuggee1', 'project' => 'project1']);
        $breakpoints = [
            new Breakpoint(['id' => 'breakpoint1'])
        ];
        $this->storage->save($debuggee, $breakpoints);
        $this->assertEquals(['debuggee1', $breakpoints], $this->storage->load());
    }
}
