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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Tests\GrpcTestTrait;

/**
 * @group spanner
 */
class BytesTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    private $content = 'hello';

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
    }

    public function testGet()
    {
        $bytes = new Bytes($this->content);
        $this->assertEquals($this->content, $bytes->get());
    }

    public function testFormatAsString()
    {
        $bytes = new Bytes($this->content);
        $this->assertEquals(base64_encode($this->content), $bytes->formatAsString());
    }

    public function testCast()
    {
        $bytes = new Bytes($this->content);
        $this->assertEquals(base64_encode($this->content), (string) $bytes);
    }

    public function testType()
    {
        $bytes = new Bytes($this->content);
        $this->assertTrue(is_integer($bytes->type()));
    }
}
