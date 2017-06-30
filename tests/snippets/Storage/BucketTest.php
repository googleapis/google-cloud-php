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

namespace Google\Cloud\Tests\Snippets\Storage;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group storage
 */
class BucketTest extends SnippetTestCase
{
    const BUCKET = 'my-bucket';

    private $connection;
    private $bucket;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->bucket = \Google\Cloud\Dev\stub(Bucket::class, [
            $this->connection->reveal(),
            self::BUCKET
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Bucket::class);
        $res = $snippet->invoke('bucket');

        $this->assertInstanceOf(Bucket::class, $res->returnVal());
    }

    public function testAcl()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'acl');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('acl');

        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testDefaultAcl()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'defaultAcl');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('acl');

        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'exists');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled();

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Bucket exists!', $res->output());
    }

    public function testUpload()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    /**
     * @todo this needs more attention paid to testing the resume config.
     */
    public function testUploadResumableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload', 1);
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(ResumableUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    /**
     * @todo this needs more attention paid to testing the encryption config.
     */
    public function testUploadEncryption()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload', 2);
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testGetResumableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'getResumableUploader');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addUse(GoogleException::class);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(ResumableUploader::class);
        $uploader->upload()
            ->shouldBeCalledTimes(1)
            ->willThrow(new GoogleException('test'));

        $uri = 'http://test.com/path';
        $uploader->resume($uri)
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $uploader->getResumeUri()
            ->shouldBeCalled()
            ->willReturn($uri);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
    }

    public function testGetStreamableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'getStreamableUploader');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addUse(GoogleException::class);
        $snippet->replace("data.txt", 'php://temp');

        $uploader = $this->prophesize(StreamableUploader::class);
        $uploader->upload()
            ->shouldBeCalledTimes(1);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testObject()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'object');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testObjects()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'objects');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->listObjects(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'name' => 'object 1',
                        'generation' => 'abc'
                    ],
                    [
                        'name' => 'object 2',
                        'generation' => 'def'
                    ]
                ]
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('objects');
        $this->assertInstanceOf(ObjectIterator::class, $res->returnVal());
        $this->assertEquals('object 1', explode("\n", $res->output())[0]);
        $this->assertEquals('object 2', explode("\n", $res->output())[1]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'delete');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->deleteBucket(Argument::any())
            ->shouldBeCalled();

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'update');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->patchBucket(Argument::that(function($arg) {
            if ($arg['logging']['logBucket'] !== 'myBucket') return false;
            if ($arg['logging']['logObjectPrefix'] !== 'prefix') return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testCompose()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'compose');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->composeObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'combined-logs.txt',
                'generation' => 'foo'
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('singleObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
        $this->assertEquals('combined-logs.txt', $res->returnVal()->name());
    }

    public function testComposeWithObjects()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'compose', 1);
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->composeObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'combined-logs.txt',
                'generation' => 'foo'
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('singleObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
        $this->assertEquals('combined-logs.txt', $res->returnVal()->name());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'info');
        $snippet->addLocal('bucket', $this->bucket);

        $loc = 'inside your house';
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'location' => $loc
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($loc, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'reload');
        $snippet->addLocal('bucket', $this->bucket);

        $loc = 'inside your house';
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'location' => $loc
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($loc, $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'name');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke();
        $this->assertEquals(self::BUCKET, $res->output());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'iam');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }
}
