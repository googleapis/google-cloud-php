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

use Google\Cloud\Debugger\Action;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\SourceLocation;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class BreakpointTest extends TestCase
{
    use JsonTestTrait;

    public function testCreateFromJson()
    {
        $input = [
            'id' => 'breakpointid',
            'action' => 'CAPTURE',
            'location' => [
                'path' => '/path/to/file.php',
                'line' => 45
            ],
            'createTime' => '2017-09-20T16:29:28.001Z',
            'userEmail' => 'debugger@google.com',
            'variableTable' => []
        ];

        $breakpoint = new Breakpoint($input);
        $this->assertEquals('breakpointid', $breakpoint->id());
        $this->assertEquals(Breakpoint::ACTION_CAPTURE, $breakpoint->action());
        $this->assertInstanceOf(SourceLocation::class, $breakpoint->location());
        $this->assertEquals('/path/to/file.php', $breakpoint->location()->path());
        $this->assertEquals(45, $breakpoint->location()->line());

        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testParsesConditionFromJson()
    {
        $input = [
            'condition' => '$foo == "bar"',
            'variableTable' => []
        ];

        $breakpoint = new Breakpoint($input);
        $this->assertEquals('$foo == "bar"', $breakpoint->condition());

        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testParsesExpressionsFromJson()
    {
        $input = [
            'expressions' => [
                '$foo',
                '2 + 3'
            ],
            'variableTable' => []
        ];

        $breakpoint = new Breakpoint($input);
        $this->assertCount(2, $breakpoint->expressions());
        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testDefaultsLogLevel()
    {
        $breakpoint = new Breakpoint();
        $this->assertEquals(Breakpoint::LOG_LEVEL_INFO, $breakpoint->logLevel());
    }

    public function testParsesLogLevel()
    {
        $input = [
            'logLevel' => Breakpoint::LOG_LEVEL_ERROR,
            'variableTable' => []
        ];
        $breakpoint = new Breakpoint($input);
        $this->assertEquals(Breakpoint::LOG_LEVEL_ERROR, $breakpoint->logLevel());
        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testParsesLogMessageFormat()
    {
        $input = [
            'logMessageFormat' => 'some log message',
            'variableTable' => []
        ];
        $breakpoint = new Breakpoint($input);
        $this->assertEQuals('some log message', $breakpoint->logMessageFormat());
        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testFinalizeSetsFinalStateAndTime()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->finalize();
        $info = $breakpoint->jsonSerialize();

        $this->assertArrayHasKey('finalTime', $info);
        $this->assertArrayHasKey('isFinalState', $info);
        $this->assertTrue($info['isFinalState']);
    }

    public function testAddingStackFrame()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->addStackFrame([
            'function' => 'testFunc',
            'filename' => 'foo.php',
            'line' => 10
        ]);
        $this->assertCount(1, $breakpoint->stackFrames());
        $this->assertCount(0, $breakpoint->variableTable()->variables());
    }

    public function testAddingStackFrameWithLocals()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->addStackFrame([
            'function' => 'testFunc',
            'filename' => 'foo.php',
            'line' => 10,
            'locals' => [
                ['name' => 'foo', 'value' => 'bar']
            ]
        ]);
        $this->assertCount(1, $breakpoint->stackFrames());
        $this->assertCount(0, $breakpoint->variableTable()->variables());
    }

    public function testAddingStackFrameWithObjectLocalsAddsToVariableTable()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->addStackFrame([
            'function' => 'testFunc',
            'filename' => 'foo.php',
            'line' => 10,
            'locals' => [
                ['name' => 'foo', 'value' => new Breakpoint()]
            ]
        ]);
        $this->assertCount(1, $breakpoint->stackFrames());
        $this->assertCount(1, $breakpoint->variableTable()->variables());
    }

    public function testAddingEvaluatedExpressions()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->addEvaluatedExpressions([
            '2 + 3' => 5,
            'false' => false
        ]);
        $json = $breakpoint->jsonSerialize();
        $this->assertArrayHasKey('evaluatedExpressions', $json);
        $this->assertCount(2, $json['evaluatedExpressions']);
    }
}
