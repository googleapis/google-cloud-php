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
use Google\Cloud\Debugger\StackFrame;
use Google\Cloud\Debugger\Variable;

/**
 * @group debugger
 */
class StackFrameTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(StackFrame::class);
        $res = $snippet->invoke('stackFrame');
        $this->assertInstanceOf(StackFrame::class, $res->returnVal());
    }

    public function testFromJson()
    {
        $snippet = $this->snippetFromMethod(StackFrame::class, 'fromJson');
        $snippet->addUse(StackFrame::class);
        $res = $snippet->invoke('stackFrame');
        $this->assertInstanceOf(StackFrame::class, $res->returnVal());
    }

    public function testAddLocal()
    {
        $variable = new Variable('varName', 'string');
        $stackFrame = StackFrame::fromJson([]);
        $snippet = $this->snippetFromMethod(StackFrame::class, 'addLocal');
        $snippet->addLocal('variable', $variable);
        $snippet->addLocal('stackFrame', $stackFrame);
        $res = $snippet->invoke('stackFrame');
        $this->assertInstanceOf(StackFrame::class, $res->returnVal());
    }
}
