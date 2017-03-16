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

use Google\Cloud\Trace\Trace;
use Google\Cloud\Trace\TraceSpan;

/**
 * @group trace
 */
class TraceTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFromArray()
    {
        $trace = new Trace('myproject', [
            'traceId' => '1234abcd',
            'spans' => [
                [
                    'spanId' => '12345',
                    'kind' => 'SPAN_KIND_UNSPECIFIED',
                    'name' => 'spanname',
                    'startTime' => '',
                    'endTime' => ''
                ]
            ]
        ]);
        $this->assertEquals('myproject', $trace->projectId());
        $this->assertEquals('1234abcd', $trace->traceId());
        $this->assertEquals(1, count($trace->spans()));
        foreach($trace->spans() as $span) {
            $this->assertInstanceOf(TraceSpan::class, $span);
        }
    }

    public function testGeneratesDefaultTraceId()
    {
        $trace = new Trace('myproject');
        $this->assertRegExp('/^[0-9a-f]{32}$/', $trace->traceId());
    }
}
