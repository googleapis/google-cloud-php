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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\JsonTrait;

/**
 * @group core
 */
class JsonTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;

    public function setUp()
    {
        $this->implementation = \Google\Cloud\Dev\impl(JsonTrait::class);
    }

    public function testJsonEncode()
    {
        $this->assertEquals('10', $this->implementation->call('jsonEncode', [10]));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJsonEncodeThrowsException()
    {
        $this->implementation->call('jsonEncode', [fopen('php://temp', 'r')]);
    }

    public function testJsonDecode()
    {
        $this->assertEquals(10, $this->implementation->call('jsonDecode', ['10']));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJsonDecodeThrowsException()
    {
        $this->implementation->call('jsonDecode', ['.|.']);
    }
}
