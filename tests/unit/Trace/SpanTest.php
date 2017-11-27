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
    const PROJECT_ID = 'test_project_id';
    const TRACE_ID = 'abcd1234';

    public function testGeneratesDefaultSpanId()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertRegExp('/^[0-9a-f]{16}$/', $info['spanId']);
        $this->assertEquals($info['spanId'], $traceSpan->spanId());
    }

    public function testReadsSpanId()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, ['spanId' => '1234']);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertEquals('1234', $info['spanId']);
    }

    public function testReadsLabels()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, ['attributes' => ['foo' => 'bar']]);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testCanAddLabel()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $traceSpan->addAttribute('foo', 'bar');
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testNoLabels()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayNotHasKey('attributes', $info);
    }

    public function testEmptyLabels()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, ['attributes' => []]);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayNotHasKey('attributes', $info);
    }

    public function testGeneratesDefaultSpanName()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $this->assertStringStartsWith('app', $traceSpan->name());
    }

    public function testReadsName()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, ['name' => 'myspan']);
        $this->assertEquals('myspan', $traceSpan->name());
    }

    public function testStartFormat()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $traceSpan->setStartTime();
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('startTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['startTime']);
    }

    public function testFinishFormat()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID);
        $traceSpan->setEndTime();
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayHasKey('endTime', $info);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $info['endTime']);
    }

    public function testIgnoresUnknownFields()
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, ['extravalue' => 'something']);
        $info = $traceSpan->jsonSerialize();
        $this->assertArrayNotHasKey('extravalue', $info);
    }

    /**
     * @dataProvider timestampFields
     */
    public function testCanFormatTimestamps($field, $timestamp, $expected)
    {
        $traceSpan = new Span(self::PROJECT_ID, self::TRACE_ID, [$field => $timestamp]);
        $this->assertEquals($expected, $traceSpan->jsonSerialize()[$field]);
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
