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

namespace Google\Cloud\Trace\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Trace;
use Google\Cloud\Trace\TraceClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group trace
 */
class TraceClientTest extends TestCase
{
    private $client;
    private $connection;

    public function setUp()
    {
        $this->client = TestHelpers::stub(TraceClient::class, [
            ['projectId' => 'project']
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testInsertTrace()
    {
        $this->connection->traceBatchWrite(Argument::any())->willReturn([
            'traces' => [
                [
                    'projectId' => 'project',
                    'traceId' => '1',
                    'spans' => [
                        ['name' => 'main']
                    ]
                ]
            ]
        ]);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $trace = new Trace(
            'project',
            '1',
            [
                ['name' => 'main']
            ]
        );
        $this->assertTrue($this->client->insert($trace));
    }

    public function testInsertMultipleTraces()
    {
        $this->connection->traceBatchWrite(Argument::any())->willReturn([
            'traces' => [
                [
                    'projectId' => 'project',
                    'traceId' => '1',
                    'spans' => [
                        ['name' => 'main']
                    ]
                ]
            ]
        ]);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $trace = new Trace(
            'project',
            '1',
            [
                ['name' => 'main']
            ]
        );
        $this->assertTrue($this->client->insertBatch([$trace]));
    }
}
