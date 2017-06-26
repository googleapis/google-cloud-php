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

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Trace\Reporter\AsyncReporter;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;
use Google\Cloud\Trace\Trace;
use Google\Cloud\Trace\Tracer\TracerInterface;
use Prophecy\Argument;

/**
 * @group trace
 */
class AsyncReporterTest extends \PHPUnit_Framework_TestCase
{
    private $runner;
    private $tracer;

    public function setUp()
    {
        $this->runner = $this->prophesize(BatchRunner::class);
        $this->tracer = $this->prophesize(TracerInterface::class);

        $this->runner->registerJob(
            Argument::type('string'),
            Argument::type('array'),
            Argument::type('array')
        )->willReturn(true);
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

        $this->runner->submitItem(Argument::type('string'), Argument::type('array'))
            ->willReturn(true);

        $reporter = new AsyncReporter([
            'batchRunner' => $this->runner->reveal()
        ]);
        $this->assertTrue($reporter->report($this->tracer->reveal()));
    }

    public function testSkipsReportingWhenNoSpans()
    {
        $this->tracer->spans()->willReturn([]);

        $reporter = new AsyncReporter([
            'batchRunner' => $this->runner->reveal()
        ]);
        $this->assertFalse($reporter->report($this->tracer->reveal()));
    }

    public function testCallback()
    {
        $client = $this->prophesize(TraceClient::class);
        $reporter = new TestAsyncReporter([
            'batchRunner' => $this->runner->reveal()
        ]);
        $trace1 = $this->prophesize(Trace::class);
        $trace2 = $this->prophesize(Trace::class);
        $trace1->setSpans(Argument::any())->shouldBeCalled();
        $trace2->setSpans(Argument::any())->shouldBeCalled();

        $client->insertBatch([$trace1, $trace2])->willReturn(true);
        $client->trace('trace1')->willReturn($trace1)->shouldBeCalled();
        $client->trace('trace2')->willReturn($trace2)->shouldBeCalled();

        $reporter->setClient($client->reveal());
        $entries = [
            [
                'traceId' => 'trace1',
                'spans' => [[
                    'name' => 'main',
                    'spanId' => '012345',
                    'startTime' => '2017-03-28T21:44:10.484299000Z',
                    'endTime' => '2017-03-28T21:44:10.625299000Z'
                ]]
            ],
            [
                'traceId' => 'trace2',
                'spans' => [[
                    'name' => 'main',
                    'spanId' => '234567',
                    'startTime' => '2017-03-28T21:44:10.484299000Z',
                    'endTime' => '2017-03-28T21:44:10.625299000Z'
                ]]
            ]
        ];

        $reporter->sendEntries($entries);
    }
}

class TestAsyncReporter extends AsyncReporter
{
    public function setClient($client)
    {
        self::$client = $client;
    }
}
