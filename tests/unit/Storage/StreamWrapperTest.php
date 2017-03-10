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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Storage\StreamWrapper;
use GuzzleHttp\Psr7;
use Prophecy\Argument;
use Prophecy\Promise\CallbackPromise;
use Prophecy\Prophecy\ObjectProphecy;

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
        $this->mockDownloadException('non-existent/file.txt', NotFoundException::class);

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
    public function testFileWrite()
    {
        $uploader  = $this->prophesize(StreamableUploader::class);
        $uploader->upload()->shouldBeCalled();
        $uploader->getResumeUri()->willReturn('https://resume-uri/');
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        $fp = fopen('gs://my_bucket/output.txt', 'w');
        $this->assertEquals(6, fwrite($fp, "line1."));
        $this->assertEquals(6, fwrite($fp, "line2."));
        fclose($fp);
    }

    /**
     * @group storageWrite
     */
    public function testFilePutContents()
    {
        $uploader  = $this->prophesize(StreamableUploader::class);
        $uploader->upload()->shouldBeCalled();
        $uploader->getResumeUri()->willReturn('https://resume-uri/');
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        file_put_contents('gs://my_bucket/file_put_contents.txt', 'Some data.');
    }

    /**
     * @group storageSeek
     */
    public function testSeekOnWritableStream()
    {
        $uploader  = $this->prophesize(StreamableUploader::class);
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        $fp = fopen('gs://my_bucket/output.txt', 'w');
        $this->assertEquals(-1, fseek($fp, 100));
        fclose($fp);
    }

    /**
     * @group storageSeek
     */
    public function testSeekOnReadableStream()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");
        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $this->assertEquals(-1, fseek($fp, 100));
        fclose($fp);
    }

    /**
     * @group storageInfo
     */
    public function testFstat()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");
        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $stat = fstat($fp);
        $this->assertEquals(33206, $stat['mode']);
        fclose($fp);
    }

    /**
     * @group storageInfo
     */
    public function testStat()
    {
        $object = $this->prophesize(StorageObject::class);
        $object->info()->willReturn([
            'size' => 1234,
            'updated' => '2017-01-19T19:31:35.833Z',
            'timeCreated' => '2017-01-19T19:31:35.833Z'
        ]);
        $this->bucket->object('some_long_file.txt')->willReturn($object->reveal());
        $this->bucket->isWritable()->willReturn(true);

        $stat = stat('gs://my_bucket/some_long_file.txt');
        $this->assertEquals(33206, $stat['mode']);
    }

    /**
     * @group storageInfo
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testStatOnNonExistentFile()
    {
        $object = $this->prophesize(StorageObject::class);
        $object->info()->willThrow(NotFoundException::class);
        $this->bucket->object('non-existent/file.txt')->willReturn($object->reveal());

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
        $obj->delete()->willThrow(NotFoundException::class);
        $this->bucket->object('some_long_file.txt')->willReturn($obj->reveal());
        $this->assertFalse(unlink('gs://my_bucket/some_long_file.txt'));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdir()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/', 'predefinedAcl' => 'publicRead'])->shouldBeCalled();
        $this->assertTrue(mkdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdirProjectPrivate()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/', 'predefinedAcl' => 'projectPrivate'])->shouldBeCalled();
        $this->assertTrue(mkdir('gs://my_bucket/foo/bar', 0740));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdirPrivate()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/', 'predefinedAcl' => 'private'])->shouldBeCalled();
        $this->assertTrue(mkdir('gs://my_bucket/foo/bar', 0700));
    }

    /**
     * @group storageDirectory
     */
    public function testMkdirOnBadDirectory()
    {
        $this->bucket->upload('', ['name' => 'foo/bar/', 'predefinedAcl' => 'publicRead'])->willThrow(NotFoundException::class);
        $this->assertFalse(mkdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testMkDirCreatesBucket()
    {
        $this->bucket->exists()->willReturn(false);
        $this->bucket->name()->willReturn('my_bucket');
        $this->client->createBucket('my_bucket', [
            'predefinedAcl' => 'publicRead',
            'predefinedDefaultObjectAcl' => 'publicRead']
        )->willReturn($this->bucket);
        $this->bucket->upload('', ['name' => 'foo/bar/', 'predefinedAcl' => 'publicRead'])->shouldBeCalled();

        $this->assertTrue(mkdir('gs://my_bucket/foo/bar', 0777, STREAM_MKDIR_RECURSIVE));
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
        $obj->delete()->willThrow(NotFoundException::class);
        $this->bucket->object('foo/bar/')->willReturn($obj->reveal());
        $this->assertFalse(rmdir('gs://my_bucket/foo/bar'));
    }

    /**
     * @group storageDirectory
     */
    public function testDirectoryListing()
    {
        $this->mockDirectoryListing('foo/', ['foo/file1.txt', 'foo/file2.txt', 'foo/file3.txt', 'foo/file4.txt']);
        $fd = opendir('gs://my_bucket/foo/');
        $this->assertEquals('foo/file1.txt', readdir($fd));
        $this->assertEquals('foo/file2.txt', readdir($fd));
        $this->assertEquals('foo/file3.txt', readdir($fd));
        rewinddir($fd);
        $this->assertEquals('foo/file1.txt', readdir($fd));
        closedir($fd);
    }

    /**
     * @group storageDirectory
     */
    public function testDirectoryListingViaScan()
    {
        $files = ['foo/file1.txt', 'foo/file2.txt', 'foo/file3.txt', 'foo/file4.txt'];
        $this->mockDirectoryListing('foo/', $files);
        $this->assertEquals($files, scandir('gs://my_bucket/foo/'));
    }

    public function testRenameFile()
    {
        $this->mockDirectoryListing('foo.txt', ['foo.txt']);
        $object = $this->prophesize(StorageObject::class);
        $object->rename('new_location/foo.txt', ['destinationBucket' => 'my_bucket'])->shouldBeCalled();
        $this->bucket->object('foo.txt')->willReturn($object->reveal());

        $this->assertTrue(rename('gs://my_bucket/foo.txt', 'gs://my_bucket/new_location/foo.txt'));
    }

    public function testRenameToDifferentBucket()
    {
        $this->mockDirectoryListing('foo.txt', ['foo.txt']);
        $object = $this->prophesize(StorageObject::class);
        $object->rename('bar/foo.txt', ['destinationBucket' => 'another_bucket'])->shouldBeCalled();
        $this->bucket->object('foo.txt')->willReturn($object->reveal());

        $this->assertTrue(rename('gs://my_bucket/foo.txt', 'gs://another_bucket/bar/foo.txt'));
    }

    public function testRenameDirectory()
    {
        $this->mockDirectoryListing('foo', ['foo/bar1.txt', 'foo/bar2.txt', 'foo/asdf/bar.txt']);

        $object = $this->prophesize(StorageObject::class);
        $object->rename('nested/folder/bar1.txt', ['destinationBucket' => 'another_bucket'])->shouldBeCalled();
        $this->bucket->object('foo/bar1.txt')->willReturn($object->reveal());

        $object = $this->prophesize(StorageObject::class);
        $object->rename('nested/folder/bar2.txt', ['destinationBucket' => 'another_bucket'])->shouldBeCalled();
        $this->bucket->object('foo/bar2.txt')->willReturn($object->reveal());

        $object = $this->prophesize(StorageObject::class);
        $object->rename('nested/folder/asdf/bar.txt', ['destinationBucket' => 'another_bucket'])->shouldBeCalled();
        $this->bucket->object('foo/asdf/bar.txt')->willReturn($object->reveal());

        $this->assertTrue(rename('gs://my_bucket/foo', 'gs://another_bucket/nested/folder'));
    }

    public function testCanSpecifyChunkSizeViaContext()
    {

        $uploader  = $this->prophesize(StreamableUploader::class);
        $upload = $uploader->upload(5)->willReturn(array())->shouldBeCalled();
        $uploader->upload()->shouldBeCalled();
        $uploader->getResumeUri()->willReturn('https://resume-uri/');
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        $context = stream_context_create(array(
            'gs' => array(
                'chunkSize' => 5
            )
        ));
        $fp = fopen('gs://my_bucket/existing_file.txt', 'w', false, $context);
        $this->assertEquals(9, fwrite($fp, "123456789"));
        fclose($fp);
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

    private function mockDirectoryListing($path, $filesToReturn)
    {
        $test = $this;
        $this->bucket->objects(
            Argument::that(function($options) use ($path) {
                return $options['prefix'] == $path;
            })
        )->will(function() use ($test, $filesToReturn) {
            return $test->fileListGenerator($filesToReturn);
        });
    }

    private function fileListGenerator($fileToReturn)
    {
        foreach($fileToReturn as $file) {
            $obj = $this->prophesize(StorageObject::class);
            $obj->name()->willReturn($file);
            yield $obj->reveal();
        }
    }
}
