<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Debugger\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\SourceLocation;
use Google\Cloud\Debugger\SourceLocationResolver;

/**
 * @group debugger
 */
class SourceLocationResolverTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(SourceLocationResolver::class);
        $snippet->addUse(SourceLocation::class);
        $snippet->addUse(SourceLocationResolver::class);
        $res = $snippet->invoke('resolvedLocation');
        $this->assertInstanceOf(SourceLocation::class, $res->returnVal());
    }

    public function testResolveCase1()
    {
        $snippet = $this->snippetFromMethod(SourceLocationResolver::class, 'resolve');
        $snippet->addUse(SourceLocation::class);
        $snippet->addUse(SourceLocationResolver::class);
        $res = $snippet->invoke('resolvedLocation');
        $this->assertInstanceOf(SourceLocation::class, $res->returnVal());
    }

    public function testResolveCase2()
    {
        $snippet = $this->snippetFromMethod(SourceLocationResolver::class, 'resolve');
        $snippet->addUse(SourceLocation::class);
        $snippet->addUse(SourceLocationResolver::class);
        $res = $snippet->invoke('resolvedLocation');
        $this->assertInstanceOf(SourceLocation::class, $res->returnVal());
    }

    public function testResolveCase3()
    {
        $snippet = $this->snippetFromMethod(SourceLocationResolver::class, 'resolve');
        $snippet->addUse(SourceLocation::class);
        $snippet->addUse(SourceLocationResolver::class);
        $res = $snippet->invoke('resolvedLocation');
        $this->assertInstanceOf(SourceLocation::class, $res->returnVal());
    }
}
