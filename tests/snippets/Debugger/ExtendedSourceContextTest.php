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
use Google\Cloud\Debugger\ExtendedSourceContext;
use Google\Cloud\Debugger\SourceContext;

/**
 * @group debugger
 */
class ExtendedSourceContextTest extends SnippetTestCase
{
    public function testClass()
    {
        $sourceContext = new TestSourceContext();
        $snippet = $this->snippetFromClass(ExtendedSourceContext::class);
        $snippet->addLocal('sourceContext', $sourceContext);
        $res = $snippet->invoke('extendedSourceContext');
        $this->assertInstanceOf(ExtendedSourceContext::class, $res->returnVal());
    }

    public function testContext()
    {
        $sourceContext = new TestSourceContext();
        $extendedSourceContext = new ExtendedSourceContext($sourceContext, []);
        $snippet = $this->snippetFromMethod(ExtendedSourceContext::class, 'context');
        $snippet->addLocal('extendedSourceContext', $extendedSourceContext);
        $res = $snippet->invoke('context');
        $this->assertEquals($sourceContext, $res->returnVal());
    }
}

class TestSourceContext implements SourceContext
{
    public function contextData()
    {
        return [
            'context' => 'test'
        ];
    }
}
