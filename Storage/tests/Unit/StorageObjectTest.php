<?php
/**
 * Copyright 2015 Google Inc.
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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Testing\KeyPairGenerateTrait;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Psr7;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 */
class StorageObjectTest extends TestCase
{
    use KeyPairGenerateTrait;

    const TIMESTAMP = '2025-01-01';
    const BUCKET = 'bucket';
    const OBJECT = 'object.txt';

    /** @var Rest|ObjectProphecy */
    public $connection;

    private $key;
    private $kf;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->key = $this->getKeyPair();
        $this->kf = $kf = [
            'private_key' => $this->key[0],
            'client_email' => 'test@example.com'
        ];
    }

    public function testGetAcl()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertInstanceOf(Acl::class, $object->acl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getObject(Argument::any())->willReturn(['name' => self::OBJECT]);
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertTrue($object->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getObject(Argument::any())->willThrow(new NotFoundException(null));
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertFalse($object->exists());
    }

    public function testDelete()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertNull($object->delete());
    }

    public function testUpdatesData()
    {
        $object = self::OBJECT;
        $data = ['contentType' => 'image/jpg'];
        $this->connection->patchObject(Argument::any())->willReturn(['name' => $object] + $data);
        $object = new StorageObject(
            $this->connection->reveal(),
            $object,
            'bucket',
            null,
            ['contentType' => 'image/png']
        );

        $object->update($data);

        $this->assertEquals($data['contentType'], $object->info()['contentType']);
    }

    public function testUpdatesDataAndUnsetsAclWithPredefinedAclApplied()
    {
        $object = self::OBJECT;
        $bucket = 'bucket';
        $predefinedAcl = ['predefinedAcl' => 'private'];
        $this->connection->patchObject($predefinedAcl + [
            'bucket' => $bucket,
            'object' => $object,
            'acl' => null
        ])->willReturn([]);
        $object = new StorageObject(
            $this->connection->reveal(),
            $object,
            $bucket,
            null,
            ['acl' => 'test']
        );

        $object->update([], $predefinedAcl);
    }

    public function testCopyObjectWithDefaultName()
    {
        $sourceBucket = 'bucket';
        $destinationBucket = 'bucket2';
        $objectName = self::OBJECT;
        $acl = 'private';
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $this->connection->copyObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $objectName,
                'destinationBucket' => $destinationBucket,
                'destinationObject' => $objectName,
                'destinationPredefinedAcl' => $acl,
                'restOptions' => [
                    'headers' => [
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $key,
                        'x-goog-encryption-key-sha256' => $hash,
                    ]
                ]
            ])
            ->willReturn([
                'bucket' => $destinationBucket,
                'name' => $objectName,
                'generation' => 1
            ])
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $objectName, $sourceBucket);
        $copiedObject = $object->copy($destinationBucket, [
            'predefinedAcl' => $acl,
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]);

        $this->assertEquals($destinationBucket, $copiedObject->info()['bucket']);
        $this->assertEquals($objectName, $copiedObject->info()['name']);
    }

    public function testCopyObjectWithNewName()
    {
        $sourceBucket = 'bucket';
        $sourceObject = self::OBJECT;
        $bucketConnection = $this->prophesize(Rest::class)->reveal();
        $destinationBucketName = 'bucket2';
        $destinationBucket = new Bucket($bucketConnection, $destinationBucketName, []);
        $destinationObject = 'object2.txt';
        $acl = 'private';
        $this->connection->copyObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $sourceObject,
                'destinationBucket' => $destinationBucketName,
                'destinationObject' => $destinationObject,
                'destinationPredefinedAcl' => $acl
            ])
            ->willReturn([
                'bucket' => $destinationBucketName,
                'name' => $destinationObject,
                'generation' => 1
            ])
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $sourceObject, $sourceBucket);
        $copiedObject = $object->copy($destinationBucket, [
            'predefinedAcl' => $acl,
            'name' => $destinationObject
        ]);

        $this->assertEquals($destinationBucketName, $copiedObject->info()['bucket']);
        $this->assertEquals($destinationObject, $copiedObject->info()['name']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCopyObjectThrowsExceptionWithInvalidType()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt.', self::BUCKET);
        $copiedObject = $object->copy($object);
    }

    public function testRewriteObjectWithDefaultName()
    {
        $sourceBucket = 'bucket';
        $destinationBucket = 'bucket2';
        $objectName = self::OBJECT;
        $acl = 'private';
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $destinationKey = base64_encode('efgh');
        $destinationHash = base64_encode('5678');
        $this->connection->rewriteObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $objectName,
                'destinationBucket' => $destinationBucket,
                'destinationObject' => $objectName,
                'destinationPredefinedAcl' => $acl,
                'restOptions' => [
                    'headers' => [
                        'x-goog-copy-source-encryption-algorithm' => 'AES256',
                        'x-goog-copy-source-encryption-key' => $key,
                        'x-goog-copy-source-encryption-key-sha256' => $hash,
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $destinationKey,
                        'x-goog-encryption-key-sha256' => $destinationHash,
                    ]
                ]
            ])
            ->willReturn([
                'resource' => [
                    'bucket' => $destinationBucket,
                    'name' => $objectName,
                    'generation' => 1
                ]
            ])
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $objectName, $sourceBucket);
        $copiedObject = $object->rewrite($destinationBucket, [
            'predefinedAcl' => $acl,
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash,
            'destinationEncryptionKey' => $destinationKey,
            'destinationEncryptionKeySHA256' => $destinationHash
        ]);

        $this->assertEquals($destinationBucket, $copiedObject->info()['bucket']);
        $this->assertEquals($objectName, $copiedObject->info()['name']);
    }

    public function testRewriteObjectWithNewName()
    {
        $sourceBucket = 'bucket';
        $sourceObject = self::OBJECT;
        $bucketConnection = $this->prophesize(Rest::class)->reveal();
        $destinationBucketName = 'bucket2';
        $destinationBucket = new Bucket($bucketConnection, $destinationBucketName, []);
        $destinationObject = 'object2.txt';
        $acl = 'private';
        $rewriteToken = 'abc';
        $this->connection->rewriteObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $sourceObject,
                'destinationBucket' => $destinationBucketName,
                'destinationObject' => $destinationObject,
                'destinationPredefinedAcl' => $acl
            ])
            ->willReturn([
                'rewriteToken' => $rewriteToken
            ])
            ->shouldBeCalledTimes(1);
        $this->connection->rewriteObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $sourceObject,
                'destinationBucket' => $destinationBucketName,
                'destinationObject' => $destinationObject,
                'destinationPredefinedAcl' => $acl,
                'rewriteToken' => $rewriteToken
            ])
            ->willReturn(
                [
                    'resource' => [
                        'bucket' => $destinationBucketName,
                        'name' => $destinationObject,
                        'generation' => 1
                    ]
                ]
            )
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $sourceObject, $sourceBucket);
        $rewrittenObject = $object->rewrite($destinationBucket, [
            'predefinedAcl' => $acl,
            'name' => $destinationObject
        ]);

        $this->assertEquals($destinationBucketName, $rewrittenObject->info()['bucket']);
        $this->assertEquals($destinationObject, $rewrittenObject->info()['name']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRewriteObjectThrowsExceptionWithInvalidType()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt.', self::BUCKET);
        $copiedObject = $object->rewrite($object);
    }

    public function testRenamesObject()
    {
        $sourceBucket = 'bucket';
        $objectName = self::OBJECT;
        $newObjectName = 'new-name.txt';
        $acl = 'private';
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $this->connection->copyObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $objectName,
                'destinationBucket' => $sourceBucket,
                'destinationObject' => $newObjectName,
                'destinationPredefinedAcl' => $acl,
                'restOptions' => [
                    'headers' => [
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $key,
                        'x-goog-encryption-key-sha256' => $hash,
                    ]
                ]
            ])
            ->willReturn([
                'bucket' => $sourceBucket,
                'name' => $newObjectName,
                'generation' => 1
            ])
            ->shouldBeCalledTimes(1);
        $this->connection->deleteObject(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $objectName, $sourceBucket);
        $copiedObject = $object->rename($newObjectName, [
            'predefinedAcl' => $acl,
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]);

        $this->assertEquals($sourceBucket, $copiedObject->info()['bucket']);
        $this->assertEquals($newObjectName, $copiedObject->info()['name']);
    }

    public function testDownloadsAsString()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
                'bucket' => $bucket,
                'object' => $object,
                'restOptions' => [
                    'headers' => [
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $key,
                        'x-goog-encryption-key-sha256' => $hash,
                    ]
                ]
            ])
            ->willReturn($stream)
            ->shouldBeCalledTimes(1);

        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $this->assertEquals($string, $object->downloadAsString([
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]));
    }

    public function testDownloadsToFile()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
                'bucket' => $bucket,
                'object' => $object,
                'restOptions' => [
                    'headers' => [
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $key,
                        'x-goog-encryption-key-sha256' => $hash,
                    ]
                ]
            ])
            ->willReturn($stream);

        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $contents = $object->downloadToFile('php://temp', [
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ])->getContents();
        $this->assertEquals($string, $contents);
    }

    public function testGetBodyWithoutExtraOptions()
    {
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
            'bucket' => $bucket,
            'object' => $object,
        ])
            ->willReturn($stream);

        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $body = $object->downloadAsStream();

        $this->assertInstanceOf(StreamInterface::class, $body);
        $this->assertEquals($string, $body);
    }

    public function testGetBodyWithExtraOptions()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
            'bucket' => $bucket,
            'object' => $object,
            'restOptions' => [
                'headers' => [
                    'x-goog-encryption-algorithm' => 'AES256',
                    'x-goog-encryption-key' => $key,
                    'x-goog-encryption-key-sha256' => $hash
                ]
            ]
        ])
            ->willReturn($stream);

        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $body = $object->downloadAsStream([
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]);

        $this->assertInstanceOf(StreamInterface::class, $body);
        $this->assertEquals($string, $body);
    }

    public function testGetsInfo()
    {
        $objectInfo = [
            'name' => self::OBJECT,
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, 'bucket', null, $objectInfo);

        $this->assertEquals($objectInfo, $object->info());
    }

    public function testGetsInfoWithReload()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $objectInfo = [
            'name' => self::OBJECT,
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $this->connection->getObject([
                'bucket' => $bucket,
                'object' => $object,
                'restOptions' => [
                    'headers' => [
                        'x-goog-encryption-algorithm' => 'AES256',
                        'x-goog-encryption-key' => $key,
                        'x-goog-encryption-key-sha256' => $hash,
                    ]
                ]
            ])
            ->willReturn($objectInfo)
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $this->assertEquals($objectInfo, $object->info([
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]));
    }

    public function testGetsName()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertEquals(self::OBJECT, $object->name());
    }

    public function testGetsIdentity()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $this->assertEquals(self::OBJECT, $object->identity()['object']);
        $this->assertEquals(self::BUCKET, $object->identity()['bucket']);
    }

    public function testGetsGcsUri()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);

        $expectedUri = sprintf('gs://%s/%s', self::BUCKET, self::OBJECT);
        $this->assertEquals($expectedUri, $object->gcsUri());
    }

    /**
     * @group storage-signed-url
     * @dataProvider signedUrlExpiration
     */
    public function testSignedUrl($exp, $seconds)
    {
        $object = new StorageObjectSignatureStub($this->connection->reveal(), self::OBJECT, 'bucket', 'foo');
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $contentType = $responseType = 'text/plain';
        $digest = base64_encode(md5('hello world'));

        $url = $object->signedUrl($exp, [
            'keyFile' => $this->kf,
            'headers' => [
                'x-goog-foo' => ['bar', 'bar'],
                'x-goog-bat' => 'baz'
            ],
            'contentType' => $contentType,
            'responseDisposition' => 'foo',
            'responseType' => $responseType,
            'contentMd5' => $digest
        ]);

        $input = implode("\n", [
            'GET',
            $digest,
            $contentType,
            $seconds,
            'x-goog-bat:baz',
            'x-goog-foo:bar,bar',
            '/bucket/object.txt'
        ]);

        $query = explode('?', $url)[1];
        $pieces = explode('&', $query);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
        $this->assertContains('generation=foo', $pieces);
        $this->assertContains('response-content-type='. urlencode($contentType), $pieces);
        $this->assertContains('response-content-disposition=foo', $pieces);
        $this->assertContains('response-content-type='. urlencode($responseType), $pieces);
    }

    public function signedUrlExpiration()
    {
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));
        $seconds = $ts->get()->format('U');

        return [
            [$ts, $seconds],
            [$seconds, $seconds]
        ];
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidExpirationType()
    {
        $object = new StorageObjectSignatureStub($this->connection->reveal(), 'object.txt', 'bucket', 'foo');
        $object->signedUrl('foo', [
            'keyFile' => $this->kf,
        ]);
    }

    /**
     * @group storage-signed-url
     * @dataProvider signedUrlInvalidHeaders
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidHeader($header, $val = 'val')
    {
        $object = new StorageObjectSignatureStub($this->connection->reveal(), 'object.txt', 'bucket', 'foo');
        $object->signedUrl(time()+1, [
            'keyFile' => $this->kf,
            'headers' => [
                $header => $val
            ]
        ]);
    }

    public function signedUrlInvalidHeaders()
    {
        return [
            ['x-goog-encryption-key'],
            ['x-goog-encryption-key-sha256'],
            ['foo'],
            ['x-goog-test', 'test' . PHP_EOL .' test']
        ];
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUrlWithSaveAsName()
    {
        $object = new StorageObjectSignatureStub($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $url = $object->signedUrl($ts, [
            'keyFile' => $this->kf,
            'saveAsName' => 'foo'
        ]);

        $input = implode("\n", [
            'GET',
            '',
            '',
            $seconds,
            '/bucket/object.txt'
        ]);

        $query = explode('?', $url)[1];
        $pieces = explode('&', $query);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
        $this->assertContains('response-content-disposition=attachment;filename="foo"', $pieces);
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUrlConnectionKeyfile()
    {
        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($this->kf);

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $object = new StorageObjectSignatureStub($conn->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $url = $object->signedUrl($ts);

        $input = implode("\n", [
            'GET',
            '',
            '',
            $seconds,
            '/bucket/object.txt'
        ]);

        $query = explode('?', $url)[1];
        $pieces = explode('&', $query);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUrlWithSpace()
    {
        $name = 'object object.txt';
        $object = new StorageObjectSignatureStub(
            $this->connection->reveal(),
            $name,
            self::BUCKET,
            'foo'
        );
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $contentType = $responseType = 'text/plain';
        $digest = base64_encode(md5('hello world'));

        $url = $object->signedUrl($ts, [
            'keyFile' => $this->kf,
            'contentType' => $contentType,
            'responseDisposition' => 'foo',
            'responseType' => $responseType,
            'contentMd5' => $digest
        ]);

        $input = implode("\n", [
            'GET',
            $digest,
            $contentType,
            $seconds,
            sprintf('/%s/%s', self::BUCKET, rawurlencode($name))
        ]);

        $parts = explode('?', $url);
        $resource = $parts[0];
        $query = $parts[1];
        $pieces = explode('&', $query);

        $resourceParts = explode('/', $resource);
        $objName = end($resourceParts);

        $this->assertEquals(rawurldecode($objName), $name);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
        $this->assertContains('generation=foo', $pieces);
        $this->assertContains('response-content-type='. urlencode($contentType), $pieces);
        $this->assertContains('response-content-disposition=foo', $pieces);
        $this->assertContains('response-content-type='. urlencode($responseType), $pieces);
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUploadUrl()
    {
        $object = new StorageObjectSignatureStub(
            $this->connection->reveal(),
            self::OBJECT,
            'bucket',
            'foo'
        );
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $contentType = $responseType = 'text/plain';
        $digest = base64_encode(md5('hello world'));

        $url = $object->signedUploadUrl($ts, [
            'keyFile' => $this->kf,
            'contentType' => $contentType,
            'contentMd5' => $digest
        ]);

        $input = implode("\n", [
            'POST',
            $digest,
            $contentType,
            $seconds,
            'x-goog-resumable:start',
            '/bucket/object.txt'
        ]);

        $query = explode('?', $url)[1];
        $pieces = explode('&', $query);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUploadUrlNestedName()
    {
        $objectName = 'folder1/folder2/object.txt';
        $object = new StorageObjectSignatureStub(
            $this->connection->reveal(),
            $objectName,
            self::BUCKET,
            'foo'
        );
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $seconds = $ts->get()->format('U');

        $contentType = $responseType = 'text/plain';
        $digest = base64_encode(md5('hello world'));

        $url = $object->signedUploadUrl($ts, [
            'keyFile' => $this->kf,
            'headers' => [
                'x-goog-foo' => ['bar', 'bar'],
                'x-goog-bat' => 'baz'
            ],
            'contentType' => $contentType,
            'contentMd5' => $digest
        ]);

        $input = implode("\n", [
            'POST',
            $digest,
            $contentType,
            $seconds,
            'x-goog-bat:baz',
            'x-goog-foo:bar,bar',
            'x-goog-resumable:start',
            sprintf('/%s/%s', self::BUCKET, $objectName)
        ]);

        $query = explode('?', $url)[1];
        $pieces = explode('&', $query);

        $signature = $this->getSignatureFromSplitUrl($pieces);

        $this->assertTrue($object->___signatureIsCorrect($signature));
        $this->assertEquals($object->input, $input);
    }

    /**
     * @group storage-signed-url
     */
    public function testBeginSignedUploadSession()
    {
        $ts = new Timestamp(new \DateTime('+1 minute'));

        $seconds = $ts->get()->format('U');

        $rw = $this->prophesize(RequestWrapper::class);
        $test = $this;
        $sessionUri = 'http://example.com';

        $rw->send(Argument::type(RequestInterface::class), Argument::type('array'))
            ->will(function ($args) use ($sessionUri, $test) {

                $res = $test->prophesize(ResponseInterface::class);
                $res->getHeaderLine('Location')
                    ->willReturn($sessionUri);

                return $res->reveal();
            });

        $this->connection->requestWrapper()
            ->willReturn($rw->reveal());

        $object = new StorageObjectSignatureStub(
            $this->connection->reveal(),
            self::OBJECT,
            'bucket',
            'foo'
        );

        $uri = $object->beginSignedUploadSession([
            'keyFile' => $this->kf,
        ]);

        $this->assertEquals($sessionUri, $uri);
    }

    /**
     * @group storage-signed-url
     */
    public function testBeginSignedUploadSessionWithOrigin()
    {
        $ts = new Timestamp(new \DateTime('+1 minute'));

        $seconds = $ts->get()->format('U');

        $rw = $this->prophesize(RequestWrapper::class);
        $test = $this;
        $sessionUri = 'http://example.com';

        $rw->send(Argument::that(function ($arg) {
            if (!($arg instanceof RequestInterface)) {
                return false;
            }

            if ($arg->getHeaderLine('Origin') !== 'http://google.com') {
                return false;
            }

            return true;
        }), Argument::type('array'))
            ->will(function ($args) use ($sessionUri, $test) {
                $res = $test->prophesize(ResponseInterface::class);
                $res->getHeaderLine('Location')
                    ->willReturn($sessionUri);

                return $res->reveal();
            });

        $this->connection->requestWrapper()
            ->willReturn($rw->reveal());

        $object = new StorageObjectSignatureStub($this->connection->reveal(), 'object.txt', 'bucket', 'foo');

        $uri = $object->beginSignedUploadSession([
            'keyFile' => $this->kf,
            'origin' => 'http://google.com'
        ]);

        $this->assertEquals($sessionUri, $uri);
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidExpiration()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime('yesterday'));
        $object->signedUrl($ts);
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidMethod()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));
        $object->signedUrl($ts, [
            'method' => 'FOO'
        ]);
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidMethodMissingAllowPostOption()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));
        $object->signedUrl($ts, [
            'method' => 'POST'
        ]);
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidKeyFilePath()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $url = $object->signedUrl($ts, [
            'keyFilePath' => __DIR__ .'/InfiniteMonkeysOnInfiniteKeyboardsWouldTypeThisStringGivenInfiniteTime.json',
        ]);
    }

    /**
     * @group storage-signed-url
     * @expectedException InvalidArgumentException
     */
    public function testSignedUrlInvalidKeyFilePathData()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $url = $object->signedUrl($ts, [
            'keyFilePath' => __FILE__,
        ]);
    }

    /**
     * @group storage-signed-url
     * @expectedException RuntimeException
     */
    public function testSignedUrlInvalidKeyFileMissingPrivateKey()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $url = $object->signedUrl($ts, [
            'keyFile' => ['client_email' => 'test@example.com'],
        ]);
    }

    /**
     * @group storage-signed-url
     * @expectedException RuntimeException
     */
    public function testSignedUrlInvalidKeyFileMissingClientEmail()
    {
        $object = new StorageObject($this->connection->reveal(), self::OBJECT, self::BUCKET);
        $ts = new Timestamp(new \DateTime(self::TIMESTAMP));

        $url = $object->signedUrl($ts, [
            'keyFile' => ['private_key' => '-----BEGIN PRIVATE KEY-----'],
        ]);
    }

    public function testRequesterPays()
    {
        $this->connection->getObject(Argument::withEntry('userProject', 'foo'))
            ->willReturn([]);

        $object = new StorageObject(
            $this->connection->reveal(),
            'object',
            'bucket',
            null,
            [
                'requesterProjectId' => 'foo'
            ]
        );

        $object->reload();
    }

    private function getSignatureFromSplitUrl(array $pieces)
    {
        return trim(current(array_filter($pieces, function ($piece) {
            return strpos($piece, 'Signature') !== false;
        })), 'Signature=');
    }
}

//@codingStandardsIgnoreStart
class StorageObjectSignatureStub extends StorageObject
{
    const SIGNATURE = 'foo';
    public $input;

    protected function signString($privateKey, $data, $forceOpenssl = false)
    {
        $this->input = $data;
        return self::SIGNATURE;
    }

    public function ___signatureIsCorrect($signature)
    {
        return base64_decode(urldecode($signature)) === self::SIGNATURE;
    }
}
//@codingStandardsIgnoreEnd
