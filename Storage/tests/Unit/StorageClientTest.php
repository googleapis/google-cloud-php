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

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\CreatedHmacKey;
use Google\Cloud\Storage\HmacKey;
use Google\Cloud\Storage\Lifecycle;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StreamWrapper;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * @group storage
 * @group storage-client
 */
class StorageClientTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'my-project';
    public $connection;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->client = TestHelpers::stub(StorageClient::class, [['projectId' => self::PROJECT]]);
    }

    public function testGetBucket()
    {
        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->assertInstanceOf(Bucket::class, $this->client->bucket('myBucket'));
    }

    public function testGetBucketRequesterPaysDefaultProjectId()
    {
        $this->connection->projectId()->willReturn(self::PROJECT);
        $this->connection->getBucket(Argument::allOf(
            Argument::withEntry('bucket', 'myBucket'),
            Argument::withEntry('userProject', self::PROJECT)
        ))->shouldBeCalled();
        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = $this->client->bucket('myBucket', true);

        $bucket->reload();
    }

    public function testGetSoftDeletedBucket()
    {
        $this->connection->projectId()->willReturn(self::PROJECT);
        $this->connection->getBucket(Argument::any())->shouldBeCalled()
        ->willReturn([
            'name' => 'bucket1',
            'generation' => 123456789,
            'softDeleteTime' => '2024-09-10T01:01:01.045123456Z',
            'hardDeleteTime' => '2024-09-17T01:01:01.045123456Z'
        ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = $this->client->bucket('bucket1', options: ['softDeleted' => true, 'generation' => 123456789]);

        $bucket->reload(['softDeleted' => true, 'generation' => 123456789]);

        $this->assertEquals('bucket1', $bucket->name());
        $this->assertEquals(123456789, $bucket->info()['generation']);
        $this->assertArrayHasKey('softDeleteTime', $bucket->info());
        $this->assertArrayHasKey('hardDeleteTime', $bucket->info());
    }

    public function testGetsSoftDeletedBuckets()
    {
        $this->connection->listBuckets(
            Argument::withEntry('softDeleted', true)
        )->willReturn([
            'items' => [
                ['name' => 'bucket1']
            ]
        ]);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $buckets = iterator_to_array($this->client->buckets(['softDeleted' => true]));

        $this->assertEquals('bucket1', $buckets[0]->name());
    }

    public function testGetsBucketsWithoutToken()
    {
        $this->connection->listBuckets(Argument::any())->willReturn([
            'items' => [
                ['name' => 'bucket1']
            ]
        ]);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $buckets = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket1', $buckets[0]->name());
    }

    public function testGetsBucketsWithToken()
    {
        $this->connection->listBuckets(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'items' => [
                    ['name' => 'bucket1']
                ]
            ], [
                'items' => [
                    ['name' => 'bucket2']
                ]
            ]);

        $this->connection->projectId()
            ->willReturn(self::PROJECT);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket2', $bucket[1]->name());
    }

    public function testRestore()
    {
        $this->connection->restoreBucket(Argument::any())
            ->willReturn([
                'bucket' => 'bucket1',
                'info' => [
                    'generation' => 12345678
                ]
            ]);

        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(Bucket::class, $this->client->restore('bucket1', 123456789));
    }

    public function testCreatesBucket()
    {
        $this->connection->insertBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(Bucket::class, $this->client->createBucket('bucket'));
    }

    public function testCreatesDualRegionBucket()
    {
        $this->connection
            ->insertBucket([
                'project' => self::PROJECT,
                'location' => 'US',
                'name' => 'bucket',
                'customPlacementConfig' => [
                    'dataLocations' => ['US-EAST1', 'US-WEST1'],
                ]
            ])
            ->willReturn(['name' => 'bucket']);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $createdBucket = $this->client->createBucket(
            'bucket',
            [
                'location' => 'US',
                'customPlacementConfig' => [
                    'dataLocations' => ['US-EAST1', 'US-WEST1'],
                ]
            ]
        );

        $this->assertInstanceOf(Bucket::class, $createdBucket);
    }

    public function testCreatesBucketWithLifecycleBuilder()
    {
        $bucket = 'bucket';
        $lifecycleArr = ['test' => 'test'];
        $lifecycle = $this->prophesize(Lifecycle::class);
        $lifecycle->toArray()
            ->willReturn($lifecycleArr);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->connection
            ->insertBucket([
                'project' => self::PROJECT,
                'lifecycle' => $lifecycleArr,
                'name' => $bucket
            ])
            ->willReturn(['name' => $bucket]);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(
            Bucket::class,
            $this->client->createBucket(
                $bucket,
                ['lifecycle' => $lifecycle->reveal()]
            )
        );
    }

    public function testRegisteringStreamWrapper()
    {
        $this->assertTrue($this->client->registerStreamWrapper());
        $this->assertEquals($this->client, StreamWrapper::getClient());
        $this->assertContains('gs', stream_get_wrappers());
        $this->client->unregisterStreamWrapper();
    }

    public function testSignedUrlUploader()
    {
        $uri = 'http://example.com';
        $data = Utils::streamFor('hello world');

        $uploader = $this->client->signedUrlUploader($uri, $data);
        $this->assertInstanceOf(SignedUrlUploader::class, $uploader);
    }

    public function testTimestamp()
    {
        $dt = new \DateTime;
        $ts = $this->client->timestamp($dt);
        $this->assertInstanceOf(Timestamp::class, $ts);
        $this->assertEquals($ts->get(), $dt);
    }

    public function testGetServiceAccount()
    {
        $expectedServiceAccount = self::PROJECT . '@gs-project-accounts.iam.gserviceaccount.com';
        $this->connection->getServiceAccount([
            'projectId' => self::PROJECT,
            'userProject' => self::PROJECT
        ])->willReturn([
            'kind' => 'storage#serviceAccount',
            'email_address' => $expectedServiceAccount
        ])->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(
            $this->client->getServiceAccount(['userProject' => self::PROJECT]),
            $expectedServiceAccount
        );
    }

    public function testHmacKeys()
    {
        $accessId = 'foo';
        $email = 'foo@bar.com';

        $this->connection->listHmacKeys([
            'projectId' => self::PROJECT,
            'serviceAccountEmail' => $email
        ])->shouldBeCalled()->willReturn([
            'items' => [
                [
                    'accessId' => $accessId
                ]
            ]
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $key = iterator_to_array($this->client->hmacKeys([
            'serviceAccountEmail' => $email
        ]))[0];

        $this->assertEquals($accessId, $key->accessId());
        $this->assertEquals(['accessId' => $accessId], $key->info());
    }

    public function testHmacKey()
    {
        $res = $this->client->hmacKey('foo');
        $this->assertInstanceOf(HmacKey::class, $res);
        $this->assertEquals('foo', $res->accessId());
    }

    public function testCreateHmacKey()
    {
        $email = 'foo@bar.com';
        $secret = 'foo';
        $accessId = 'bar';
        $this->connection->createHmacKey([
            'projectId' => self::PROJECT,
            'serviceAccountEmail' => $email
        ])->shouldBeCalled()->willReturn([
            'secret' => $secret,
            'metadata' => [
                'accessId' => $accessId
            ]
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->createHmacKey($email);
        $this->assertInstanceOf(CreatedHmacKey::class, $res);
        $this->assertEquals($secret, $res->secret());
        $this->assertEquals($accessId, $res->hmacKey()->accessId());
        $this->assertEquals(['accessId' => $accessId], $res->hmacKey()->info());
    }

    /**
     * @dataProvider requiresProjectIdMethods
     */
    public function testMethodsFailWithoutProjectId($method, array $args = [])
    {
        $this->expectException(GoogleException::class);

        $client = TestHelpers::stub(StorageClientStub::class, [], ['projectId']);
        $client->___setProperty('projectId', null);

        call_user_func_array([$client, $method], $args);
    }

    public function requiresProjectIdMethods()
    {
        return [
            ['buckets'],
            ['createBucket', ['foo']],
            ['hmacKeys'],
            ['hmacKey', ['foo']],
            ['createHmacKey', ['foo']]
        ];
    }

    private static function getSuccessfulObjectsResponse()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(
                [
                    'items' => [
                        ['name' => 'file.txt']
                    ]
                ]
            )
        );
    }

    private static function getHttpHandlerMock($mockResponses)
    {
        $mockHandler = new MockHandler($mockResponses);
        $handlerStack = HandlerStack::create($mockHandler);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        return [
            $mockHandler,
            function (\Psr\Http\Message\RequestInterface $request, array $options) use ($guzzleClient) {
                return $guzzleClient->send($request, $options);
            }
        ];
    }

    /**
     * @dataProvider providesRetriesConfiguration
     */
    public function testRetriesConfiguration(
        $mockResponses,
        $retries,
        $expectedRemainingResponses,
        $exceptionClass = null
    ) {
        [$mockHandler, $httpHandler] = self::getHttpHandlerMock($mockResponses);

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            'retries' => $retries,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        if ($exceptionClass) {
            $this->expectException($exceptionClass);
        }

        $objects = iterator_to_array($client->bucket('myBucket')->objects());
        
        $this->assertEquals('file.txt', $objects[0]->name());
        $this->assertEquals($expectedRemainingResponses, $mockHandler->count());
    }

    public function providesRetriesConfiguration()
    {
        return [
            // Successful
            [
                [
                    new Response(408),
                    new Response(429),
                    new Response(500),
                    new Response(502),
                    new Response(503),
                    new Response(504),
                    self::getSuccessfulObjectsResponse(),
                ],
                10,
                0,
                null,
            ],
            [
                [
                    new Response(408),
                    new Response(504),
                    self::getSuccessfulObjectsResponse(),
                ],
                10,
                0,
                null,
            ],
            [
                [
                    new Response(408),
                    new Response(504),
                    self::getSuccessfulObjectsResponse(),
                ],
                3,
                0,
                null,
            ],
            [
                [
                    self::getSuccessfulObjectsResponse(),
                ],
                10,
                0,
                null,
            ],
            // Failing with exception
            [
                [
                    new Response(408),
                    new Response(429),
                    new Response(500),
                    new Response(502),
                    new Response(503),
                    new Response(504),
                    self::getSuccessfulObjectsResponse(),
                ],
                3,
                0,
                ServiceException::class,
            ],
        ];
    }

    public function testDefaultRetryStrategyFailing()
    {
        $httpHandler = self::getHttpHandlerMock([
            new Response(503), // Service Unavailable
            new Response(503),
            new Response(503),
            new Response(503),
            self::getSuccessfulObjectsResponse(), // This should not be reached
        ])[1];

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        $this->expectException(ServiceException::class);

        $client->createBucket('myBucket');
    }

    public static function getCreateBucketSuccessResponse()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['name' => 'myBucket'])
        );
    }

    public function testAlwaysRetryStrategySuccessful()
    {
        $httpHandler = self::getHttpHandlerMock([
            new Response(503), // Service Unavailable
            self::getCreateBucketSuccessResponse(),
        ])[1];

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            'retryStrategy' => StorageClient::RETRY_ALWAYS,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        $this->assertInstanceOf(Bucket::class, $client->createBucket('myBucket'));
    }

    public function testDelayFunctionsConfiguration()
    {
        $httpHandler = self::getHttpHandlerMock([
            new Response(503),
            new Response(503),
            self::getSuccessfulObjectsResponse(),
        ])[1];

        $capturedDelays = [];
        $restCalcDelayFunction = fn ($attempt) => ($attempt + 1) * 100; // 1st retry: 100, 2nd: 200
        $restDelayFunction = function ($delay) use (&$capturedDelays) {
            $capturedDelays[] = $delay;
        };

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            'retries' => 2,
            'restCalcDelayFunction' => $restCalcDelayFunction,
            'restDelayFunction' => $restDelayFunction,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
        ]);

        $objects = iterator_to_array($client->bucket('myBucket')->objects());
        
        $this->assertEquals('file.txt', $objects[0]->name());
        $this->assertEquals([100, 200], $capturedDelays);
    }

    public function testCustomRetryFunctionConfiguration()
    {
        $mockResponses = [
            new Response(404), // Not Found - normally not retried
            self::getSuccessfulObjectsResponse(),
        ];

        list($mockHandler, $httpHandler) = self::getHttpHandlerMock($mockResponses);

        $customRetryFunction = function (\Exception $e) {
            // Custom logic: only retry if the error code is 404.
            return $e->getCode() === 404;
        };

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            'restRetryFunction' => $customRetryFunction,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        $objects = iterator_to_array($client->bucket('myBucket')->objects());

        $this->assertEquals('file.txt', $objects[0]->name());
        // Should use all the mock responses.
        $this->assertEquals(0, $mockHandler->count());
    }

    public function testRetryListenerConfiguration()
    {
        $mockResponses = [
            new Response(503),
            self::getSuccessfulObjectsResponse(),
        ];
        $mockHandler = new MockHandler($mockResponses);
        $handlerStack = HandlerStack::create($mockHandler);
        
        $requestHistory = [];
        $handlerStack->push(\GuzzleHttp\Middleware::history($requestHistory));
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $listenerInvocations = 0;
        $retryListenerFunction = function (\Exception $e, $retryAttempt, &$arguments) use (&$listenerInvocations) {
            $listenerInvocations++;
            // $arguments is an array: [RequestInterface $request, array $options]
            $request = $arguments[0];
            $arguments[0] = $request->withHeader('X-Retry-Attempt', (string) $retryAttempt);
        };

        $client = new StorageClient([
            'projectId' => self::PROJECT,
            'restRetryListener' => $retryListenerFunction,
            // Mock the authHttpHandler so it doesn't make a real request
            'httpHandler' => fn ($req, $opt) => $guzzleClient->send($req, $opt),
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        $objects = iterator_to_array($client->bucket('myBucket')->objects());

        $this->assertEquals('file.txt', $objects[0]->name());
        $this->assertEquals(1, $listenerInvocations);
        $this->assertFalse($requestHistory[0]['request']->hasHeader('X-Retry-Attempt'));
        $this->assertEquals('1', $requestHistory[1]['request']->getHeaderLine('X-Retry-Attempt'));
    }
}

//@codingStandardsIgnoreStart
class StorageClientStub extends StorageClient
{
    protected function onGce($httpHandler)
    {
        return false;
    }
}
//@codingStandardsIgnoreEnd
