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

namespace Google\Cloud\Tests\Snippets\Trace;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Trace\Annotation;
use Google\Cloud\Trace\Link;
use Google\Cloud\Trace\MessageEvent;
use Google\Cloud\Trace\Span;
use Prophecy\Argument;

/**
 * @group trace
 */
class SpanTest extends SnippetTestCase
{
    const EXPECTED_TIMESTAMP_FORMAT = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{9}Z$/';

    private $span;

    public function setUp()
    {
        $this->span = new Span('abcd1234', ['name' => 'span name']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Span::class);
        $res = $snippet->invoke('span');
        $this->assertInstanceOf(Span::class, $res->returnVal());
    }

    public function testSetStartTime()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setStartTime');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $res->returnVal()->startTime());
    }

    public function testStartTime()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'startTime');
        $this->span->setStartTime(new \DateTime('2017-11-29 11:51:23'));
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('2017-11-29T11:51:23.000000000Z', $res->output());
    }

    public function testSetStartTimeWithValue()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setStartTime', 1);
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('2017-11-29T11:51:23.000000000Z', $res->returnVal()->startTime());
    }

    public function testEndTime()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'endTime');
        $this->span->setEndTime(new \DateTime('2017-11-29 11:51:23'));
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('2017-11-29T11:51:23.000000000Z', $res->output());
    }

    public function testSetEndTime()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setEndTime');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $res->returnVal()->endTime());
    }

    public function testSetEndTimeWithValue()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setEndTime', 1);
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('2017-11-29T11:51:23.000000000Z', $res->returnVal()->endTime());
    }

    public function testSetSpanId()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setSpanId');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('000000001234abcd', $res->returnVal()->spanId());
    }

    public function testSetParentSpanId()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'setParentSpanId');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('000000001234abcd', $res->returnVal()->parentSpanId());
    }

    public function testSpanId()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'spanId');
        $this->span->setSpanId('1234abcd');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('000000001234abcd', $res->output());
    }

    public function testParentSpanId()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'parentSpanId');
        $this->span->setParentSpanId('1234abcd');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('000000001234abcd', $res->output());
    }

    public function testTraceId()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'traceId');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('abcd1234', $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'name');
        $snippet->addLocal('span', $this->span);
        $res = $snippet->invoke('span');
        $this->assertEquals('span name', $res->output());
    }

    public function testAddTimeEvents()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'addTimeEvents');
        $snippet->addLocal('span', $this->span);
        $snippet->addUse(Annotation::class);
        $snippet->addUse(MessageEvent::class);
        $res = $snippet->invoke('span');
    }

    public function testAddTimeEvent()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'addTimeEvent');
        $snippet->addLocal('span', $this->span);
        $snippet->addUse(Annotation::class);
        $res = $snippet->invoke('span');
    }

    public function testAddLinks()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'addLinks');
        $snippet->addLocal('span', $this->span);
        $snippet->addUse(Link::class);
        $res = $snippet->invoke('span');
    }

    public function testAddLink()
    {
        $snippet = $this->snippetFromMethod(Span::class, 'addLink');
        $snippet->addLocal('span', $this->span);
        $snippet->addUse(Link::class);
        $res = $snippet->invoke('span');
    }
}
