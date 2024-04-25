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

namespace Google\Cloud\Storage\Tests\Unit\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Retry;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Storage\Connection\Rest;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use UnexpectedValueException;

/**
 * @group storage
 */
class RestTest extends TestCase
{
    use ProphecyTrait;

    private $requestWrapper;
    private $successBody;
    private static $downloadOptions = [
        'bucket' => 'bigbucket',
        'object' => 'myfile.txt',
        'generation' => 100,
        'restOptions' => ['debug' => true],
        'retries' => 0,
        'userProject' => 'myProject'
    ];

    public function setUp(): void
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->successBody = '{"canI":"kickIt"}';
    }

    /**
     * @dataProvider provideApiEndpointForUniverseDomain
     */
    public function testApiEndpointForUniverseDomain(
        array $config,
        string $expectedEndpoint,
        string $envUniverse = null
    ) {
        if ($envUniverse) {
            putenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN=' . $envUniverse);
        }
        $rest = new Rest($config);

        $r = new \ReflectionClass($rest);
        $p = $r->getProperty('apiEndpoint');
        $p->setAccessible(true);

        if ($envUniverse) {
            // We have to do this instead of using "@runInSeparateProcess" because in the case of
            // an error, PHPUnit throws a "Serialization of 'ReflectionClass' is not allowed" error.
            // @TODO: Remove this once we've updated to PHPUnit 10.
            putenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN');
        }

        $this->assertEquals($expectedEndpoint, $p->getValue($rest));
    }

    public function provideApiEndpointForUniverseDomain()
    {
        return [
            [[], 'https://storage.googleapis.com/'], // default
            [['apiEndpoint' => 'https://foobar.com'], 'https://foobar.com/'],
            [['universeDomain' => 'googleapis.com'], 'https://storage.googleapis.com/'],
            [['universeDomain' => 'abc.def.ghi'], 'https://storage.abc.def.ghi/'],
            [[], 'https://storage.abc.def.ghi/', 'abc.def.ghi'],
            [['universeDomain' => 'googleapis.com'], 'https://storage.googleapis.com/', 'abc.def.ghi'],
        ];
    }

    public function testApiEndpointForUniverseDomainThrowsException()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage(
            'The "universeDomain" config value must be set to use the default API endpoint template.'
        );

        new Rest(['universeDomain' => null]);
    }

    /**
     * @dataProvider methodProvider
     * @todo revisit this approach
     */
    public function testCallBasicMethods($method)
    {
        $options = [];
        $request = new Request('GET', '/somewhere');
        $response = new Response(200, [], $this->successBody);

        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('array')
        )->willReturn($request);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $rest = new Rest();
        $rest->setRequestBuilder($requestBuilder->reveal());
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        if (substr($method, -3) == 'Acl') {
            $options = ['type' => 'bucketAccessControls'];
        }

        $this->assertEquals(json_decode($this->successBody, true), $rest->$method($options));
    }

    public function methodProvider()
    {
        return [
            ['deleteAcl'],
            ['getAcl'],
            ['listAcl'],
            ['insertAcl'],
            ['patchAcl'],
            ['deleteBucket'],
            ['getBucket'],
            ['listBuckets'],
            ['insertBucket'],
            ['patchBucket'],
            ['copyObject'],
            ['deleteObject'],
            ['getObject'],
            ['listObjects'],
            ['patchObject'],
            ['rewriteObject'],
            ['composeObject'],
            ['getBucketIamPolicy'],
            ['setBucketIamPolicy'],
            ['testBucketIamPermissions'],
            ['getNotification'],
            ['deleteNotification'],
            ['insertNotification'],
            ['listNotifications'],
            ['getServiceAccount'],
            ['lockRetentionPolicy'],
            ['createHmacKey'],
            ['deleteHmacKey'],
            ['getHmacKey'],
            ['updateHmacKey'],
            ['listHmacKeys'],
        ];
    }

    public function testProjectId()
    {
        $rest = new Rest(['projectId' => 'foo']);
        $this->assertEquals('foo', $rest->projectId());
    }

    public function testProjectIdNull()
    {
        $rest = new Rest();
        $this->assertNull($rest->projectId());
    }

    public function apiEndpointProvider()
    {
        return [
            [null],
            ['https://foobar.com']
        ];
    }

    /**
     * @dataProvider apiEndpointProvider
     */
    public function testDownloadObject($apiEndpoint)
    {
        $actualRequest = null;
        $response = new Response(200, [], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $actualRequest = $args[0];
                return $response;
            }
        );

        $rest = $apiEndpoint ? new Rest(['apiEndpoint' => $apiEndpoint]) : new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        $actualBody = $rest->downloadObject(self::$downloadOptions);
        $actualUri = (string) $actualRequest->getUri();

        $expectedUri = sprintf(
            '%s/storage/v1/b/bigbucket/o/myfile.txt?generation=100&alt=media&userProject=myProject',
            $apiEndpoint ?: Rest::DEFAULT_API_ENDPOINT
        );

        $this->assertEquals($this->successBody, $actualBody);
        $this->assertEquals(
            $expectedUri,
            $actualUri
        );
    }

    /**
     * @dataProvider apiEndpointProvider
     */
    public function testDownloadObjectAsync($apiEndpoint)
    {
        $actualRequest = null;
        $response = new Response(200, [], $this->successBody);

        $this->requestWrapper->sendAsync(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $actualRequest = $args[0];
                return Create::promiseFor($response);
            }
        );

        $rest = $apiEndpoint ? new Rest(['apiEndpoint' => $apiEndpoint]) : new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        $actualPromise = $rest->downloadObjectAsync(self::$downloadOptions);
        $actualUri = (string) $actualRequest->getUri();

        $expectedUri = sprintf(
            '%s/storage/v1/b/bigbucket/o/myfile.txt?generation=100&alt=media&userProject=myProject',
            $apiEndpoint ?: Rest::DEFAULT_API_ENDPOINT
        );

        $this->assertInstanceOf(PromiseInterface::class, $actualPromise);
        $this->assertInstanceOf(StreamInterface::class, $actualPromise->wait());
        $this->assertEquals(
            $expectedUri,
            $actualUri
        );
    }

    /**
     * @dataProvider insertObjectProvider
     */
    public function testInsertObject(
        array $options,
        $expectedUploaderType,
        $expectedContentType,
        array $expectedMetadata,
        array $metadataKeysWhichShouldNotBeSet = []
    ) {
        $actualRequest = null;
        $response = new Response(200, ['Location' => 'http://www.mordor.com'], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $request = $args[0];
                if ($request->getMethod() === 'POST') {
                    $actualRequest = $request;
                }

                return $response;
            }
        );

        $rest = new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());
        $uploader = $rest->insertObject($options);
        $uploader->upload();
        list($contentType, $metadata) = $this->getContentTypeAndMetadata($actualRequest);

        $this->assertInstanceOf($expectedUploaderType, $uploader);
        $this->assertEquals($expectedContentType, $contentType);

        foreach ($expectedMetadata as $key => $value) {
            $this->assertEquals($value, $metadata[$key]);
        }

        if ($metadataKeysWhichShouldNotBeSet) {
            $metadataKeys = array_keys($metadata);
            foreach ($metadataKeysWhichShouldNotBeSet as $key) {
                $this->assertArrayNotHasKey($key, $metadataKeys);
            }
        }
    }

    public function insertObjectProvider()
    {
        $tempFile = Utils::streamFor(fopen('php://temp', 'r+'));
        $tempFile->write(str_repeat('0', 5000001));
        $logoFile = Utils::streamFor(fopen(__DIR__ . '/../data/logo.svg', 'r'));

        $crc32c = hash('crc32c', (string) $logoFile, true);
        $crcHash = base64_encode($crc32c);

        return [
            [
                [
                    'data' => $tempFile,
                    'name' => 'file.txt',
                    'predefinedAcl' => 'private',
                    'metadata' => ['contentType' => 'text/plain'],
                    'validate' => 'md5'
                ],
                ResumableUploader::class,
                'text/plain',
                [
                    'md5Hash' => base64_encode(Utils::hash($tempFile, 'md5', true)),
                    'name' => 'file.txt'
                ],
                ['crc32c']
            ],
            [
                [
                    'data' => $logoFile,
                    'validate' => false
                ],
                MultipartUploader::class,
                'image/svg+xml',
                [
                    'name' => 'logo.svg'
                ],
                ['md5Hash', 'crc32c']
            ],
            [
                [
                    'data' => 'abcdefg',
                    'name' => 'file.ext',
                    'resumable' => true,
                    'validate' => false,
                    'metadata' => [
                        'contentType' => 'text/plain',
                        'metadata' => [
                            'here' => 'wego'
                        ]
                    ]
                ],
                ResumableUploader::class,
                'text/plain',
                [
                    'name' => 'file.ext',
                    'metadata' => [
                        'here' => 'wego'
                    ]
                ],
                ['md5Hash', 'crc32c']
            ],
            [
                [
                    'data' => 'abcdefg',
                    'name' => 'file.ext',
                    'streamable' => true,
                    'validate' => false,
                    'metadata' => [
                        'contentType' => 'text/plain',
                        'metadata' => [
                            'here' => 'wego'
                        ]
                    ]
                ],
                StreamableUploader::class,
                'text/plain',
                [
                    'name' => 'file.ext',
                    'metadata' => [
                        'here' => 'wego'
                    ]
                ],
                ['md5Hash', 'crc32c']
            ],
            [
                [
                    'data' => $logoFile,
                    'name' => 'logo.svg',
                    'validate' => 'crc32'
                ],
                MultipartUploader::class,
                'image/svg+xml',
                [
                    'name' => 'logo.svg',
                    'crc32c' => $crcHash
                ],
                ['md5Hash']
            ],
            [
                [
                    'data' => $logoFile,
                    'name' => 'logo.svg',
                    'resumable' => true,
                    'validate' => 'crc32'
                ],
                ResumableUploader::class,
                'image/svg+xml',
                [
                    'name' => 'logo.svg',
                    'crc32c' => $crcHash
                ],
                ['md5Hash']
            ]
        ];
    }

    /**
     * @dataProvider validationMethod
     */
    public function testChooseValidationMethod($args, $extensionLoaded, $supportsBuiltin, $expected)
    {
        $rest = new RestCrc32cStub();
        $rest->extensionLoaded = $extensionLoaded;
        $rest->supportsBuiltin = $supportsBuiltin;

        $this->assertEquals($expected, $rest->chooseValidationMethodProxy($args));
    }

    public function validationMethod()
    {
        return [
            [
                ['validate' => true],
                false,
                false,
                'md5'
            ], [
                ['validate' => true],
                true,
                false,
                'crc32'
            ], [
                ['validate' => true],
                false,
                true,
                'crc32'
            ], [
                ['validate' => 'md5'],
                true,
                true,
                'md5'
            ], [
                ['validate' => 'crc32'],
                false,
                false,
                'crc32'
            ], [
                ['validate' => 'crc32c'],
                false,
                false,
                'crc32'
            ], [
                ['validate' => false],
                true,
                true,
                false
            ], [
                ['validate' => 'md5', 'metadata' => ['md5Hash' => 'foo']],
                true,
                true,
                false
            ], [
                ['validate' => 'md5', 'metadata' => ['crc32c' => 'foo']],
                true,
                true,
                false
            ]
        ];
    }

    /**
     * This tests whether the $arguments passed to the callbacks for header
     * updation is properly done when those callbacks are invoked in the
     * ExponentialBackoff::execute() method.
     *
     * @dataProvider provideRetryHeaders
     */
    public function testRetryHeaders(int $maxAttempts)
    {
        $attempt = 0;
        $response = new Response(200, [], $this->successBody);
        $actualRequest = null;

        $httpHandler = function ($request, $options) use (&$attempt, &$actualRequest, $response, $maxAttempts) {
            if (++$attempt < $maxAttempts) {
                throw new \Exception('Retrying');
            }
            $actualRequest = $request;
            return $response;
        };

        $rest = new Rest([
            'httpHandler' => $httpHandler,
            // Mock the authHttpHandler so it doesn't make a real request
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
            // Mock the delay function so the tests execute faster
            'restDelayFunction' => function () {
            },
        ]);

        // Call any method to test the retry
        $rest->listBuckets();

        $this->assertNotNull($actualRequest);
        $this->assertNotNull($agentHeader = $actualRequest->getHeaderLine(Retry::RETRY_HEADER_KEY));

        $agentHeaderParts = explode(' ', $agentHeader);
        $this->assertStringStartsWith('gccl-invocation-id/', $agentHeaderParts[2]);
        $this->assertEquals('gccl-attempt-count/' . $maxAttempts, $agentHeaderParts[3]);
    }

    public function provideRetryHeaders()
    {
        return [
            [1],
            [2],
            [3],
        ];
    }

    private function getContentTypeAndMetadata(RequestInterface $request)
    {
        // Resumable upload request
        if ($request->getHeaderLine('X-Upload-Content-Type')) {
            return [
                $request->getHeaderLine('X-Upload-Content-Type'),
                json_decode($request->getBody(), true)
            ];
        }

        // Multipart upload request
        $lines = explode(PHP_EOL, (string) $request->getBody());
        return [
            trim(explode(':', $lines[7])[1]),
            json_decode($lines[5], true)
        ];
    }
}

//@codingStandardsIgnoreStart
class RestCrc32cStub extends Rest
{
    public $extensionLoaded = false;
    public $supportsBuiltin = false;

    protected function crc32cExtensionLoaded()
    {
        return $this->extensionLoaded;
    }

    protected function supportsBuiltinCrc32c()
    {
        return $this->supportsBuiltin;
    }

    public function chooseValidationMethodProxy(array $args)
    {
        $chooseValidationMethod = function () {
            return call_user_func_array([$this, 'chooseValidationMethod'], func_get_args());
        };

        $call = $chooseValidationMethod->bindTo($this, Rest::class);
        return $call($args);
    }
}
