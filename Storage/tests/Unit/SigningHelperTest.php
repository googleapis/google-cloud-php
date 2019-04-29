<?php
/**
 * Copyright 2019 Google LLC
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
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\SigningHelper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group storage
 * @group storage-signing-helper
 * @group storage-signed-url
 */
class SigningHelperTest extends TestCase
{
    const CLIENT_EMAIL = 'test@test.iam.gserviceaccount.com';
    const BUCKET = 'test-bucket';
    const OBJECT = 'test-object';
    const GENERATION = 11111;

    private $helper;

    public function setUp()
    {
        $this->helper = TestHelpers::stub(SigningHelperStub::class);
    }

    public function testV2Sign()
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $url = $this->helper->v2Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            []
        );

        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        $this->assertEquals('https', $parts['scheme']);
        $this->assertEquals(SigningHelper::DEFAULT_DOWNLOAD_HOST, $parts['host']);
        $this->assertEquals($resource, $parts['path']);

        $this->assertEquals(self::CLIENT_EMAIL, $query['GoogleAccessId']);
        $this->assertEquals($expires, $query['Expires']);
        $this->assertEquals(urlencode($return), $query['Signature']);
        $this->assertEquals(self::GENERATION, $query['generation']);
    }

    /**
     * @dataProvider v2Params
     */
    public function testV2SignParams($key, $value, $paramKey, $paramValue = null, $isOpt = true)
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $url = $this->helper->v2Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                $key => $value
            ]
        );

        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        $this->assertEquals($paramValue ?: $value, $query[$paramKey]);
    }

    public function v2Params()
    {
        return [
            ['responseType', 'text/plain', 'response-content-type', 'text/plain'],
            ['responseDisposition', 'dispo', 'response-content-disposition'],
            ['saveAsName', 'test.txt', 'response-content-disposition', 'attachment; filename="test.txt"']
        ];
    }

    public function testV2CanonicalRequestAndCname()
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $contentMd5 = 'md5-value';
        $contentType = 'text/plain';
        $headers = [
            'x-goog-foo' => 'bar',
            'x-goog-bar' => 'foo'
        ];

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $this->helper->createV2CanonicalRequest = function ($request) use (
            $contentMd5,
            $contentType,
            $expires,
            $headers,
            $resource
        ) {
            $this->assertEquals('GET', $request[0]);
            $this->assertEquals($contentMd5, $request[1]);
            $this->assertEquals($contentType, $request[2]);
            $this->assertEquals($expires, $request[3]);

            // re-ordered to alpha
            $this->assertEquals('x-goog-bar:foo', $request[4]);
            $this->assertEquals('x-goog-foo:bar', $request[5]);

            $this->assertEquals($resource, $request[6]);

            return '';
        };

        $url = $this->helper->v2Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'headers' => $headers,
                'cname' => 'example.com',
                'contentMd5' => $contentMd5,
                'contentType' => $contentType
            ]
        );

        $parts = parse_url($url);
        $this->assertEquals('example.com', $parts['host']);
    }

    public function testV4Sign()
    {
        $credentials = $this->createCredentialsMock();
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expires = $now->format('U') + 2;
        $expectedExpires = 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $requestTimestamp = $now->format('Ymd\THis\Z');
        $requestDatestamp = $now->format('Ymd');

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $url = $this->helper->v4Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'timestamp' => $now
            ]
        );

        $parts = parse_url($url);

        $this->assertEquals('https', $parts['scheme']);
        $this->assertEquals(SigningHelper::DEFAULT_DOWNLOAD_HOST, $parts['host']);
        $this->assertEquals($resource, $parts['path']);

        parse_str($parts['query'], $query);

        $this->assertEquals(bin2hex(base64_decode($return)), $query['X-Goog-Signature']);
        $this->assertEquals($requestTimestamp, $query['X-Goog-Date']);
        $this->assertEquals($expectedExpires, $query['X-Goog-Expires']);
        $this->assertEquals(self::GENERATION, $query['generation']);
        $this->assertArrayHasKey('X-Goog-SignedHeaders', $query);
    }

    public function testV4SignCanonicalRequestAndCname()
    {
        $credentials = $this->createCredentialsMock();
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expires = $now->format('U') + 2;
        $resource = $this->createResource();
        $contentType = 'text/plain';
        $contentMd5 = 'md5-string';
        $responseType = 'text/pdf';
        $responseDisposition = 'dispo';
        $cname = 'foo.bar.com';

        $requestTimestamp = $now->format('Ymd\THis\Z');
        $requestDatestamp = $now->format('Ymd');
        $credentialScope = sprintf('%s/auto/storage/goog4_request', $requestDatestamp);
        $credential = sprintf('%s/%s', self::CLIENT_EMAIL, $credentialScope);

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn('');

        $this->helper->createV4CanonicalRequest = function ($request) use (
            $resource,
            $contentType,
            $contentMd5,
            $responseType,
            $responseDisposition,
            $cname,
            $credential,
            $requestTimestamp
        ) {
            $expectedHeaders = 'content-md5;content-type;host';

            $this->assertEquals('GET', $request[0]);
            $this->assertEquals($resource, $request[1]);

            parse_str($request[2], $query);
            $this->assertEquals(self::GENERATION, $query['generation']);
            $this->assertEquals($responseDisposition, $query['response-content-disposition']);
            $this->assertEquals($responseType, $query['response-content-type']);
            $this->assertEquals(SigningHelper::V4_ALGO_NAME, $query['X-Goog-Algorithm']);
            $this->assertEquals($credential, $query['X-Goog-Credential']);
            $this->assertEquals($requestTimestamp, $query['X-Goog-Date']);
            $this->assertEquals($expectedHeaders, $query['X-Goog-SignedHeaders']);

            $headers = explode("\n", $request[3]);
            $this->assertContains('content-md5:' . $contentMd5, $headers);
            $this->assertContains('content-type:' . $contentType, $headers);
            $this->assertContains('host:' . $cname, $headers);

            $this->assertEquals($expectedHeaders, $request[4]);
            $this->assertEquals('UNSIGNED-PAYLOAD', $request[5]);
        };

        $url = $this->helper->v4Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'contentType' => $contentType,
                'contentMd5' => $contentMd5,
                'responseType' => $responseType,
                'responseDisposition' => $responseDisposition,
                'cname' => $cname,
                'timestamp' => $now
            ]
        );

        $parts = parse_url($url);
        $this->assertEquals($cname, $parts['host']);
        $this->assertEquals('/' . self::OBJECT, $parts['path']);
    }

    /**
     * @dataProvider cnames
     */
    public function testV4CnameFix($cname, $expected = null)
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $url = $this->helper->v4Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'cname' => $cname
            ]
        );

        $parts = parse_url($url);
        $this->assertEquals($expected ?: $cname, $parts['host']);
    }

    /**
     * @dataProvider cnames
     */
    public function testV2CnameFix($cname, $expected = null)
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $return = base64_encode('SIGNATURE');

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($return);

        $url = $this->helper->v2Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'cname' => $cname
            ]
        );

        $parts = parse_url($url);
        $this->assertEquals($expected ?: $cname, $parts['host']);
    }

    public function cnames()
    {
        return [
            ['example.com'],
            ['foo.example.com'],
            ['https://example.com', 'example.com'],
            ['http://example.com', 'example.com'],
            ['//example.com', 'example.com']
        ];
    }

    public function testV4SignCanonicalRequestSaveAsName()
    {
        $credentials = $this->createCredentialsMock();
        $expires = time() + 2;
        $resource = $this->createResource();
        $saveAsName = 'test.txt';

        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn('');

        $this->helper->createV4CanonicalRequest = function ($request) use ($saveAsName) {
            parse_str($request[2], $query);
            $expectedDisposition = 'attachment; filename="' . $saveAsName .'"';
            $this->assertEquals($expectedDisposition, $query['response-content-disposition']);
        };

        $this->helper->v4Sign(
            $this->mockConnection($credentials->reveal()),
            $expires,
            $resource,
            self::GENERATION,
            [
                'saveAsName' => $saveAsName
            ]
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testV4SignInvalidExpiration()
    {
        $expires = (new \DateTime)->modify('+20 days');
        $this->helper->v4Sign(
            $this->mockConnection($this->createCredentialsMock()->reveal()),
            $expires,
            '',
            null,
            []
        );
    }

    /**
     * @dataProvider expirations
     */
    public function testExpirations($expiration, $expected)
    {
        $credentials = $this->createCredentialsMock();
        $credentials->signBlob(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn('');

        $this->helper->createV2CanonicalRequest = function ($request) use ($expected) {
            $this->assertEquals($expected, $request[3]);
            return '';
        };

        $this->helper->v2Sign(
            $this->mockConnection($credentials->reveal()),
            $expiration,
            $this->createResource(),
            self::GENERATION,
            []
        );
    }

    public function expirations()
    {
        $tenMins = (new \DateTimeImmutable)->modify('+10 minutes');

        return [
            [
                new Timestamp($tenMins),
                $tenMins->format('U')
            ], [
                $tenMins,
                $tenMins->format('U')
            ], [
                time() + 10,
                time() + 10
            ]
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider urlMethods
     */
    public function testInvalidExpiration($method)
    {
        $this->helper->$method(
            $this->mockConnection($this->createCredentialsMock()->reveal()),
            'foobar',
            $this->createResource(),
            self::GENERATION,
            []
        );
    }

    public function urlMethods()
    {
        return [
            ['v2Sign'],
            ['v4Sign']
        ];
    }

    /**
     * @dataProvider options
     */
    public function testNormalizeOptions(array $options, array $expected = null, $exception = null)
    {
        if ($exception) {
            if (method_exists($this, 'setExpectedException')) {
                $expectation = 'setExpectedException';
            } else {
                $expectation = 'expectException';
            }

            $this->$expectation($exception);
        }

        $res = $this->helper->normalizeProxy('normalizeOptions', [$options]);

        if (!$exception) {
            $expectedKeys = array_keys($expected ?: $options);
            $fromRes = [];
            foreach ($expectedKeys as $key) {
                if (isset($res[$key])) {
                    $fromRes[$key] = $res[$key];
                }
            }

            $this->assertEquals($expected ?: $options, $fromRes);
        }
    }

    public function options()
    {
        return [
            [
                ['method' => 'GET']
            ], [
                ['method' => 'POST'], null, \InvalidArgumentException::class
            ], [
                ['method' => 'POST', 'allowPost' => true], ['method' => 'POST']
            ], [
                ['method' => 'PUT']
            ], [
                ['method' => 'DELETE']
            ], [
                ['method' => 'Foo'], null, \InvalidArgumentException::class
            ], [
                ['method' => 'POST'], null, \InvalidArgumentException::class
            ]
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidTimestamps
     */
    public function testNormalizeOptionsInvalidTimestamps($timestamp)
    {
        $this->helper->normalizeProxy('normalizeOptions', [
            ['timestamp' => $timestamp]
        ]);
    }

    public function invalidTimestamps()
    {
        return [
            [(object) ['a' => 'b']],
            [['a' => 'b']],
            [123],
            ['hello world'],
            [date('Y-m-d')]
        ];
    }

    /**
     * @dataProvider headers
     */
    public function testNormalizeHeaders(array $input, array $expected)
    {
        $res = $this->helper->normalizeProxy('normalizeHeaders', [$input]);

        $this->assertEquals($expected, $res);
    }

    public function headers()
    {
        return [
            [
                [
                    'x-goog-foo' => ['a', 'b'],
                    'x-goog-bar' => 'a',
                    'X-goog-blah' => 'hi'
                ], [
                    'x-goog-foo' => 'a, b',
                    'x-goog-bar' => 'a',
                    'x-goog-blah' => 'hi'
                ]
            ], [
                [
                    'x-goog-foo' => 'test' . PHP_EOL . 'test',
                    'x-goog-bar' => ['test' . PHP_EOL . 'test', 'test' . PHP_EOL . 'test']
                ], [
                    'x-goog-foo' => 'testtest',
                    'x-goog-bar' => 'testtest, testtest'
                ]
            ]
        ];
    }

    /**
     * @dataProvider v2InvalidHeaders
     * @expectedException InvalidArgumentException
     */
    public function testV2InvalidHeaders($header)
    {
        $this->helper->v2Sign(
            $this->mockConnection($this->prophesize(SignBlobInterface::class)->reveal()),
            time() + 10,
            '/foo/bar',
            null,
            [
                'headers' => [
                    $header => 'val'
                ]
            ]
        );
    }

    public function v2InvalidHeaders()
    {
        return [
            ['x-goog-encryption-key'],
            ['x-goog-encryption-key-sha256']
        ];
    }

    /**
     * @dataProvider resources
     */
    public function testNormalizeUriPath($resource, $cname, $expected)
    {
        $res = $this->helper->normalizeProxy('normalizeUriPath', [
            $cname,
            $resource
        ]);

        $this->assertEquals($expected, $res);
    }

    public function resources()
    {
        return [
            [
                '/bucket/object.txt',
                SigningHelper::DEFAULT_DOWNLOAD_HOST,
                '/bucket/object.txt'
            ], [
                '/bucket/folder/object.txt',
                SigningHelper::DEFAULT_DOWNLOAD_HOST,
                '/bucket/folder/object.txt'
            ], [
                '/bucket/object.txt',
                'example.com',
                '/object.txt'
            ], [
                '/bucket/folder/object.txt',
                'example.com',
                '/folder/object.txt'
            ], [
                '/bucket',
                SigningHelper::DEFAULT_DOWNLOAD_HOST,
                '/bucket'
            ], [
                '/bucket',
                'example.com',
                '/'
            ],
        ];
    }

    private function createCredentialsMock()
    {
        $credentials = $this->prophesize(ServiceAccountCredentials::class);
        $credentials->getClientName()->willReturn(self::CLIENT_EMAIL);

        return $credentials;
    }

    private function createResource($bucket = null, $object = null)
    {
        return sprintf('/%s/%s', $bucket ?: self::BUCKET, $object ?: self::OBJECT);
    }

    private function mockConnection($credentials)
    {
        $conn = $this->prophesize(Rest::class);
        $rw = $this->prophesize(RequestWrapper::class);
        $rw->getCredentialsFetcher()->willReturn($credentials);
        $conn->requestWrapper()->willReturn($rw->reveal());

        return $conn->reveal();
    }
}

//@codingStandardsIgnoreStart
class SigningHelperStub extends SigningHelper
{
    public $createV4CanonicalRequest;

    public $createV2CanonicalRequest;

    private function createV4CanonicalRequest(array $request)
    {
        $callPrivate = $this->callPrivate('createV4CanonicalRequest', [$request]);
        return $this->createV4CanonicalRequest
            ? call_user_func($this->createV4CanonicalRequest, $request)
            : \Closure::bind($callPrivate, null, new SigningHelper);
    }

    private function createV2CanonicalRequest(array $request)
    {
        $callPrivate = $this->callPrivate('createV2CanonicalRequest', [$request]);
        return $this->createV2CanonicalRequest
            ? call_user_func($this->createV2CanonicalRequest, $request)
            : \Closure::bind($callPrivate, null, new SigningHelper);
    }

    public function normalizeProxy($method, array $args)
    {
        $parent = new SigningHelper;
        $cb = function () use ($method) {
            return call_user_func_array([$this, $method], func_get_args()[0]);
        };

        $callPrivate = $cb->bindTo($parent, SigningHelper::class);
        return $callPrivate($args);
    }

    private function callPrivate($method, array $args)
    {
        return function (SigningHelper $helper) use ($method, $args) {
            return $helper->$method($args);
        };
    }
}
