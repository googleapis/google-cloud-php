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
    const TRACE_ID = 'abcd1234';

    public function testGeneratesDefaultSpanId()
    {
        $span = new Span(self::TRACE_ID);
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertRegExp('/^[0-9a-f]{16}$/', $info['spanId']);
        $this->assertEquals($info['spanId'], $span->spanId());
    }

    public function testReadsSpanId()
    {
        $span = new Span(self::TRACE_ID, ['spanId' => '1234']);
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertEquals('1234', $info['spanId']);
    }

    public function testReadsAttributes()
    {
        $span = new Span(self::TRACE_ID, ['attributes' => ['foo' => 'bar']]);
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testCanAddAttribute()
    {
        $span = new Span(self::TRACE_ID);
        $span->addAttribute('foo', 'bar');
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testNoAttributes()
    {
        $span = new Span(self::TRACE_ID);
        $info = $span->jsonSerialize();
        $this->assertArrayNotHasKey('attributes', $info);
    }

    public function testEmptyAttributes()
    {
        $span = new Span(self::TRACE_ID, ['attributes' => []]);
        $info = $span->jsonSerialize();
        $this->assertArrayNotHasKey('attributes', $info);
    }

    public function testGeneratesDefaultSpanName()
    {
        $span = new Span(self::TRACE_ID);
        $this->assertStringStartsWith('app', $span->name());
    }

    public function testReadsName()
    {
        $span = new Span(self::TRACE_ID, ['name' => 'myspan']);
        $this->assertEquals('myspan', $span->name());
    }

    public function testSerializedDisplayName()
    {
        $span  = new Span(self::TRACE_ID, ['name' => 'myspan']);
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('displayName', $info);
        $this->assertEquals('myspan', $info['displayName']['value']);
    }

    public function testStartFormat()
    {
        $span = new Span(self::TRACE_ID);
        $span->setStartTime();
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('startTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['startTime']);
    }

    public function testFinishFormat()
    {
        $span = new Span(self::TRACE_ID);
        $span->setEndTime();
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('endTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['endTime']);
    }

    public function testIgnoresUnknownFields()
    {
        $span = new Span(self::TRACE_ID, ['extravalue' => 'something']);
        $info = $span->jsonSerialize();
        $this->assertArrayNotHasKey('extravalue', $info);
    }

    public function testSameProcessAsParentSpan()
    {
        $span = new Span(self::TRACE_ID, ['sameProcessAsParentSpan' => false]);
        $info = $span->jsonSerialize();
        $this->assertArrayHasKey('sameProcessAsParentSpan', $info);
        $this->assertFalse($info['sameProcessAsParentSpan']);
    }

    /**
     * @dataProvider timestampFields
     */
    public function testCanFormatTimestamps($field, $timestamp, $expected)
    {
        $span = new Span(self::TRACE_ID, [$field => $timestamp]);
        $this->assertEquals($expected, $span->jsonSerialize()[$field]);
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
