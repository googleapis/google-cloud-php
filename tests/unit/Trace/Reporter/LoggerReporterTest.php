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

use Psr\Log\LoggerInterface;
use Google\Cloud\Trace\Reporter\LoggerReporter;
use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;
use Google\Cloud\Trace\Tracer\TracerInterface;
use Prophecy\Argument;

/**
 * @group trace
 */
class LoggerReporterTest extends \PHPUnit_Framework_TestCase
{
    private $tracer;
    private $logger;

    public function setUp()
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->tracer = $this->prophesize(TracerInterface::class);
    }

    public function testLogsTrace()
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

        $this->logger->log('some-level', Argument::type('string'))->shouldBeCalled();

        $reporter = new LoggerReporter($this->logger->reveal(), 'some-level');
        $this->assertTrue($reporter->report($this->tracer->reveal()));
    }
}
