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

use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Tests\KeyPairGenerateTrait;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @group storage
 */
class StorageObjectTest extends SnippetTestCase
{
    use KeyPairGenerateTrait;

    const OBJECT = 'my-object';
    const BUCKET = 'my-bucket';

    private $connection;
    private $object;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->object = \Google\Cloud\Dev\stub(StorageObject::class, [
            $this->connection->reveal(),
            self::OBJECT,
            self::BUCKET
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(StorageObject::class);
        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testAcl()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'acl');
        $snippet->addLocal('object', $this->object);

        $res = $snippet->invoke('acl');
        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'exists');
        $snippet->addLocal('object', $this->object);

        $this->connection->getObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Object exists!', $res->output());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'delete');
        $snippet->addLocal('object', $this->object);

        $this->connection->deleteObject(Argument::any())
            ->shouldBeCalled();

        $this->object->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'update');
        $snippet->addLocal('object', $this->object);

        $this->connection->patchObject(Argument::any())
            ->shouldBeCalled();

        $this->object->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testCopy()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'copy');
        $snippet->addLocal('object', $this->object);

        $this->connection->copyObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'New Object',
                'bucket' => self::BUCKET,
                'generation' => 'foo'
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('copiedObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testCopyToBucket()
    {
        $bucket = $this->prophesize(Bucket::class);
        $bucket->name()->willReturn('foo');

        $storage = $this->prophesize(StorageClient::class);
        $storage->bucket(Argument::any())
            ->willReturn($bucket->reveal());

        $snippet = $this->snippetFromMethod(StorageObject::class, 'copy', 1);
        $snippet->addLocal('object', $this->object);
        $snippet->addLocal('storage', $storage->reveal());

        $this->connection->copyObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'New Object',
                'bucket' => self::BUCKET,
                'generation' => 'foo'
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('copiedObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testRewrite()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'rewrite');
        $snippet->addLocal('object', $this->object);

        $this->connection->rewriteObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resource' => [
                    'name' => self::OBJECT,
                    'bucket' => self::BUCKET,
                    'generation' => 'foo'
                ]
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('rewrittenObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testRewriteNewObjectName()
    {
        $bucket = $this->prophesize(Bucket::class);
        $bucket->name()->willReturn('foo');

        $storage = $this->prophesize(StorageClient::class);
        $storage->bucket(Argument::any())
            ->willReturn($bucket->reveal());

        $snippet = $this->snippetFromMethod(StorageObject::class, 'rewrite', 1);
        $snippet->addLocal('storage', $storage->reveal());
        $snippet->addLocal('object', $this->object);

        $this->connection->rewriteObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resource' => [
                    'name' => self::OBJECT,
                    'bucket' => self::BUCKET,
                    'generation' => 'foo'
                ]
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('rewrittenObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testRewriteNewKey()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'rewrite', 2);
        $snippet->addLocal('object', $this->object);
        $snippet->replace("file_get_contents(__DIR__ . '/key.txt')", "'testKeyData'");

        $this->connection->rewriteObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resource' => [
                    'name' => self::OBJECT,
                    'bucket' => self::BUCKET,
                    'generation' => 'foo'
                ]
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('rewrittenObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testRename()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'rename');
        $snippet->addLocal('object', $this->object);

        $this->connection->copyObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'object2.txt',
                'bucket' => self::BUCKET,
                'generation' => 'foo'
            ]);

        $this->connection->deleteObject(Argument::any())
            ->shouldBeCalled();

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('object2.txt', $res->output());
    }

    public function testDownloadAsString()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'downloadAsString');
        $snippet->addLocal('object', $this->object);

        $this->connection->downloadObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn(\GuzzleHttp\Psr7\stream_for('test'));

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('test', $res->output());
    }

    public function testDownloadToFile()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'downloadToFile');
        $snippet->addLocal('object', $this->object);
        $snippet->replace("__DIR__ . '/my-file.txt'", "'php://temp'");

        $this->connection->downloadObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn(\GuzzleHttp\Psr7\stream_for('test'));

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('stream');

        $this->assertInstanceOf(StreamInterface::class, $res->returnVal());
    }

    public function testDownloadAsStream()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'downloadAsStream');
        $snippet->addLocal('object', $this->object);

        $this->connection->downloadObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn(\GuzzleHttp\Psr7\stream_for('test'));

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();

        $this->assertEquals('test', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'info');
        $snippet->addLocal('object', $this->object);

        $this->connection->getObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::OBJECT,
                'bucket' => self::BUCKET,
                'size' => 1,
                'location' => 'right behind you!'
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'reload');
        $snippet->addLocal('object', $this->object);

        $this->connection->getObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::OBJECT,
                'bucket' => self::BUCKET,
                'size' => 1,
                'location' => 'right behind you!'
            ]);

        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('right behind you!', $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'name');
        $snippet->addLocal('object', $this->object);

        $res = $snippet->invoke();
        $this->assertEquals(self::OBJECT, $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'identity');
        $snippet->addLocal('object', $this->object);

        $res = $snippet->invoke();
        $this->assertEquals(self::OBJECT, $res->output());
    }

    public function testGcsUri()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'gcsUri');
        $snippet->addLocal('object', $this->object);

        $res = $snippet->invoke();
        $expectedOutput = sprintf('gs://%s/%s', self::BUCKET, self::OBJECT);
        $this->assertEquals($expectedOutput, $res->output());
    }

    public function testSignedUrl()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'signedUrl');
        $snippet->addLocal('object', $this->object);
        $snippet->addUse(Timestamp::class);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->object->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('url');
        $this->assertTrue(strpos($res->returnVal(), 'https://storage.googleapis.com/my-bucket/my-object') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Expires=') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Signature=') !== false);
    }

    public function testSignedUrlUpdate()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'signedUrl', 1);
        $snippet->addLocal('object', $this->object);
        $snippet->addUse(Timestamp::class);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->object->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('url');
        $this->assertTrue(strpos($res->returnVal(), 'https://storage.googleapis.com/my-bucket/my-object') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Expires=') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Signature=') !== false);
    }

    public function testSignedUploadUrl()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'signedUploadUrl');
        $snippet->addLocal('object', $this->object);
        $snippet->addUse(Timestamp::class);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->object->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('url');
        $this->assertTrue(strpos($res->returnVal(), 'https://storage.googleapis.com/my-bucket/my-object') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Expires=') !== false);
        $this->assertTrue(strpos($res->returnVal(), 'Signature=') !== false);
    }

    public function testBeginSignedUploadSession()
    {
        $snippet = $this->snippetFromMethod(StorageObject::class, 'beginSignedUploadSession');
        $snippet->addLocal('object', $this->object);
        $snippet->addUse(Timestamp::class);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $resumeUri = 'theResumeUri';
        $response = new Response(200, ['Location' => $resumeUri]);

        $rw->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $this->connection->requestWrapper()->willReturn($rw->reveal());
        $this->object->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('url');
        $this->assertEquals($resumeUri, $res->returnVal());
    }
}
