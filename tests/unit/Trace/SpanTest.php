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

use Google\Cloud\Trace\Span;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class SpanTest extends TestCase
{
    const EXPECTED_TIMESTAMP_FORMAT = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{9}Z$/';

    public function testGeneratesDefaultSpanId()
    {
        $traceSpan = new Span();
        $info = $traceSpan->info();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertRegExp('/^\d+$/', $info['spanId']);
        $this->assertEquals($info['spanId'], $traceSpan->spanId());
    }

    public function testReadsSpanId()
    {
        $traceSpan = new Span(['spanId' => '1234']);
        $info = $traceSpan->info();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertEquals('1234', $info['spanId']);
    }

    public function testReadsLabels()
    {
        $traceSpan = new Span(['labels' => ['foo' => 'bar']]);
        $info = $traceSpan->info();
        $this->assertArrayHasKey('labels', $info);
        $this->assertEquals('bar', $info['labels']['foo']);
    }

    public function testCanAddLabel()
    {
        $traceSpan = new Span();
        $traceSpan->addLabel('foo', 'bar');
        $info = $traceSpan->info();
        $this->assertArrayHasKey('labels', $info);
        $this->assertEquals('bar', $info['labels']['foo']);
    }

    public function testNoLabels()
    {
        $traceSpan = new Span();
        $info = $traceSpan->info();
        $this->assertArrayNotHasKey('labels', $info);
    }

    public function testEmptyLabels()
    {
        $traceSpan = new Span(['labels' => []]);
        $info = $traceSpan->info();
        $this->assertArrayNotHasKey('labels', $info);
    }

    public function testGeneratesDefaultSpanName()
    {
        $traceSpan = new Span();
        $info = $traceSpan->info();
        $this->assertArrayHasKey('name', $info);
        $this->assertStringStartsWith('app', $info['name']);
        $this->assertEquals($info['name'], $traceSpan->name());
    }

    public function testReadsName()
    {
        $traceSpan = new Span(['name' => 'myspan']);
        $info = $traceSpan->info();
        $this->assertArrayHasKey('name', $info);
        $this->assertEquals('myspan', $info['name']);
    }

    public function testStartFormat()
    {
        $traceSpan = new Span();
        $traceSpan->setStart();
        $info = $traceSpan->info();
        $this->assertArrayHasKey('startTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['startTime']);
    }

    public function testFinishFormat()
    {
        $traceSpan = new Span();
        $traceSpan->setEnd();
        $info = $traceSpan->info();
        $this->assertArrayHasKey('endTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['endTime']);
    }

    public function testGeneratesDefaultKind()
    {
        $traceSpan = new Span();
        $info = $traceSpan->info();
        $this->assertArrayHasKey('kind', $info);
        $this->assertEquals(Span::SPAN_KIND_UNSPECIFIED, $info['kind']);
    }

    public function testReadsKind()
    {
        $traceSpan = new Span(['kind' => Span::SPAN_KIND_RPC_CLIENT]);
        $info = $traceSpan->info();
        $this->assertArrayHasKey('kind', $info);
        $this->assertEquals(Span::SPAN_KIND_RPC_CLIENT, $info['kind']);
    }

    public function testIgnoresUnknownFields()
    {
        $traceSpan = new Span(['extravalue' => 'something']);
        $info = $traceSpan->info();
        $this->assertArrayNotHasKey('extravalue', $info);
    }

    /**
     * @dataProvider timestampFields
     */
    public function testCanFormatTimestamps($field, $timestamp, $expected)
    {
        $traceSpan = new Span([$field => $timestamp]);
        $this->assertEquals($expected, $traceSpan->info()[$field]);
    }

    public function timestampFields()
    {
        return [
            ['startTime', 1490737410, '2017-03-28T21:43:30.000000000Z'],
            ['startTime', 1490737450.4843, '2017-03-28T21:44:10.484299000Z'],
            ['startTime', '2017-03-28T21:44:10.484299000Z', '2017-03-28T21:44:10.484299000Z'],
            ['endTime', 1490737410, '2017-03-28T21:43:30.000000000Z'],
            ['endTime', 1490737450.4843, '2017-03-28T21:44:10.484299000Z'],
            ['endTime', '2017-03-28T21:44:10.484299000Z', '2017-03-28T21:44:10.484299000Z'],
        ];
    }
}
