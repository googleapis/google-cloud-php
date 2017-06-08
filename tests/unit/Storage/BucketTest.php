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
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group storage
 */
class BucketTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $resumableUploader;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->resumableUploader = $this->prophesize(ResumableUploader::class);
    }

    public function testGetsAcl()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf(Acl::class, $bucket->acl());
    }

    public function testGetsDefaultAcl()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf(Acl::class, $bucket->defaultAcl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertTrue($bucket->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getBucket(Argument::any())->willThrow(new NotFoundException(null));
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertFalse($bucket->exists());
    }

    public function testUploadData()
    {
        $this->resumableUploader->upload()->willReturn([
            'name' => 'file.txt',
            'generation' => 123
        ]);
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf(
            StorageObject::class,
            $bucket->upload('some data to upload', ['name' => 'data.txt'])
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadDataAsStringWithNoName()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $bucket->upload('some more data');
    }

    public function testGetResumableUploader()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader->reveal());
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf(
            ResumableUploader::class,
            $bucket->getResumableUploader('some data to upload', ['name' => 'data.txt'])
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetResumableUploaderWithStringWithNoName()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $bucket->getResumableUploader('some more data');
    }

    public function testGetObject()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf(StorageObject::class, $bucket->object('peter-venkman.jpg'));
    }

    public function testInstantiateObjectWithOptions()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $object = $bucket->object('peter-venkman.jpg', [
            'generation' => '5',
            'encryptionKey' => 'abc',
            'encryptionKeySHA256' => '123'
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
    }

    public function testGetsObjectsWithoutToken()
    {
        $this->connection->listObjects(Argument::any())->willReturn([
            'items' => [
                [
                    'name' => 'file.txt',
                    'generation' => 'abc'
                ]
            ]
        ]);

        $bucket = new Bucket($this->connection->reveal(), 'bucket');
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file.txt', $objects[0]->name());
    }

    public function testGetsObjectsWithToken()
    {
        $this->connection->listObjects(Argument::any())->willReturn(
            [
                'nextPageToken' => 'token',
                'items' => [
                    [
                        'name' => 'file.txt',
                        'generation' => 'abc'
                    ]
                ]
            ],
                [
                'items' => [
                    [
                        'name' => 'file2.txt',
                        'generation' => 'def'
                    ]
                ]
            ]
        );

        $bucket = new Bucket($this->connection->reveal(), 'bucket');
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file2.txt', $objects[1]->name());
    }

    public function testDelete()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertNull($bucket->delete());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testComposeThrowsExceptionWithLessThanTwoSources()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $bucket->compose(['file1.txt'], 'combined-files.txt');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testComposeThrowsExceptionWithUnknownContentType()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $bucket->compose(['file1.txt', 'file2.txt'], 'combined-files.abc');
    }

    /**
     * @dataProvider composeProvider
     */
    public function testComposesObjects(
        $metadata,
        $objects,
        $expectedSourceObjects
    ) {
        $acl = 'private';
        $destinationBucket = 'bucket';
        $destinationObject = 'combined-files.txt';
        $this->connection->composeObject([
                'destinationBucket' => $destinationBucket,
                'destinationObject' => $destinationObject,
                'destinationPredefinedAcl' => $acl,
                'destination' => $metadata + ['contentType' => 'text/plain'],
                'sourceObjects' => $expectedSourceObjects,
            ])
            ->willReturn([
                'name' => $destinationObject,
                'generation' => 1
            ])
            ->shouldBeCalledTimes(1);
        $bucket = new Bucket($this->connection->reveal(), $destinationBucket);

        $object = $bucket->compose($objects, $destinationObject, [
            'predefinedAcl' => $acl,
            'metadata' => $metadata
        ]);

        $this->assertEquals($destinationObject, $object->name());
    }

    public function composeProvider()
    {
        $object1 = $this->prophesize(StorageObject::class);
        $object2 = $this->prophesize(StorageObject::class);
        $name1 = 'file1.txt';
        $name2 = 'file2.txt';
        $object1->name(Argument::any())->willReturn($name1);
        $object1->identity(Argument::any())->willReturn(['generation' => '1']);
        $object2->name(Argument::any())->willReturn($name2);
        $object2->identity(Argument::any())->willReturn(['generation' => '1']);

        return [
            [
                ['test' => true],
                [$name1, $name2],
                [['name' => $name1], ['name' => $name2]]
            ],
            [
                ['contentType' => 'application/json'],
                [$object1->reveal(), $object2->reveal()],
                [
                    ['name' => $name1, 'generation' => '1'],
                    ['name' => $name2, 'generation' => '1']
                ]
            ]
        ];
    }

    public function testUpdatesData()
    {
        $versioningData = [
            'versioning' => [
                'enabled' => true
            ]
        ];
        $this->connection->patchBucket(Argument::any())->willReturn(['name' => 'bucket'] + $versioningData);
        $bucket = new Bucket($this->connection->reveal(), 'bucket', [
            'name' => 'bucket',
            'versioning' => [
                'enabled' => false
            ]
        ]);

        $bucket->update($versioningData);

        $this->assertTrue($bucket->info()['versioning']['enabled']);
    }

    public function testGetsInfo()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $bucket = new Bucket($this->connection->reveal(), 'bucket', $bucketInfo);

        $this->assertEquals($bucketInfo, $bucket->info());
    }

    public function testGetsInfoWithForce()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $this->connection->getBucket(Argument::any())
            ->willReturn($bucketInfo)
            ->shouldBeCalledTimes(1);
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertEquals($bucketInfo, $bucket->info());
    }

    public function testGetsName()
    {
        $bucket = new Bucket($this->connection->reveal(), $name = 'bucket');

        $this->assertEquals($name, $bucket->name());
    }

    public function testIsWritable()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willReturn('http://some-uri/');
        $bucket = new Bucket($this->connection->reveal(), $name = 'bucket');
        $this->assertTrue($bucket->isWritable());
    }

    public function testIsWritableAccessDenied()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willThrow(new ServiceException('access denied', 403));
        $bucket = new Bucket($this->connection->reveal(), $name = 'bucket');
        $this->assertFalse($bucket->isWritable());
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\ServerException
     */
    public function testIsWritableServerException()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willThrow(new ServerException('maintainence'));
        $bucket = new Bucket($this->connection->reveal(), $name = 'bucket');
        $bucket->isWritable(); // raises exception
    }

    public function testIam()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $bucket = new Bucket($this->connection->reveal(), 'bucket', $bucketInfo);

        $this->assertInstanceOf(Iam::class, $bucket->iam());
    }

    public function testRequesterPays()
    {
        $this->connection->getBucket(Argument::withEntry('userProject', 'foo'))
            ->willReturn([]);

        $bucket = new Bucket($this->connection->reveal(), 'bucket', ['requesterProjectId' => 'foo']);

        $bucket->reload();
    }
}
