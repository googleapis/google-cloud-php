<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Storage\Tests\System\StreamWrapper;

use Google\Cloud\Storage\StreamWrapper;

/**
 * @group storage
 * @group storage-stream-wrapper
 * @group storage-stream-wrapper-append
 */
class AppendTest extends StreamWrapperTestCase
{
    private static $fileName = 'append.txt';
    private $fileUrl;
    private $tailFileUrl;

    public function set_up()
    {
        $this->fileUrl = self::generateUrl(self::$fileName);
        $this->tailFileUrl = $this->fileUrl . StreamWrapper::TAIL_NAME_SUFFIX;
    }

    public static function tear_down_after_class()
    {
        $url = static::generateUrl(self::$fileName);
        unlink($url);
        unlink($url . StreamWrapper::TAIL_NAME_SUFFIX);
    }

    public function testNonExistent()
    {
        unlink($this->fileUrl);
        unlink($this->tailFileUrl);
        $content = 'hello';
        $f = fopen($this->fileUrl, 'a');
        $this->assertEquals(strlen($content), fwrite($f, $content));
        fclose($f);
        $this->assertTrue(file_exists($this->fileUrl));
        $this->assertFalse(file_exists($this->tailFileUrl));
        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertEquals(strlen($content), $info['size']);
        $this->assertArrayNotHasKey('componentCount', $info);
        $this->assertEquals($content, file_get_contents($this->fileUrl));
    }

    /**
     * @depends testNonExistent
     */
    public function testSimple()
    {
        $append = ' world';
        $content = 'hello' . $append;
        $f = fopen($this->fileUrl, 'a');
        $this->assertEquals(strlen($append), fwrite($f, $append));
        fclose($f);
        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertEquals(strlen($content), $info['size']);
        $this->assertArrayHasKey('componentCount', $info);
        $this->assertEquals(2, $info['componentCount']);
        $this->assertEquals($content, file_get_contents($this->fileUrl));
        $this->assertFalse(file_exists($this->tailFileUrl));
    }

    /**
     * @depends testSimple
     */
    public function testComposed()
    {
        $append = '!';
        $content = 'hello world' . $append;
        $f = fopen($this->fileUrl, 'a');
        $this->assertEquals(strlen($append), fwrite($f, $append));
        fclose($f);
        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertEquals(strlen($content), $info['size']);
        $this->assertArrayHasKey('componentCount', $info);
        $this->assertEquals(3, $info['componentCount']);
        $this->assertEquals($content, file_get_contents($this->fileUrl));
        $this->assertFalse(file_exists($this->tailFileUrl));
    }
}
