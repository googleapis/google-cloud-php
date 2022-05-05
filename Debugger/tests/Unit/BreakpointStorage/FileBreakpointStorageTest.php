<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Debugger\Tests\Unit\BreakpointStorage;

use Google\Cloud\Debugger\BreakpointStorage\FileBreakpointStorage;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Google\Cloud\Debugger\Debuggee;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group debugger
 */
class FileBreakpointStorageTest extends TestCase
{
    private $storage;

    public function set_up()
    {
        $this->storage = new FileBreakpointStorage();
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
