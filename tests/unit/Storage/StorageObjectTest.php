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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Psr7;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\StreamInterface;

/**
 * @group storage
 */
class StorageObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConnectionInterface|ObjectProphecy */
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testGetAcl()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Acl', $object->acl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getObject(Argument::any())->willReturn(['name' => 'object.txt']);
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertTrue($object->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getObject(Argument::any())->willThrow(new NotFoundException(null));
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertFalse($object->exists());
    }

    public function testDelete()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertNull($object->delete());
    }

    public function testUpdatesData()
    {
        $object = 'object.txt';
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
        $object = 'object.txt';
        $bucket = 'bucket';
        $predefinedAcl = ['predefinedAcl' => 'private'];
        $this->connection->patchObject($predefinedAcl + [
            'bucket' => $bucket,
            'object' => $object,
            'generation' => null,
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
        $objectName = 'object.txt';
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
        $sourceObject = 'object.txt';
        $bucketConnection = $this->prophesize(ConnectionInterface::class)->reveal();
        $destinationBucketName = 'bucket2';
        $destinationBucket = new Bucket($bucketConnection, $destinationBucketName);
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
        $object = new StorageObject($this->connection->reveal(), 'object.txt.', 'bucket');
        $copiedObject = $object->copy($object);
    }

    public function testRewriteObjectWithDefaultName()
    {
        $sourceBucket = 'bucket';
        $destinationBucket = 'bucket2';
        $objectName = 'object.txt';
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
        $sourceObject = 'object.txt';
        $bucketConnection = $this->prophesize(ConnectionInterface::class)->reveal();
        $destinationBucketName = 'bucket2';
        $destinationBucket = new Bucket($bucketConnection, $destinationBucketName);
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
        $object = new StorageObject($this->connection->reveal(), 'object.txt.', 'bucket');
        $copiedObject = $object->rewrite($object);
    }

    public function testRenamesObject()
    {
        $sourceBucket = 'bucket';
        $objectName = 'object.txt';
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
        $object = 'object.txt';
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
                'bucket' => $bucket,
                'object' => $object,
                'generation' => null,
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
        $object = 'object.txt';
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
                'bucket' => $bucket,
                'object' => $object,
                'generation' => null,
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

        $this->assertEquals($string, $object->downloadToFile('php://temp', [
                'encryptionKey' => $key,
                'encryptionKeySHA256' => $hash
            ])
            ->getContents()
        );
    }

    public function testGetBodyWithoutExtraOptions()
    {
        $bucket = 'bucket';
        $object = 'object.txt';
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
            'bucket' => $bucket,
            'object' => $object,
            'generation' => null,
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
        $object = 'object.txt';
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject([
            'bucket' => $bucket,
            'object' => $object,
            'generation' => null,
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
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket', null, $objectInfo);

        $this->assertEquals($objectInfo, $object->info());
    }

    public function testGetsInfoWithReload()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = 'object.txt';
        $objectInfo = [
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $this->connection->getObject([
                'bucket' => $bucket,
                'object' => $object,
                'generation' => null,
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
        $object = new StorageObject($this->connection->reveal(), $name = 'object.txt', 'bucket');

        $this->assertEquals($name, $object->name());
    }

    public function testGetsIdentity()
    {
        $object = new StorageObject($this->connection->reveal(), $name = 'object.txt', $bucketName = 'bucket');

        $this->assertEquals($name, $object->identity()['object']);
        $this->assertEquals($bucketName, $object->identity()['bucket']);
    }

    public function testGetsGcsUri()
    {
        $object = new StorageObject($this->connection->reveal(), $name = 'object.txt', $bucketName = 'bucket');

        $expectedUri = sprintf('gs://%s/%s', $bucketName, $name);
        $this->assertEquals($expectedUri, $object->gcsUri());
    }

    public function testRequesterPays()
    {
        $this->connection->getObject(Argument::withEntry('userProject', 'foo'))
            ->willReturn([]);

        $object = new StorageObject($this->connection->reveal(), 'object', 'bucket', null, ['requesterProjectId' => 'foo']);

        $object->reload();
    }
}
