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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\SourceLocation;
use Google\Cloud\Debugger\StackFrame;
use Google\Cloud\Debugger\Variable;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class StackFrameTest extends TestCase
{
    use JsonTestTrait;

    public function testSerializes()
    {
        $stackFrame = new StackFrame('function', new SourceLocation('path', 10));
        $expected = [
            'function' => 'function',
            'location' => [
                'path' => 'path',
                'line' => 10
            ],
            'arguments' => [],
            'locals' => []
        ];
        $this->assertProducesEquivalentJson($expected, $stackFrame);
    }

    public function testAddLocal()
    {
        $stackFrame = new StackFrame('function', new SourceLocation('path', 10));
        $stackFrame->addLocal(new Variable('foo', 'string', ['value' => 'bar']));
        $expected = [
            'function' => 'function',
            'location' => [
                'path' => 'path',
                'line' => 10
            ],
            'arguments' => [],
            'locals' => [
                ['name' => 'foo', 'type' => 'string', 'value' => 'bar']
            ]
        ];
        $this->assertProducesEquivalentJson($expected, $stackFrame);
    }
}
