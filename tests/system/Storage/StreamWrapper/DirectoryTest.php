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
class DirectoryTest extends StreamWrapperTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // create file in folder
        self::$bucket->upload('somedata', ['name' => 'some_folder/1.txt']);
        self::$bucket->upload('somedata', ['name' => 'some_folder/2.txt']);
        self::$bucket->upload('somedata', ['name' => 'some_folder/3.txt']);
    }

    public function testMkDir()
    {
        $dir = self::generateUrl('test_directory');
        $this->assertTrue(mkdir($dir));
        $this->assertTrue(file_exists($dir . '/'));
        $this->assertTrue(is_dir($dir . '/'));
    }

    public function testRmDir()
    {
        $dir = self::generateUrl('test_directory/');
        $this->assertTrue(rmdir($dir));
        $this->assertFalse(file_exists($dir . '/'));
    }

    public function testMkDirCreatesBucket()
    {
        $newBucket = uniqid(self::TESTING_PREFIX);
        $bucketUrl = "gs://$newBucket/";
        $this->assertTrue(mkdir($bucketUrl, 0700));

        $bucket = self::$client->bucket($newBucket);
        $this->assertTrue($bucket->exists());
        $this->assertTrue(rmdir($bucketUrl));
    }

    public function testListDirectory()
    {
        $dir = self::generateUrl('some_folder');
        $fd = opendir($dir);
        $this->assertEquals('some_folder/1.txt', readdir($fd));
        $this->assertEquals('some_folder/2.txt', readdir($fd));
        rewinddir($fd);
        $this->assertEquals('some_folder/1.txt', readdir($fd));
        closedir($fd);
    }

    public function testScanDirectory()
    {
        $dir = self::generateUrl('some_folder');
        $expected = [
            'some_folder/1.txt',
            'some_folder/2.txt',
            'some_folder/3.txt',
        ];
        $this->assertEquals($expected, scandir($dir));
        $this->assertEquals(array_reverse($expected), scandir($dir, SCANDIR_SORT_DESCENDING));
    }
}
