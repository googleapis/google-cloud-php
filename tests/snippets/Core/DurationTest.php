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

use Google\Cloud\Core\Duration;
use Google\Cloud\Dev\Snippet\SnippetTestCase;

/**
 * @group core
 */
class DurationTest extends SnippetTestCase
{
    const SECONDS = 1;
    const NANOS = 2;

    private $duration;

    public function setUp()
    {
        $this->duration = new Duration(self::SECONDS, self::NANOS);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Duration::class);
        $res = $snippet->invoke('duration');
        $this->assertInstanceOf(Duration::class, $res->returnVal());
    }

    public function testClassCast()
    {
        $snippet = $this->snippetFromClass(Duration::class, 1);
        $snippet->addLocal('duration', $this->duration);

        $res = $snippet->invoke();
        $this->assertEquals($this->duration->formatAsString(), $res->output());
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Duration::class, 'get');
        $snippet->addLocal('duration', $this->duration);

        $res = $snippet->invoke('res');
        $this->assertEquals($this->duration->get(), $res->returnVal());
    }

    public function testFormatAsString()
    {
        $snippet = $this->snippetFromMethod(Duration::class, 'formatAsString');
        $snippet->addLocal('duration', $this->duration);

        $res = $snippet->invoke();
        $this->assertEquals($this->duration->formatAsString(), $res->output());
    }
}
