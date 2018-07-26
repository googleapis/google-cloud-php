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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Debugger\Connection\ConnectionInterface;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\DebuggerClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group debugger
 */
class DebuggerClientTest extends TestCase
{
    const PROJECT = 'my-project';

    private $client;
    private $connection;

    public function setUp()
    {
        $this->client = TestHelpers::stub(DebuggerClient::class, [
            ['projectId' => self::PROJECT]
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testListsDebuggees()
    {
        $this->connection->listDebuggees(['project' => self::PROJECT])->willReturn([
            'debuggees' => [
                ['id' => 'debuggee1', 'project' => self::PROJECT],
                ['id' => 'debuggee2', 'project' => self::PROJECT],
            ]
        ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $debuggees = $this->client->debuggees();
        $this->assertCount(2, $debuggees);
        $this->assertEquals('debuggee1', $debuggees[0]->id());
        $this->assertEquals('debuggee2', $debuggees[1]->id());
    }

    public function testListsDebuggeesEmpty()
    {
        $this->connection->listDebuggees(['project' => self::PROJECT])->willReturn([]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $debuggees = $this->client->debuggees();
        $this->assertCount(0, $debuggees);
    }

    public function testBuildsDebuggee()
    {
        $debuggee = $this->client->debuggee('debuggee1');
        $this->assertInstanceOf(Debuggee::class, $debuggee);
        $this->assertEquals('debuggee1', $debuggee->id());
    }

    public function testLazilyBuildsDebuggee()
    {
        $debuggee = $this->client->debuggee();
        $this->assertInstanceOf(Debuggee::class, $debuggee);
        $this->assertNull($debuggee->id());
    }
}
