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

use Google\Cloud\Storage;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
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
        // register the gs:// stream wrapper
        Storage\registerStreamWrapper();

        $this->client = $this->prophesize(StorageClient::class);
        $this->bucket = $this->prophesize(Bucket::class);
        $this->client->bucket('my_bucket')->willReturn($this->bucket->reveal());
        $this->originalDefaultContext = stream_context_get_options(stream_context_get_default());

        stream_context_set_default(array(
            'gs' => array(
                'client' => $this->client->reveal()
            )
        ));
    }

    public function tearDown()
    {
        stream_context_set_default($this->originalDefaultContext);

        // deregister the gs:// stream wrapper
        Storage\unregisterStreamWrapper();

        parent::tearDown();
    }

    public function testOpeningExistingFile()
    {
        $this->mockObjectData("existing_file.txt", "some data to read");

        $fp = fopen('gs://my_bucket/existing_file.txt', 'r');
        $this->assertEquals("some da", fread($fp, 7));
        $this->assertEquals("ta to read", fread($fp, 1000));
        fclose($fp);
    }

    public function testOpeningNonExistentFileReturnsFalse()
    {
        $this->mockDownloadException('non-existent/file.txt', \Google\Cloud\Exception\NotFoundException::class);

        $fp = @fopen('gs://my_bucket/non-existent/file.txt', 'r');
        $this->assertFalse($fp);
    }

    public function testUnknownOpenMode()
    {
        $fp = @fopen('gs://my_bucket/existing_file.txt', 'a');
        $this->assertFalse($fp);
    }

    public function testFileGetContents()
    {
        $this->mockObjectData("file_get_contents.txt", "some data to read");

        $this->assertEquals('some data to read', file_get_contents('gs://my_bucket/file_get_contents.txt'));
    }

    public function testFilePutContents()
    {
        $uploader  = $this->prophesize(StreamableUploader::class);
        $uploader->write(Argument::any())->willReturn(10);
        $uploader->close()->shouldBeCalled();
        $this->bucket->getStreamableUploader("", Argument::type('array'))->willReturn($uploader->reveal());

        file_put_contents('gs://my_bucket/file_put_contents.txt', 'Some data.');
    }

    public function testReadLines()
    {
        $this->mockObjectData("some_long_file.txt", "line1.\nline2.");

        $fp = fopen('gs://my_bucket/some_long_file.txt', 'r');
        $this->assertEquals("line1.\n", fgets($fp));
        $this->assertEquals("line2.", fgets($fp));
        fclose($fp);
    }

    private function mockObjectData($file, $data)
    {
        $stream = new \GuzzleHttp\Psr7\BufferStream(100);
        $stream->write($data);
        $object = $this->prophesize(StorageObject::class);
        $object->downloadAsStream(Argument::any())->willReturn($stream);
        $this->bucket->object($file)->willReturn($object->reveal());
    }

    private function mockDownloadException($file, $exception)
    {
        $object = $this->prophesize(StorageObject::class);
        $object->downloadAsStream(Argument::any())->willThrow($exception);
        $this->bucket->object($file)->willReturn($object->reveal());
    }
}
