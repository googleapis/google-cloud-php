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

use Google\Cloud\Trace\Reporter\FileReporter;
use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;
use Google\Cloud\Trace\Tracer\TracerInterface;

/**
 * @group trace
 */
class FileReporterTest extends \PHPUnit_Framework_TestCase
{
    private $tracer;
    private $filename;

    public function setUp()
    {
        $this->filename = tempnam(sys_get_temp_dir(), 'traces');
        $this->tracer = $this->prophesize(TracerInterface::class);
    }

    public function tearDown()
    {
        @unlink($this->filename);
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

        $reporter = new FileReporter($this->filename);
        $this->assertTrue($reporter->report($this->tracer->reveal()));
        $this->assertGreaterThan(0, strlen(@file_get_contents($this->filename)));
    }
}
