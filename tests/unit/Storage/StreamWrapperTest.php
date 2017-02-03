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

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Storage\StreamWrapper;
use Google\Cloud\Upload\StreamableUploader;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use GuzzleHttp\Psr7;

/**
 * @group storage
 */
class StreamWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $originalDefaultContext;

    private $connection;

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->prophesize(StorageClient::class);
        $this->bucket = $this->prophesize(Bucket::class);
        $this->client->bucket('my_bucket')->willReturn($this->bucket->reveal());

        StreamWrapper::register($this->client->reveal());
    }

    public function tearDown()
    {
        StreamWrapper::unregister();

        parent::tearDown();
    }

    /**
     * @group storageRead
     */
    public function testOpeningExistingFile()
    {
        $this->mockObjectData("existing_file.txt", "some data to read");

        $fp = fopen('gs://my_bucket/existing_file.txt', 'r');
        $this->assertEquals("some da", fread($fp, 7));
        $this->assertEquals("ta to read", fread($fp, 1000));
        fclose($fp);
    }

    /**
     * @group storageRead
     */
    public function testOpeningNonExistentFileReturnsFalse()
    {
        $this->mockDownloadException('non-existent/file.txt', \Google\Cloud\Exception\NotFoundException::class);

        $fp = @fopen('gs://my_bucket/non-existent/file.txt', 'r');
        $this->assertFalse($fp);
    }

    /**
     * @group storageRead
     */
    public function testUnknownOpenMode()
    {
        $fp = @fopen('gs://my_bucket/existing_file.txt', 'a');
        $this->assertFalse($fp);
    }

    /**
     * @group storageRead
     */
    public function testFileGetContents()
    {
        $this->mockObjectData("file_get_contents.txt", "some data to read");

        $this->assertEquals('some data to read', file_get_contents('gs://my_bucket/file_get_contents.txt'));
    }

    /**
     * @group storageRead
     */
    public function testReadLines()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");

        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $this->assertEquals("line1.\n", fgets($fp));
        $this->assertEquals("line2.", fgets($fp));
        fclose($fp);
    }

    /**
     * @group storageWrite
     */
    public function testFilePutContents()
    {
        $uploader  = $this->prophesize(StreamableUploader::class);
        $uploader->write(Argument::any())->willReturn(10);
        $uploader->close()->shouldBeCalled();
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        file_put_contents('gs://my_bucket/file_put_contents.txt', 'Some data.');
    }

    /**
     * @group storageInfo
     */
    public function testStreamCast()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");
        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $r = array($fp);
        $w = [];
        $e = null;
        $resource = stream_select($r, $w, $e, 0);
        $this->assertTrue(is_resource($resource));
    }

    /**
     * @group storageInfo
     */
    public function testFstat()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");
        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $stat = fstat($fp);
        $this->assertEquals(33060, $stat['mode']);
        fclose($fp);
    }

    /**
     * @group storageInfo
     */
    public function testStat()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");
        $stat = stat('gs://my_bucket/some_long_file.txt');
        $this->assertEquals(33060, $stat['mode']);
    }

    /**
     * @group storageInfo
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testStatOnNonExistentFile()
    {
        $this->mockDownloadException('non-existent/file.txt', \Google\Cloud\Exception\NotFoundException::class);
        stat('gs://my_bucket/non-existent/file.txt');
    }

    /**
     * @group storageDelete
     */
    public function testUnlink()
    {
        $obj = $this->prophesize(StorageObject::class);
        $obj->delete()->willReturn(true)->shouldBeCalled();
        $this->bucket->object('some_long_file.txt')->willReturn($obj->reveal());
        $this->assertTrue(unlink('gs://my_bucket/some_long_file.txt'));
    }

    /**
     * @group storageDelete
     */
    public function testUnlinkOnNonExistentFile()
    {
        $obj = $this->prophesize(StorageObject::class);
        $obj->delete()->willThrow(\Google\Cloud\Exception\NotFoundException::class);
        $this->bucket->object('some_long_file.txt')->willReturn($obj->reveal());
        $this->assertFalse(unlink('gs://my_bucket/some_long_file.txt'));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdir()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/'])->shouldBeCalled();
        $this->assertTrue(mkdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdirOnBadDirectory()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/'])->willThrow(\Google\Cloud\Exception\NotFoundException::class);
        $this->assertFalse(mkdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testRmdir()
    {
        $obj = $this->prophesize(StorageObject::class);
        $obj->delete()->willReturn(true)->shouldBeCalled();
        $this->bucket->object('foo/bar/')->willReturn($obj->reveal());
        $this->assertTrue(rmdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testRmdirOnBadDirectory()
    {
        $obj = $this->prophesize(StorageObject::class);
        $obj->delete()->willThrow(\Google\Cloud\Exception\NotFoundException::class);
        $this->bucket->object('foo/bar/')->willReturn($obj->reveal());
        $this->assertFalse(rmdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testDirectoryListing()
    {
        $fd = opendir('gs://my_bucket/foo/');
        $this->assertEqual('file1.txt', readdir($fd));
        $this->assertEqual('file2.txt', readdir($fd));
        $this->assertTrue(rewind($fd));
        $this->assertEqual('file1.txt', readdir($fd));
        closedir($fd);
    }

    public function testRenameFile()
    {
        $this->assertTrue(rename('gs://my_bucket/foo.txt', 'gs://my_bucket/new_location/foo.txt'));
    }

    public function testRenameDirectory()
    {
        $this->assertTrue(rename('gs://my_bucket/somefolder', 'gs://another_bucket/anotherfolder'));
    }

    private function mockObjectData($file, $data, $bucket = null)
    {
        $bucket = $bucket ?: $this->bucket;
        $stream = new \GuzzleHttp\Psr7\BufferStream(100);
        $stream->write($data);
        $object = $this->prophesize(StorageObject::class);
        $object->downloadAsStream(Argument::any())->willReturn($stream);
        $bucket->object($file)->willReturn($object->reveal());
    }

    private function mockDownloadException($file, $exception)
    {
        $object = $this->prophesize(StorageObject::class);
        $object->downloadAsStream(Argument::any())->willThrow($exception);
        $this->bucket->object($file)->willReturn($object->reveal());
    }
}
