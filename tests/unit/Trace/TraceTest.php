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
use Google\Cloud\Trace\TraceSpan;

/**
 * @group trace
 */
class TraceTest extends \PHPUnit_Framework_TestCase
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
            $this->connection->reveal(),
            'myproject',
            '1234abcd',
            [
                [
                    'spanId' => '12345',
                    'kind' => 'SPAN_KIND_UNSPECIFIED',
                    'name' => 'spanname',
                    'startTime' => '2017-03-28T21:44:10.484299000Z',
                    'endTime' => '2017-03-28T21:44:11.123456000Z'
                ]
            ]
        );
        $this->assertEquals('1234abcd', $trace->traceId());
        $this->assertEquals(1, count($trace->spans()));
        foreach($trace->spans() as $span) {
            $this->assertInstanceOf(TraceSpan::class, $span);
        }
    }

    public function testGeneratesDefaultTraceId()
    {
        $trace = new Trace($this->connection->reveal(), 'myproject');
        $this->assertRegExp('/^[0-9a-f]{32}$/', $trace->traceId());
    }

    public function testBuildsSpan()
    {
        $trace = new Trace($this->connection->reveal(), 'myproject');
        $span = $trace->span(['name' => 'myspan']);
        $this->assertInstanceOf(TraceSpan::class, $span);
        $this->assertEquals('myspan', $span->name());
    }

    public function testLazyLoadsSpans()
    {
        $this->connection->getTrace(['projectId' => 'myproject', 'traceId' => '1'])->willReturn([
            'projectId' => 'myproject',
            'traceId' => '1',
            'spans' => [
                ['name' => 'main']
            ]
        ])->shouldBeCalled();
        $trace = new Trace($this->connection->reveal(), 'myproject', '1');
        $trace->info();
    }

    public function testSpecifyingSpansSkipsTraceGetCall()
    {
        $trace = new Trace($this->connection->reveal(), 'myproject', '1', [['name' => 'main']]);
        $trace->info();
    }
}
