<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Snippets;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Core\Int64;

/**
 * @group core
 */
class Int64Test extends SnippetTestCase
{
    const VALUE = 1234;

    private $int64;

    public function setUp()
    {
        $this->int64 = new Int64((string)self::VALUE);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Int64::class);
        $snippet->addUse(Int64::class);
        $this->assertInstanceOf(Int64::class, $snippet->invoke('int64')->returnVal());
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Int64::class, 'get');
        $snippet->addLocal('int64', $this->int64);
        $res = $snippet->invoke('value');

        $this->assertEquals((string)self::VALUE, $res->returnVal());
    }
}
