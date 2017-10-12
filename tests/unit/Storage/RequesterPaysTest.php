<?php
/**
 * Copyright 2017 Google Inc.
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

use Prophecy\Argument;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\Connection\Rest;

/**
 * @group storage
 * @group storage-requesterpays
 */
class RequesterPaysTest extends \PHPUnit_Framework_TestCase
{
    const USER_PROJECT = 'foobar';
    const BUCKET = 'bucket';
    const OBJ = 'object';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->client = \Google\Cloud\Dev\stub(StorageClient::class);
    }

    /**
     * @dataProvider methods
     */
    public function testRequesterPaysMethods($mockedMethod, callable $invoke, $res = [])
    {
        $this->connection->projectId()->willReturn(self::USER_PROJECT);

        $this->connection->$mockedMethod(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $invoke($this->client);
    }

    public function methods()
    {
        $uploader = $this->prophesize(AbstractUploader::class);
        $uploader->upload()->willReturn(['name' => self::OBJ, 'generation' => 'foo']);

        return [
            [
                'deleteAcl',
                function ($client) {
                    $this->bucket($client)->acl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    $this->bucket($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    $this->bucket($client)->acl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    $this->bucket($client)->acl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    $this->bucket($client)->acl()->update('foo', 'bar');
                }
            ], [
                'deleteBucket',
                function ($client) {
                    $this->bucket($client)->delete();
                }
            ], [
                'insertBucket',
                function ($client) {
                    $client->createBucket('foo', ['userProject' => self::USER_PROJECT]);
                }
            ], [
                'listBuckets',
                function ($client) {
                    $client->buckets(['userProject' => self::USER_PROJECT])->current();
                }
            ], [
                'getBucket',
                function ($client) {
                    $this->bucket($client)->reload();
                }
            ], [
                'getBucketIamPolicy',
                function ($client) {
                    $this->bucket($client)->iam()->policy();
                }
            ], [
                'setBucketIamPolicy',
                function ($client) {
                    $this->bucket($client)->iam()->setPolicy([]);
                }
            ], [
                'testBucketIamPermissions',
                function ($client) {
                    $this->bucket($client)->iam()->testPermissions([]);
                }
            ], [
                'patchBucket',
                function ($client) {
                    $this->bucket($client)->update();
                }
            ], [
                'deleteAcl',
                function ($client) {
                    $this->bucket($client)->defaultAcl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    $this->bucket($client)->defaultAcl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    $this->bucket($client)->defaultAcl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    $this->bucket($client)->defaultAcl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    $this->bucket($client)->defaultAcl()->update('foo', 'bar');
                }
            ], [
                'deleteAcl',
                function ($client) {
                    $this->object($client)->acl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    $this->object($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    $this->object($client)->acl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    $this->object($client)->acl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    $this->object($client)->acl()->update('foo', 'bar');
                }
            ], [
                'composeObject',
                function ($client) {
                    $this->bucket($client)->compose([
                        $this->object($client),
                        $this->object($client)
                    ], 'foo', [
                        'destination' => [
                            'contentType' => 'bar'
                        ]
                    ]);
                }, [
                    'name' => 'foo',
                    'generation' => 'bar'
                ]
            ], [
                'copyObject',
                function ($client) {
                    $this->object($client)->copy(self::BUCKET);
                }, [
                    'name' => 'foo',
                    'bucket' => 'foo',
                    'generation' => 'foo'
                ]
            ], [
                'deleteObject',
                function ($client) {
                    $this->object($client)->delete();
                }
            ], [
                'getObject',
                function ($client) {
                    $this->object($client)->reload();
                }
            ], [
                'insertObject',
                function ($client) {
                    $this->bucket($client)->upload('foo', ['name' => self::OBJ]);
                },
                $uploader->reveal()
            ], [
                'listObjects',
                function ($client) {
                    $this->bucket($client)->objects()->current();
                }
            ], [
                'patchObject',
                function ($client) {
                    $this->object($client)->update([]);
                }
            ], [
                'rewriteObject',
                function ($client) {
                    $this->object($client)->rewrite(self::BUCKET);
                }, [
                    'resource' => [
                        'name' => 'foo',
                        'bucket' => 'foo',
                        'generation' => 'foo'
                    ]
                ]
            ]
        ];
    }

    private function bucket(StorageClient $client)
    {
        return $client->bucket(self::BUCKET, self::USER_PROJECT);
    }

    private function object(StorageClient $client)
    {
        return $this->bucket($client)->object(self::OBJ);
    }
}
