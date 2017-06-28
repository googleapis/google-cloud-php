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
        $traceId = 'testtraceid';
        $this->tracer->context()->willReturn(new TraceContext($traceId));
        $this->tracer->spans()->willReturn($spans);
        $this->runner->submitItem(Argument::type('string'), Argument::type(Trace::class))
            ->willReturn(true);
        $trace = $this->prophesize(Trace::class);
        $trace->setSpans(Argument::any())->shouldBeCalled();
        $client = $this->prophesize(TraceClient::class);
        $client->insertBatch([$trace])->willReturn(true);
        $client->trace($traceId)->willReturn($trace)->shouldBeCalled();

        $reporter = new AsyncReporter([
            'client' => $client->reveal(),
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

    public function testGetCallback()
    {
        $callbackArray = (new TestAsyncReporter())
            ->getCallbackArray();

        $this->assertInstanceOf(TraceClient::class, $callbackArray[0]);
        $this->assertEquals('insertBatch', $callbackArray[1]);
    }
}

class TestAsyncReporter extends AsyncReporter
{
    public function getCallbackArray()
    {
        return $this->getCallback();
    }
}
