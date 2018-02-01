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

use Google\Cloud\Trace\StackTrace;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class StackTraceTest extends TestCase
{
    public function testCreateFromBacktrace()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $stackTrace = new StackTrace($backtrace);
        $data = $stackTrace->jsonSerialize();
        $this->assertStackFramesJsonFormat($data);
    }

    public function testCreateWithClosure()
    {
        $backtrace = call_user_func(function () {
            return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        });
        $stackTrace = new StackTrace($backtrace);
        $data = $stackTrace->jsonSerialize();
        $this->assertStackFramesJsonFormat($data);
    }

    private function assertStackFramesJsonFormat($data)
    {
        $this->assertArrayHasKey('stackFrames', $data);
        $this->assertArrayHasKey('frame', $data['stackFrames']);
        $frames = $data['stackFrames']['frame'];
        foreach ($frames as $frame) {
            $this->assertStackFrameJsonFormat($frame);
        }
    }

    private function assertStackFrameJsonFormat($sf)
    {
        $this->assertEmpty(array_diff(array_keys($sf), ['lineNumber', 'fileName', 'functionName']));
        if (array_key_exists('fileName', $sf)) {
            $this->assertArrayHasKey('value', $sf['fileName']);
        }
        if (array_key_exists('functionName', $sf)) {
            $this->assertArrayHasKey('value', $sf['functionName']);
        }
    }
}
