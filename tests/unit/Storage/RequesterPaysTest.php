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

/**
 * @group storage
 * @group storage-requesterpays
 */
class RequesterPaysTest extends \PHPUnit_Framework_TestCase
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
    public function testRequesterPaysMethods($mockedMethod, callable $invoke, $res = [])
    {
        // we're using a real connection instance, but the request handler is stubbed out
        // to throw the request query string back to us.
        $this->connection->setRequestWrapper(new RequestWrapperStub);
        $this->client->___setProperty('connection', $this->connection);

        try {
            $invoke($this->client);

            // if no exception, something is wrong.
            $this->assertTrue(false);
        } catch(\Exception $e) {
            parse_str($e->getMessage(), $query);
            $this->assertEquals(self::USER_PROJECT, $query['userProject']);
        }
    }

    public function methods()
    {
        $uploader = $this->prophesize(AbstractUploader::class);
        $uploader->upload()->willReturn(['name' => self::OBJ, 'generation' => 'foo']);

        return [
            [
                'deleteAcl',
                function ($client) {
                    return $this->bucket($client)->acl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    return $this->bucket($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    return $this->bucket($client)->acl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    return $this->bucket($client)->acl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    return $this->bucket($client)->acl()->update('foo', 'bar');
                }
            ], [
                'deleteBucket',
                function ($client) {
                    return $this->bucket($client)->delete();
                }
            ], [
                'insertBucket',
                function ($client) {
                    return $client->createBucket('foo', ['userProject' => self::USER_PROJECT]);
                }
            ], [
                'listBuckets',
                function ($client) {
                    return $client->buckets(['userProject' => self::USER_PROJECT])->current();
                }
            ], [
                'getBucket',
                function ($client) {
                    return $this->bucket($client)->reload();
                }
            ], [
                'getBucketIamPolicy',
                function ($client) {
                    return $this->bucket($client)->iam()->policy();
                }
            ], [
                'setBucketIamPolicy',
                function ($client) {
                    return $this->bucket($client)->iam()->setPolicy([]);
                }
            ], [
                'testBucketIamPermissions',
                function ($client) {
                    return $this->bucket($client)->iam()->testPermissions([]);
                }
            ], [
                'patchBucket',
                function ($client) {
                    return $this->bucket($client)->update();
                }
            ], [
                'deleteAcl',
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    return $this->bucket($client)->defaultAcl()->update('foo', 'bar');
                }
            ], [
                'deleteAcl',
                function ($client) {
                    return $this->object($client)->acl()->delete('foo');
                }
            ], [
                'getAcl',
                function ($client) {
                    return $this->object($client)->acl()->get(['entity' => 'foo']);
                }
            ], [
                'listAcl',
                function ($client) {
                    return $this->object($client)->acl()->get();
                },
                ['items' => []]
            ], [
                'insertAcl',
                function ($client) {
                    return $this->object($client)->acl()->add('foo', 'bar');
                }
            ], [
                'patchAcl',
                function ($client) {
                    return $this->object($client)->acl()->update('foo', 'bar');
                }
            ], [
                'composeObject',
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
                'copyObject',
                function ($client) {
                    return $this->object($client)->copy(self::BUCKET);
                }, [
                    'name' => 'foo',
                    'bucket' => 'foo',
                    'generation' => 'foo'
                ]
            ], [
                'deleteObject',
                function ($client) {
                    return $this->object($client)->delete();
                }
            ], [
                'getObject',
                function ($client) {
                    return $this->object($client)->reload();
                }
            ], [
                'insertObject',
                function ($client) {
                    return $this->bucket($client)->upload('foo', ['name' => self::OBJ]);
                },
                $uploader->reveal()
            ], [
                'listObjects',
                function ($client) {
                    return $this->bucket($client)->objects()->current();
                }
            ], [
                'patchObject',
                function ($client) {
                    return $this->object($client)->update([]);
                }
            ], [
                'rewriteObject',
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
                'getNotification',
                function ($client) {
                    return $this->notification($client)->reload();
                }
            ], [
                'deleteNotification',
                function ($client) {
                    return $this->notification($client)->delete();
                }
            ], [
                'insertNotification',
                function ($client) {
                    return $this->bucket($client)->createNotification('topic');
                }
            ], [
                'listNotifications',
                function ($client) {
                    return $this->bucket($client)->notifications()->current();
                }
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