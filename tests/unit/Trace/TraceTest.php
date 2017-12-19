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
use Google\Cloud\Trace\Span;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class TraceTest extends TestCase
{
    /** @var ConnectionInterface|ObjectProphecy */
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testLoadFromArray()
    {
        $trace = new Trace(
            'myproject',
            '1234abcd',
            [
                [
                    'spanId' => '12345',
                    'name' => 'spanname',
                    'startTime' => '2017-03-28T21:44:10.484299000Z',
                    'endTime' => '2017-03-28T21:44:11.123456000Z'
                ]
            ]
        );
        $this->assertEquals('1234abcd', $trace->traceId());
        $this->assertCount(1, $trace->spans());
        foreach($trace->spans() as $span) {
            $this->assertInstanceOf(Span::class, $span);
        }
    }

    public function testGeneratesDefaultTraceId()
    {
        $trace = new Trace('myproject');
        $this->assertRegExp('/^[0-9a-f]{32}$/', $trace->traceId());
    }

    public function testBuildsSpan()
    {
        $trace = new Trace('myproject');
        $span = $trace->span(['name' => 'myspan']);
        $this->assertInstanceOf(Span::class, $span);
        $this->assertEquals('myspan', $span->name());
    }
}
