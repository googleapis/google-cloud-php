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
use Google\Cloud\Trace\Span;
use Google\Cloud\Trace\Trace;
use Prophecy\Argument;

/**
 * @group trace
 */
class TraceTest extends SnippetTestCase
{
    private $trace;

    public function setUp()
    {
        $this->trace = new Trace('my-project-id', 'abcd1234');
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Trace::class);
        $res = $snippet->invoke('trace');
        $this->assertInstanceOf(Trace::class, $res->returnVal());
    }

    public function testTraceId()
    {
        $snippet = $this->snippetFromMethod(Trace::class, 'traceId');
        $snippet->addLocal('trace', $this->trace);
        $res = $snippet->invoke('trace');
        $this->assertEquals('abcd1234', $res->output());
    }

    public function testSpans()
    {
        $snippet = $this->snippetFromMethod(Trace::class, 'spans');
        $this->trace->setSpans([$this->trace->span(['name' => 'foo'])]);
        $snippet->addLocal('trace', $this->trace);
        $res = $snippet->invoke('spans');
        $this->assertInternalType('array', $res->returnVal());
    }

    public function testSpan()
    {
        $snippet = $this->snippetFromMethod(Trace::class, 'span');
        $snippet->addLocal('trace', $this->trace);
        $res = $snippet->invoke('span');
        $this->assertInstanceOf(Span::class, $res->returnVal());
        $this->assertEquals($this->trace->traceId(), $res->returnVal()->traceId());
    }

    public function testSetSpans()
    {
        $snippet = $this->snippetFromMethod(Trace::class, 'setSpans');
        $snippet->addLocal('trace', $this->trace);
        $snippet->addLocal('span1', $this->trace->span());
        $snippet->addLocal('span2', $this->trace->span());
        $res = $snippet->invoke('trace');
        $this->assertCount(2, $res->returnVal()->spans());
    }
}
