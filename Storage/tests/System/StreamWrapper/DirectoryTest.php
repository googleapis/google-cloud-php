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

namespace Google\Cloud\Storage\Tests\System\StreamWrapper;

/**
 * @group storage
 * @group storage-stream-wrapper
 * @group storage-stream-wrapper-directory
 */
class DirectoryTest extends StreamWrapperTestCase
{
    private static $createObjects = [
        'some_folder/1.txt',
        'some_folder/2.txt',
        'some_folder/3.txt',
        'some_folder/nest/3.txt',
        '4.txt',
        'dir/',
        'dir',
        'foo',
        'bar/',
    ];

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        // create file in folder
        foreach (self::$createObjects as $name) {
            self::$bucket->upload('somedata', ['name' => $name]);
        }
    }

    public static function tear_down_after_class()
    {
        foreach (self::$createObjects as $name) {
            self::$bucket->object($name)->delete();
        }

        parent::tear_down_after_class();
    }

    public function testMkDir()
    {
        $dir = self::generateUrl('test_directory');
        $this->assertTrue(mkdir($dir));
        $this->assertFileExists($dir . '/');
        $this->assertTrue(is_dir($dir . '/'));
    }

    public function testMkDirWithUbl()
    {
        $bucket = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            [
                'iamConfiguration' => [
                    'uniformBucketLevelAccess' => [
                        'enabled' => true
                    ]
                ]
            ]
        );

        $dir = self::generateUrl('test_directory', $bucket);
        $this->assertTrue(mkdir($dir));
        $this->assertFileExists($dir . '/');
        $this->assertTrue(is_dir($dir . '/'));
    }

    public function testIsDir()
    {
        $dir = self::generateUrl('test_directory');
        $this->assertTrue(mkdir($dir));
        $this->assertFileExists($dir);
        $this->assertTrue(is_dir($dir));
    }

    public function testRmDir()
    {
        $dir = self::generateUrl('test_directory/');
        $this->assertTrue(rmdir($dir));
        $this->assertFileNotExists($dir . '/');
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
        $this->assertEquals('1.txt', readdir($fd));
        $this->assertEquals('2.txt', readdir($fd));
        rewinddir($fd);
        $this->assertEquals('1.txt', readdir($fd));
        closedir($fd);
    }

    public function testListRootDirectory()
    {
        $expected = [
            '4.txt',
            'bar',
            'dir',
            'foo',
            'some_folder',
        ];
        $actual = [];

        $dir = self::generateUrl('');
        $fd = opendir($dir);

        while (($name = readdir($fd)) !== false) {
            if (in_array($name, $expected)) {
                $actual[] = $name;
            }
        }

        closedir($fd);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testScanDirectory()
    {
        $dir = self::generateUrl('some_folder');
        $expected = [
            '1.txt',
            '2.txt',
            '3.txt',
            'nest',
        ];
        $this->assertEquals($expected, scandir($dir));
        $this->assertEquals(array_reverse($expected), scandir($dir, SCANDIR_SORT_DESCENDING));
    }

    public function testScanRootDirectory()
    {
        $expected = [
            '4.txt',
            'bar',
            'dir',
            'foo',
            'some_folder',
        ];

        foreach (['', '/'] as $path) {
            $url = self::generateUrl($path);
            $actual = [];
            foreach (scandir($url) as $name) {
                if (in_array($name, $expected)) {
                    $actual[] = $name;
                }
            }
            sort($actual);
            $this->assertEquals($expected, $actual);
        }
    }
}
