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

namespace Google\Cloud\Tests\Unit\Trace\Reporter;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Reporter\SyncReporter;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;
use Google\Cloud\Trace\Tracer\TracerInterface;
use Prophecy\Argument;

/**
 * @group trace
 */
class SyncReporterTest extends \PHPUnit_Framework_TestCase
{
    private $tracer;
    private $connection;
    private $client;

    public function setUp()
    {
        $this->client = new TraceTestClient(['projectId' => 'project']);
        $this->tracer = $this->prophesize(TracerInterface::class);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testReportsTrace()
    {
        $spans = [
            new TraceSpan([
                'name' => 'span',
                'startTime' => microtime(true),
                'endTime' => microtime(true) + 10
            ])
        ];
        $this->tracer->context()->willReturn(new TraceContext('testtraceid'));
        $this->tracer->spans()->willReturn($spans);

        $this->connection->patchTraces(Argument::any())->willReturn(true);
        $this->client->setConnection($this->connection->reveal());

        $reporter = new SyncReporter($this->client);
        $this->assertTrue($reporter->report($this->tracer->reveal()));
    }

    public function testSkipsReportingWhenNoSpans()
    {
        $this->tracer->spans()->willReturn([]);

        $reporter = new SyncReporter($this->client);
        $this->assertFalse($reporter->report($this->tracer->reveal()));
    }

    public function testHandlesServiceFailure()
    {
        $spans = [
            new TraceSpan([
                'name' => 'span',
                'startTime' => microtime(true),
                'endTime' => microtime(true) + 10
            ])
        ];
        $this->tracer->context()->willReturn(new TraceContext('testtraceid'));
        $this->tracer->spans()->willReturn($spans);

        $this->connection->patchTraces(Argument::any())->willThrow(new ServiceException('An error occurred'));
        $this->client->setConnection($this->connection->reveal());

        $reporter = new SyncReporter($this->client);
        $this->assertFalse($reporter->report($this->tracer->reveal()));
    }
}

class TraceTestClient extends TraceClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
