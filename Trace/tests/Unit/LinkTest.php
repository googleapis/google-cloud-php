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

use Google\Cloud\Trace\Link;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class LinkTest extends TestCase
{
    public function testCreateLink()
    {
        $link = new Link('abcd1234', 'abcd2345');

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('type', $info);
        $this->assertEquals(Link::TYPE_UNSPECIFIED, $info['type']);
    }

    public function testAddsAnAttribute()
    {
        $link = new Link('abcd1234', 'abcd2345');
        $link->addAttribute('foo', 'bar');

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testCreatesAnAnnotionWithAttributes()
    {
        $link = new Link('abcd1234', 'abcd2345', [
            'attributes' => [
                'foo' => 'bar'
            ]
        ]);

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testCreatesWithTraceId()
    {
        $link = new Link('some trace id', 'abcd2345');

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('traceId', $info);
        $this->assertEquals('some trace id', $info['traceId']);
    }

    public function testCreatesWithSpanId()
    {
        $link = new Link('abcd1234', 'some span id');

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('spanId', $info);
        $this->assertEquals('some span id', $info['spanId']);
    }

    public function testCreatesWithType()
    {
        $link = new Link('abcd1234', 'abcd2345', [
            'type' => Link::TYPE_CHILD_LINKED_SPAN
        ]);

        $info = $link->jsonSerialize();
        $this->assertArrayHasKey('type', $info);
        $this->assertEquals(Link::TYPE_CHILD_LINKED_SPAN, $info['type']);
    }
}
