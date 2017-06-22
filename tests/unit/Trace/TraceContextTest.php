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

use Google\Cloud\Trace\TraceContext;

/**
 * @group trace
 */
class TraceContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider traceHeaders
     */
    public function testParseContext($traceId, $spanId, $enabled, $header)
    {
        $context = TraceContext::fromHeaders(['HTTP_X_CLOUD_TRACE_CONTEXT' => $header]);
        $this->assertEquals($traceId, $context->traceId());
        $this->assertEquals($spanId, $context->spanId());
        $this->assertEquals($enabled, $context->enabled());
        $this->assertTrue($context->fromHeader());
    }

    /**
     * @dataProvider traceHeaders
     */
    public function testToString($traceId, $spanId, $enabled, $expected)
    {
        $context = new TraceContext($traceId, $spanId, $enabled);
        $this->assertEquals($expected, (string) $context);
    }

    public function traceHeaders()
    {
        return [
            ['123456789012345678901234567890ab', '1234', false, '123456789012345678901234567890ab/1234;o=0'],
            ['123456789012345678901234567890ab', '1234', true,  '123456789012345678901234567890ab/1234;o=1'],
            ['123456789012345678901234567890ab', null, false,   '123456789012345678901234567890ab;o=0'],
            ['123456789012345678901234567890ab', null, true,    '123456789012345678901234567890ab;o=1'],
        ];
    }
}
