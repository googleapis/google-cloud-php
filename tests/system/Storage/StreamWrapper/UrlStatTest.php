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
class UrlStatTest extends StreamWrapperTestCase
{
    protected static $fileUrl;
    protected static $dirUrl;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$fileUrl = self::generateUrl(self::$object->name());
        self::$dirUrl = self::generateUrl('some_folder/');
        mkdir(self::$dirUrl);
    }

    public function testUrlStatFile()
    {
        $stat = stat(self::$fileUrl);
        $this->assertEquals(33206, $stat['mode']);
    }

    public function testUrlStatDirectory()
    {
        $stat = stat(self::$dirUrl);
        $this->assertEquals(16895, $stat['mode']);
    }

    public function testStatOnOpenFileForWrite()
    {
        $fd = fopen(self::$fileUrl, 'w');
        $stat = fstat($fd);
        $this->assertEquals(33206, $stat['mode']);
    }

    public function testStatOnOpenFileForRead()
    {
        $fd = fopen(self::$fileUrl, 'r');
        $stat = fstat($fd);
        $this->assertEquals(33060, $stat['mode']);
    }

    public function testIsWritable()
    {
        $this->assertTrue(is_writable(self::$dirUrl));
        $this->assertTrue(is_writable(self::$fileUrl));
    }

    public function testIsReadable()
    {
        $this->assertTrue(is_readable(self::$dirUrl));
        $this->assertTrue(is_readable(self::$fileUrl));
    }

    public function testFileExists()
    {
        $this->assertTrue(file_exists(self::$dirUrl));
        $this->assertTrue(file_exists(self::$fileUrl));
    }

    public function testIsLink()
    {
        $this->assertFalse(is_link(self::$dirUrl));
        $this->assertFalse(is_link(self::$fileUrl));
    }

    public function testIsExecutable()
    {
        // php returns false for is_executable if the file is a directory
        // https://github.com/php/php-src/blob/master/ext/standard/filestat.c#L907
        $this->assertFalse(is_executable(self::$dirUrl));
        $this->assertFalse(is_executable(self::$fileUrl));
    }

    public function testIsFile()
    {
        $this->assertTrue(is_file(self::$fileUrl));
        $this->assertFalse(is_file(self::$dirUrl));
    }

    public function testIsDir()
    {
        $this->assertTrue(is_dir(self::$dirUrl));
        $this->assertFalse(is_dir(self::$fileUrl));
    }

}
