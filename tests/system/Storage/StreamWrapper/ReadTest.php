<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\System\Storage\StreamWrapper;

/**
 * @group storage
 * @group streamWrapper
 */
class ReadTest extends StreamWrapperTestCase
{
    private $file;

    public function setUp()
    {
        $this->file = self::generateUrl(self::$object->name());
    }

    public function testFread()
    {
        $fd = fopen($this->file, 'r');
        $expected = 'somedata';
        $this->assertEquals($expected, fread($fd, strlen($expected)));
        $this->assertTrue(fclose($fd));
    }

    public function testFileGetContents()
    {
        $this->assertEquals('somedata', file_get_contents($this->file));
    }

    public function testGetLines()
    {
        $fd = fopen($this->file, 'r');
        $expected = 'somedata';
        $this->assertEquals($expected, fgets($fd));
        $this->assertTrue(fclose($fd));
    }

    public function testEof()
    {
        $fd = fopen($this->file, 'r');
        $this->assertFalse(feof($fd));
        fread($fd, 1000);
        $this->assertTrue(feof($fd));
        $this->assertTrue(fclose($fd));
    }

}
