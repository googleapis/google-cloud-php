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

namespace Google\Cloud\Tests\Unit\Trace;

use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Trace;
use Google\Cloud\Trace\TraceClient;
use Prophecy\Argument;

/**
 * @group trace
 */
class TraceClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $connection;

    public function setUp()
    {
        $this->client = new TraceTestClient(['projectId' => 'project']);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testListsTraces()
    {
        $this->connection->listTraces(Argument::any())->willReturn([
            'traces' => [
                ['projectId' => 'project', 'traceId' => '1'],
                ['projectId' => 'project', 'traceId' => '2'],
                ['projectId' => 'project', 'traceId' => '3']
            ]
        ]);

        $this->client->setConnection($this->connection->reveal());
        $traces = iterator_to_array($this->client->traces());

        $this->assertEquals(3, count($traces));
        $this->assertEquals('1', $traces[0]->traceId());
        $this->assertEquals('2', $traces[1]->traceId());
        $this->assertEquals('3', $traces[2]->traceId());
    }

    public function testListsTracesNoneFound()
    {
        $this->connection->listTraces(Argument::any())->willReturn([]);

        $this->client->setConnection($this->connection->reveal());
        $traces = iterator_to_array($this->client->traces());

        $this->assertEquals([], $traces);
    }

    public function testGetSingleTrace()
    {
        $this->connection->getTrace(Argument::any())->willReturn([
            'projectId' => 'project',
            'traceId' => '1',
            'spans' => [
                ['name' => 'main']
            ]
        ]);
        $this->client->setConnection($this->connection->reveal());

        $trace = $this->client->trace('1');
        $trace->reload();
        $this->assertEquals('1', $trace->traceId());
        $this->assertEquals(1, count($trace->spans()));
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testGetSingleTraceNotFound()
    {
        $this->connection->getTrace(Argument::any())->willReturn([]);
        $this->client->setConnection($this->connection->reveal());

        $trace = $this->client->trace('1');
        $trace->info();
    }

    public function testInsertTrace()
    {
        $this->connection->patchTraces(Argument::any())->willReturn([
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
        $this->client->setConnection($this->connection->reveal());

        $trace = new Trace($this->connection->reveal(), 'project', '1', [
                ['name' => 'main']
            ]
        );
        $this->assertTrue($this->client->insert($trace));
    }

    public function testInsertMultipleTraces()
    {
        $this->connection->patchTraces(Argument::any())->willReturn([
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
        $this->client->setConnection($this->connection->reveal());

        $trace = new Trace($this->connection->reveal(), 'project', '1', [
                ['name' => 'main']
            ]
        );
        $this->assertTrue($this->client->insertBatch([$trace]));
    }

}

class TraceTestClient extends TraceClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
