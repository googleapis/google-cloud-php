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

namespace Google\Cloud\Tests\Snippets\Debugger;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\SourceLocation;
use Google\Cloud\Debugger\StackFrame;
use Google\Cloud\Debugger\VariableTable;

/**
 * @group debugger
 */
class BreakpointTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(Breakpoint::class);
        $res = $snippet->invoke('breakpoint');
        $this->assertInstanceOf(Breakpoint::class, $res->returnVal());
    }

    public function testId()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'id');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertEquals('breakpoint1', $res->output());
    }

    public function testAction()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'action');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertEquals(Breakpoint::ACTION_CAPTURE, $res->output());
    }

    public function testLocation()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1', 'location' => ['path' => '/path', 'line' => 10]]);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'location');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('location');
        $this->assertInstanceOf(SourceLocation::class, $res->returnVal());
    }

    public function testCondition()
    {
        $breakpoint = new Breakpoint(['condition' => '1 == 2']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'condition');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertEquals('1 == 2', $res->output());
    }

    public function testLogLevel()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'logLevel');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertEquals(Breakpoint::LOG_LEVEL_INFO, $res->output());
    }

    public function testLogMessageFormat()
    {
        $breakpoint = new Breakpoint(['logMessageFormat' => 'message format']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'logMessageFormat');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertEquals('message format', $res->output());
    }

    public function testExpressions()
    {
        $breakpoint = new Breakpoint(['expressions' => ['2 + 3']]);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'expressions');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('expressions');
        $this->assertEquals(['2 + 3'], $res->returnVal());
    }

    public function testStackFrames()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'stackFrames');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('stackFrames');
        $this->assertEquals([], $res->returnVal());
    }

    public function testVariableTable()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'variableTable');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('variableTable');
        $this->assertInstanceOf(VariableTable::class, $res->returnVal());
    }

    public function testFinalize()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'finalize');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertInstanceOf(Breakpoint::class, $res->returnVal());
    }

    public function testAddStackFrames()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'addStackFrames');
        $snippet->addLocal('breakpoint', $breakpoint);

        $stackFrames = $snippet->invoke('stackFrames')->returnVal();
        $this->assertCount(1, $stackFrames);
        foreach ($stackFrames as $stackFrame) {
            $this->assertInstanceOf(StackFrame::class, $stackFrame);
        }
    }

    public function testAddStackFrame()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'addStackFrame');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('stackFrames');
        $stackFrames = $res->returnVal();
        $this->assertCount(1, $stackFrames);
        foreach ($stackFrames as $stackFrame) {
            $this->assertInstanceOf(StackFrame::class, $stackFrame);
        }
    }

    public function testAddEvaluatedExpressions()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'addEvaluatedExpressions');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('breakpoint');
        $this->assertInstanceOf(Breakpoint::class, $res->returnVal());
    }

    public function testValidate()
    {
        $breakpoint = new Breakpoint(['id' => 'breakpoint1']);
        $snippet = $this->snippetFromMethod(Breakpoint::class, 'validate');
        $snippet->addLocal('breakpoint', $breakpoint);

        $res = $snippet->invoke('valid');
    }
}
