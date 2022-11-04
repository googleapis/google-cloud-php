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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\JsonTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 */
class JsonTraitTest extends TestCase
{
    use ExpectException;

    private $implementation;

    public function set_up()
    {
        $this->implementation = TestHelpers::impl(JsonTrait::class);
    }

    public function testJsonEncode()
    {
        $this->assertEquals('10', $this->implementation->call('jsonEncode', [10]));
    }

    public function testJsonEncodeThrowsException()
    {
        $this->expectException('\InvalidArgumentException');

        $this->implementation->call('jsonEncode', [fopen('php://temp', 'r')]);
    }

    public function testJsonDecode()
    {
        $this->assertEquals(10, $this->implementation->call('jsonDecode', ['10']));
    }

    public function testJsonDecodeThrowsException()
    {
        $this->expectException('\InvalidArgumentException');

        $this->implementation->call('jsonDecode', ['.|.']);
    }
}
