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
use Google\Cloud\Core\RequestWrapper;
use Psr\Http\Message\RequestInterface;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Core\Upload\AbstractUploader;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 * @group storage-requesterpays
 */
class RequesterPaysTest extends TestCase
{
    const PROJECT = 'example_project';
    const USER_PROJECT = 'foobar';
    const BUCKET = 'bucket';
    const OBJ = 'object';
    const NOTIFICATION = 'notification';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = new Rest(['projectId' => self::PROJECT]);
        $this->client = \Google\Cloud\Dev\stub(StorageClient::class);
    }

    /**
     * @dataProvider methods
     */
    public function testRequesterPaysMethods(callable $invoke, $res = [])
    {
        // we're using a real connection instance, but the request handler is stubbed out
        // to throw the request query string back to us.
        $this->connection->setRequestWrapper(new RequestWrapperStub);
        $this->client->___setProperty('connection', $this->connection);

        $this->checkRequest($invoke);
    }

    public function methods()
    {
        $uploader = $this->prophesize(AbstractUploader::class);
        $uploader->upload()->willReturn(['name' => self::OBJ, 'generation' => 'foo']);

        return [
            [
                function ($client) {
                    return $this->bucket($client)->acl()->delete('foo');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->acl()->get();
                },
                ['items' => []]
            ], [
                function ($client) {
                    return $this->bucket($client)->acl()->add('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->acl()->update('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->delete();
                }
            ], [
                function ($client) {
                    return $client->createBucket('foo', ['userProject' => self::USER_PROJECT]);
                }
            ], [
                function ($client) {
                    return $client->buckets(['userProject' => self::USER_PROJECT])->current();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->reload();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->iam()->policy();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->iam()->setPolicy([]);
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->iam()->testPermissions([]);
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->update();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->delete('foo');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->get(['entity' => 'foo']);
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->get();
                },
                ['items' => []]
            ], [
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->add('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->update('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->object($client)->acl()->delete('foo');
                }
            ], [
                function ($client) {
                    return $this->object($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                function ($client) {
                    return $this->object($client)->acl()->get();
                },
                ['items' => []]
            ], [
                function ($client) {
                    return $this->object($client)->acl()->add('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->object($client)->acl()->update('foo', 'bar');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->compose([
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
                function ($client) {
                    return $this->object($client)->copy(self::BUCKET);
                }, [
                    'name' => 'foo',
                    'bucket' => 'foo',
                    'generation' => 'foo'
                ]
            ], [
                function ($client) {
                    return $this->object($client)->delete();
                }
            ], [
                function ($client) {
                    return $this->object($client)->reload();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->upload('foo', ['name' => self::OBJ]);
                },
                $uploader->reveal()
            ], [
                function ($client) {
                    return $this->bucket($client)->objects()->current();
                }
            ], [
                function ($client) {
                    return $this->object($client)->update([]);
                }
            ], [
                function ($client) {
                    return $this->object($client)->rewrite(self::BUCKET);
                }, [
                    'resource' => [
                        'name' => 'foo',
                        'bucket' => 'foo',
                        'generation' => 'foo'
                    ]
                ]
            ], [
                function ($client) {
                    return $this->notification($client)->reload();
                }
            ], [
                function ($client) {
                    return $this->notification($client)->delete();
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->createNotification('topic');
                }
            ], [
                function ($client) {
                    return $this->bucket($client)->notifications()->current();
                }
            ]
        ];
    }

    public function testUserProjectCreateBucket()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);
        $connection->insertBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);
        $connection->listObjects(['bucket' => 'foo', 'userProject' => self::USER_PROJECT])
            ->shouldBeCalled()
            ->willReturn([
                'objects' => []
            ]);

        $this->client->___setProperty('connection', $connection->reveal());

        $bucket = $this->client->createBucket('foo', [
            'userProject' => self::USER_PROJECT
        ]);

        $bucket->objects()->current();
    }

    public function testUserProjectCreateBucketDisableUserProject()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);
        $connection->insertBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);
        $connection->listObjects(['bucket' => 'foo', 'userProject' => null])
            ->shouldBeCalled()
            ->willReturn([
                'objects' => []
            ]);

        $this->client->___setProperty('connection', $connection->reveal());

        $bucket = $this->client->createBucket('foo', [
            'userProject' => self::USER_PROJECT,
            'bucketUserProject' => false
        ]);

        $bucket->objects()->current();
    }

    public function testUserProjectListBuckets()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);
        $connection->listBuckets(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'name' => 'foo'
                    ]
                ]
            ]);

        $connection->listObjects(['bucket' => 'foo', 'userProject' => self::USER_PROJECT])
            ->shouldBeCalled()
            ->willReturn([
                'objects' => []
            ]);

        $this->client->___setProperty('connection', $connection->reveal());
        $bucket = $this->client->buckets(['userProject' => self::USER_PROJECT])->current();
        $bucket->objects()->current();
    }

    public function testUserProjectListBucketsDisableUserProject()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);
        $connection->listBuckets(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'name' => 'foo'
                    ]
                ]
            ]);

        $connection->listObjects(['bucket' => 'foo', 'userProject' => null])
            ->shouldBeCalled()
            ->willReturn([
                'objects' => []
            ]);

        $this->client->___setProperty('connection', $connection->reveal());
        $bucket = $this->client->buckets(['userProject' => self::USER_PROJECT, 'bucketUserProject' => false])->current();
        $bucket->objects()->current();
    }

    public function testUserProjectCreateNotification()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);

        $connection->insertNotification(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled()
            ->willReturn([
                'id' => 'foo'
            ]);

        $connection->getNotification(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled();

        $this->client->___setProperty('connection', $connection->reveal());

        $bucket = $this->client->bucket('foo', self::USER_PROJECT);

        $notification = $bucket->createNotification('foo');
        $notification->reload();
    }

    public function testUserProjectNotification()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);

        $connection->getNotification(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled();

        $this->client->___setProperty('connection', $connection->reveal());

        $bucket = $this->client->bucket('foo', self::USER_PROJECT);

        $notification = $bucket->notification('foo');
        $notification->reload();
    }

    public function testUserProjectListNotifications()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()->willReturn(self::PROJECT);

        $connection->listNotifications(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'id' => 'foo'
                    ]
                ]
            ]);

        $connection->getNotification(Argument::withEntry('userProject', self::USER_PROJECT))
            ->shouldBeCalled();

        $this->client->___setProperty('connection', $connection->reveal());

        $bucket = $this->client->bucket('foo', self::USER_PROJECT);

        $notification = $bucket->notifications()->current();
        $notification->reload();
    }

    private function checkRequest(callable $invoke)
    {
        try {
            $invoke($this->client);

            // if no exception, something is wrong.
            $this->assertTrue(false);
        } catch(\Exception $e) {
            parse_str($e->getMessage(), $query);
            $this->assertEquals(self::USER_PROJECT, $query['userProject']);
        }
    }

    private function bucket(StorageClient $client)
    {
        return $client->bucket(self::BUCKET, self::USER_PROJECT);
    }

    private function object(StorageClient $client)
    {
        return $this->bucket($client)->object(self::OBJ);
    }

    private function notification(StorageClient $client)
    {
        return $this->bucket($client)->notification(self::NOTIFICATION);
    }
}

class RequestWrapperStub extends RequestWrapper
{
    public function send(RequestInterface $request, array $options = [])
    {
        // to short circuit all the response handling and get back to the assertion with the query string.
        throw new \Exception($request->getUri()->getQuery());
    }
}
