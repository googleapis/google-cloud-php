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

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\SignBlobInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\KeyPairGenerateTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\SigningHelper;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 * @group storage-object
 */
class StorageObjectTest extends TestCase
{
    use ExpectException;
    use KeyPairGenerateTrait;

    const TIMESTAMP = '2025-01-01';
    const BUCKET = 'bucket';
    const OBJECT = 'object.txt';

    /** @var Rest|ObjectProphecy */
    public $connection;

    private $key;
    private $kf;

    public function set_up()
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

    public function testCopyObjectThrowsExceptionWithInvalidType()
    {
        $this->expectException('\InvalidArgumentException');

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

    public function testRewriteObjectThrowsExceptionWithInvalidType()
    {
        $this->expectException('\InvalidArgumentException');

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

    public function testRenamesObjectWithDestinationBucket()
    {
        $sourceBucket = 'bucket';
        $destinationBucket = 'bucket2';
        $objectName = self::OBJECT;
        $newObjectName = 'new-name.txt';
        $acl = 'private';
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $this->connection->copyObject([
                'sourceBucket' => $sourceBucket,
                'sourceObject' => $objectName,
                'destinationBucket' => $destinationBucket,
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
            'encryptionKeySHA256' => $hash,
            'destinationBucket' => $destinationBucket
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
        $stream = Utils::streamFor($string = 'abcdefg');
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
        $stream = Utils::streamFor($string = 'abcdefg');
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

    public function testDownloadAsStreamWithoutExtraOptions()
    {
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Utils::streamFor($string = 'abcdefg');
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

    public function testDownloadAsStreamWithExtraOptions()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Utils::streamFor($string = 'abcdefg');
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

    public function testDownloadAsStreamAsync()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode('1234');
        $bucket = 'bucket';
        $object = self::OBJECT;
        $stream = Utils::streamFor($string = 'abcdefg');
        $this->connection->downloadObjectAsync([
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
            ->willReturn(Promise\promise_for($stream));

        $object = new StorageObject($this->connection->reveal(), $object, $bucket);

        $promise = $object->downloadAsStreamAsync([
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $hash
        ]);

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        $result = $promise->wait();

        $this->assertInstanceOf(StreamInterface::class, $result);
        $this->assertEquals($string, $result);
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

    /**
     * @group storage-signed-url
     * @dataProvider urlVersion
     */
    public function testSignedUrlVersions($version, $method)
    {
        $expectedResource = sprintf('/%s/%s', self::BUCKET, self::OBJECT);
        $expectedGeneration = 11111;
        $expectedExpiration = time() + 10;
        $return = 'signedUrl';

        $object = $this->getStorageObjectForSigning(null, '', $expectedGeneration);

        $signingHelper = $this->prophesize(SigningHelper::class);

        $signingHelper->sign(
            Argument::type(ConnectionInterface::class),
            $expectedExpiration,
            $expectedResource,
            $expectedGeneration,
            $version ? Argument::withEntry('version', $version) : Argument::type('array')
        )->shouldBeCalled()->willReturn($return);

        $opts = [
            'helper' => $signingHelper->reveal()
        ];
        if ($version) {
            // test defaults to v2.
            $opts['version'] = $version;
        }

        $res = $object->signedUrl($expectedExpiration, $opts);

        $this->assertEquals($return, $res);
    }

    /**
     * @group storage-signed-url
     */
    public function testInvalidSigningVersion()
    {
        $this->expectException('InvalidArgumentException');
        $object = $this->getStorageObjectForSigning();
        $object->signedUrl(time()+1, [
            'version' => uniqid()
        ]);
    }

    /**
     * @group storage-signed-url
     * @dataProvider signedUrlKeyfiles
     */
    public function testSignedUrlWithKeyFile($key, $value)
    {
        $expectedScope = 'foobar';
        $object = $this->getStorageObjectForSigning(null, $expectedScope);

        $signingHelper = $this->prophesize(SigningHelper::class);
        $method = SigningHelper::DEFAULT_URL_SIGNING_VERSION . 'Sign';
        $signingHelper->sign(
            Argument::type(ConnectionInterface::class),
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->shouldBeCalled()->will(function ($args) {
            return $args;
        });

        $callArgs = $object->signedUrl(time() + 1, [
            $key => $value,
            'helper' => $signingHelper->reveal()
        ]);

        $path = \Google\Cloud\Core\Testing\Snippet\Fixtures::KEYFILE_STUB_FIXTURE();
        $json = json_decode(file_get_contents($path), true);

        $this->assertEquals('', $callArgs[0]->requestWrapper()->getCredentialsFetcher()->getClientName());
    }

    public function signedUrlKeyfiles()
    {
        $path = \Google\Cloud\Core\Testing\Snippet\Fixtures::KEYFILE_STUB_FIXTURE();
        $json = json_decode(file_get_contents($path), true);

        return [
            ['keyFilePath', $path],
            ['keyFile', $json]
        ];
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUrlInvalidKeyFilePath()
    {
        $this->expectException('InvalidArgumentException');
        $object = $this->getStorageObjectForSigning();
        $object->signedUrl(time(), [
            'keyFilePath' => __DIR__ . '/foo/bar/json.json'
        ]);
    }

    /**
     * @group storage-signed-url
     */
    public function testSignedUrlInvalidKeyFileData()
    {
        $this->expectException('InvalidArgumentException');
        $file = tmpfile();
        $path = stream_get_meta_data($file)['uri'];
        fwrite($file, '{');

        $object = $this->getStorageObjectForSigning();
        $object->signedUrl(time(), [
            'keyFilePath' => $path
        ]);

        fclose($file);
    }

    /**
     * @group storage-signed-url
     * @dataProvider urlVersion
     */
    public function testSignedUploadUrl($version, $method)
    {
        $expectedExpiration = time() + 1;
        $return = 'signedUrl';

        $signingHelper = $this->prophesize(SigningHelper::class);
        $signingHelper->sign(
            Argument::any(),
            $expectedExpiration,
            Argument::any(),
            Argument::any(),
            Argument::allOf(
                Argument::withEntry('method', 'POST'),
                Argument::withEntry('allowPost', true),
                Argument::withEntry('headers', [
                    'x-goog-resumable' => 'start'
                ]),
                $version ? Argument::withEntry('version', $version) : Argument::not(false)
            )
        )->willReturn($return);

        $object = $this->getStorageObjectForSigning();

        $opts = [
            'cname' => 'example.com',
            'saveAsName' => 'test.txt',
            'responseDisposition' => 'test',
            'responseType' => 'test',
            'helper' => $signingHelper->reveal()
        ];

        if ($version) {
            $opts['version'] = $version;
        }

        $res = $object->signedUploadUrl($expectedExpiration, $opts);

        $this->assertEquals($return, $res);
    }

    /**
     * @group storage-signed-url
     * @dataProvider urlVersion
     */
    public function testBeginSignedUploadSession($version, $method)
    {
        // do this first.
        $object = $this->getStorageObjectForSigning();

        $signedUri = 'http://example.com/a';
        $sessionUri = 'http://example.com/b';

        $res = $this->prophesize(ResponseInterface::class);
        $res->getHeaderLine('Location')->willReturn($sessionUri);

        $creds = $this->prophesize(SignBlobInterface::class);
        $rw = $this->prophesize(RequestWrapper::class);
        $rw->scopes()->willReturn('');
        $rw->getCredentialsFetcher()->willReturn($creds->reveal());
        $rw->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(function ($args) use ($res, $signedUri) {
            if ((string) $args[0]->getUri() !== $signedUri) {
                throw new \Exception('Incorrect Signed URI.');
            }

            return $res->reveal();
        });

        $this->connection->requestWrapper()->willReturn($rw->reveal());

        $signingHelper = $this->prophesize(SigningHelper::class);
        $signingHelper->sign(
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::any(),
            $version ? Argument::withEntry('version', $version) : Argument::any()
        )->willReturn($signedUri);

        $object->___setProperty('connection', $this->connection->reveal());

        $opts = [
            'helper' => $signingHelper->reveal()
        ];
        if ($version) {
            $opts['version'] = $version;
        }

        $res = $object->beginSignedUploadSession($opts);
        $this->assertEquals($sessionUri, $res);
    }

    public function urlVersion()
    {
        return [
            [null, SigningHelper::DEFAULT_URL_SIGNING_VERSION . 'Sign'],
            ['v2', 'v2Sign'],
            ['v4', 'v4Sign']
        ];
    }

    private function getStorageObjectForSigning(
        SignBlobInterface $credentials = null,
        $scopes = '',
        $generation = null
    ) {
        if ($credentials === null) {
            $credentials = $this->prophesize(SignBlobInterface::class);
            $credentials = $credentials->reveal();
        }

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->scopes()->willReturn(is_array($scopes) ? $scopes : [$scopes]);
        $rw->getCredentialsFetcher()->willReturn($credentials);

        $this->connection->requestWrapper()->willReturn($rw->reveal());

        return TestHelpers::stub(StorageObject::class, [
            $this->connection->reveal(),
            self::OBJECT,
            self::BUCKET,
            $generation
        ], ['connection']);
    }
}
