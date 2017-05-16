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

namespace Google\Cloud\Tests\Snippets\Core;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Dev\Snippet\SnippetTestCase;

/**
 * @group core
 */
class TimestampTest extends SnippetTestCase
{
    private $timestamp;

    public function setUp()
    {
        $this->dt = new \DateTime;
        $this->timestamp = new Timestamp($this->dt);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Timestamp::class);
        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testClassCast()
    {
        $snippet = $this->snippetFromClass(Timestamp::class, 1);
        $snippet->addLocal('timestamp', $this->timestamp);

        $res = $snippet->invoke();
        $this->assertEquals((string)$this->timestamp, $res->output());
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Timestamp::class, 'get');
        $snippet->addLocal('timestamp', $this->timestamp);

        $res = $snippet->invoke('dateTime');
        $this->assertEquals($this->dt, $res->returnVal());
    }

    public function testFormatAsString()
    {
        $snippet = $this->snippetFromMethod(Timestamp::class, 'formatAsString');
        $snippet->addLocal('timestamp', $this->timestamp);

        $res = $snippet->invoke('value');
        $this->assertEquals($this->timestamp->formatAsString(), $res->returnVal());
    }
}
