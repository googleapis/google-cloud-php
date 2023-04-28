<?php
/*
 * Copyright 2018 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit\Transport;

use BadMethodCallException;
use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockResponse;
use Google\ApiCore\Tests\Unit\TestTrait;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\ValidationException;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\ErrorInfo;
use Google\Type\DateTime;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use TypeError;
use UnexpectedValueException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class RestTransportTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    private $call;

    public function setUp(): void
    {
        $this->call = new Call(
            'Testing123',
            MockResponse::class,
            new MockRequest()
        );
    }

    private function getTransport(callable $httpHandler = null, $apiEndpoint = 'http://www.example.com')
    {
        $request = new Request('POST', $apiEndpoint);
        $requestBuilder = $this->getMockBuilder(RequestBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestBuilder->method('build')
            ->willReturn($request);
        $requestBuilder->method('pathExists')
            ->willReturn(true);

        return new RestTransport(
            $requestBuilder,
            $httpHandler ?: HttpHandlerFactory::build()
        );
    }

    /**
     * @param $apiEndpoint
     * @dataProvider startUnaryCallDataProvider
     */
    public function testStartUnaryCall($apiEndpoint)
    {
        $expectedRequest = new Request(
            'POST',
            "$apiEndpoint",
            [],
            ""
        );

        $body = ['name' => 'hello', 'number' => 15];

        $httpHandler = function (RequestInterface $request, array $options = []) use ($body, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);
            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    json_encode($body)
                )
            );
        };

        $response = $this->getTransport($httpHandler, $apiEndpoint)
            ->startUnaryCall($this->call, [])
            ->wait();

        $this->assertEquals($body['name'], $response->getName());
        $this->assertEquals($body['number'], $response->getNumber());
    }

    public function startUnaryCallDataProvider()
    {
        return [
            ["www.example.com"],
            ["www.example.com:443"],
            ["www.example.com:447"],
        ];
    }

    public function testStartUnaryCallThrowsException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::rejectionFor(new Exception());
        };

        $this->expectException(Exception::class);

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }

    /**
     * @runInSeparateProcess
     */
    public function testStartUnaryCallWithValidProtoNotLoadedInDescPool()
    {
        $endpoint = 'www.example.com';
        $expectedRequest = new Request(
            'POST',
            $endpoint,
            [],
            ''
        );
        $body = [
            'name' => 'projects/my-project/locations/us-central1/operations/my-operation',
            'metadata' => [
                // This type is arbitrarily chosen and should not exist within the descriptor pool
                // upon instantation of this test.
                '@type' => 'type.googleapis.com/google.type.DateTime'
            ]
        ];
        $httpHandler = function (RequestInterface $request) use ($body, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);
            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    json_encode($body)
                )
            );
        };
        $call = new Call(
            'Testing123',
            Operation::class,
            new MockRequest()
        );

        $response = $this->getTransport($httpHandler, $endpoint)
            ->startUnaryCall($call, [
                'metadataReturnType' => DateTime::class
            ])
            ->wait();

        $this->assertInstanceOf(Operation::class, $response);
        $this->assertEquals(
            $body['metadata']['@type'],
            $response->getMetadata()->getTypeUrl()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testStartUnaryCallWithValidProtoNotLoadedInDescPoolThrowsExWithoutMetadataType()
    {
        $endpoint = 'www.example.com';
        $expectedRequest = new Request(
            'POST',
            $endpoint,
            [],
            ''
        );
        $body = [
            'name' => 'projects/my-project/locations/us-central1/operations/my-operation',
            'metadata' => [
                // This type is arbitrarily chosen and should not exist within the descriptor pool
                // upon instantation of this test.
                '@type' => 'type.googleapis.com/google.type.DateTime'
            ]
        ];
        $httpHandler = function (RequestInterface $request) use ($body, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);
            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    json_encode($body)
                )
            );
        };
        $call = new Call(
            'Testing123',
            Operation::class,
            new MockRequest()
        );
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/^Error occurred during parsing:/');
        $this->getTransport($httpHandler, $endpoint)
            ->startUnaryCall($call, [])
            ->wait();
    }

    public function testServerStreamingCallThrowsBadMethodCallException()
    {
        $request = new Request('POST', 'http://www.example.com');
        $requestBuilder = $this->getMockBuilder(RequestBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestBuilder->method('pathExists')
            ->willReturn(false);

        $transport = new RestTransport($requestBuilder, HttpHandlerFactory::build());

        $this->expectException(BadMethodCallException::class);
        $transport->startServerStreamingCall($this->call, []);
    }

    public function testStartUnaryCallThrowsRequestException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::rejectionFor(
                RequestException::create(
                    new Request('POST', 'http://www.example.com'),
                    new Response(
                        404,
                        [],
                        json_encode([
                            'error' => [
                                'status' => 'NOT_FOUND',
                                'message' => 'Ruh-roh.'
                            ]
                        ])
                    )
                )
            );
        };

        $this->expectException(ApiException::class);

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }
    /**
     * @dataProvider buildServerStreamMessages
     */
    public function testStartServerStreamingCall($messages)
    {
        $apiEndpoint = 'www.example.com';
        $expectedRequest = new Request(
            'POST',
            $apiEndpoint,
            [],
            ""
        );

        $httpHandler = function (RequestInterface $request, array $options = []) use ($messages, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);
            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    $this->encodeMessages($messages)
                )
            );
        };

        $stream = $this->getTransport($httpHandler, $apiEndpoint)
            ->startServerStreamingCall($this->call, []);

        $num = 0;
        foreach ($stream->readAll() as $m) {
            $this->assertEquals($messages[$num], $m);
            $num++;
        }
        $this->assertEquals(count($messages), $num);
    }

    /**
     * @dataProvider buildServerStreamMessages
     */
    public function testCancelServerStreamingCall($messages)
    {
        $apiEndpoint = 'www.example.com';
        $expectedRequest = new Request(
            'POST',
            $apiEndpoint,
            [],
            ""
        );

        $httpHandler = function (RequestInterface $request, array $options = []) use ($messages, $expectedRequest) {
            $this->assertEquals($expectedRequest, $request);
            return Create::promiseFor(
                new Response(
                    200,
                    [],
                    $this->encodeMessages($messages)
                )
            );
        };

        $stream = $this->getTransport($httpHandler, $apiEndpoint)
            ->startServerStreamingCall($this->call, []);

        $num = 0;
        foreach ($stream->readAll() as $m) {
            $this->assertEquals($messages[$num], $m);
            $num++;

            // Intentionally cancel the stream mid way through processing.
            $stream->getServerStreamingCall()->cancel();
        }

        // Ensure only one message was ever yielded.
        $this->assertEquals(1, $num);
    }

    private function encodeMessages(array $messages)
    {
        $data = [];
        foreach ($messages as $message) {
            $data[] = $message->serializeToJsonString();
        }
        return '['.implode(',', $data).']';
    }

    public function buildServerStreamMessages()
    {
        return[
            [
                [
                    new MockResponse([
                        'name' => 'foo',
                        'number' => 1,
                    ]),
                    new MockResponse([
                        'name' => 'bar',
                        'number' => 2,
                    ]),
                    new MockResponse([
                        'name' => 'baz',
                        'number' => 3,
                    ]),
                ]
            ]
        ];
    }

    public function testStartServerStreamingCallThrowsRequestException()
    {
        $apiEndpoint = 'http://www.example.com';
        $errorInfo = new Any();
        $errorInfo->pack(new ErrorInfo(['domain' => 'googleapis.com']));
        $httpHandler = function (RequestInterface $request, array $options = []) use ($apiEndpoint, $errorInfo) {
            return Create::rejectionFor(
                RequestException::create(
                    new Request('POST', $apiEndpoint),
                    new Response(
                        404,
                        [],
                        json_encode([[
                            'error' => [
                                'status' => 'NOT_FOUND',
                                'message' => 'Ruh-roh.',
                                'details' => [$errorInfo]
                            ]
                        ]])
                    )
                )
            );
        };

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(5);
        $this->expectExceptionMessage('Ruh-roh');

        $this->getTransport($httpHandler, $apiEndpoint)
            ->startServerStreamingCall($this->call, []);
    }

    /**
     * @dataProvider buildDataRest
     */
    public function testBuildRest($apiEndpoint, $restConfigPath, $config, $expectedTransport)
    {
        $actualTransport = RestTransport::build($apiEndpoint, $restConfigPath, $config);
        $this->assertEquals($expectedTransport, $actualTransport);
    }

    public function buildDataRest()
    {
        $uri = "address.com";
        $apiEndpoint = "$uri:443";
        $restConfigPath = __DIR__ . '/../testdata/test_service_rest_client_config.php';
        $requestBuilder = new RequestBuilder($apiEndpoint, $restConfigPath);
        $httpHandler = [HttpHandlerFactory::build(), 'async'];
        return [
            [
                $apiEndpoint,
                $restConfigPath,
                ['httpHandler' => $httpHandler],
                new RestTransport($requestBuilder, $httpHandler)
            ],
            [
                $apiEndpoint,
                $restConfigPath,
                [],
                new RestTransport($requestBuilder, $httpHandler),
            ],
        ];
    }

    public function testClientCertSourceOptionValid()
    {
        $mockClientCertSource = function () {
            return 'MOCK_CERT_SOURCE';
        };
        $transport = RestTransport::build(
            'address.com:123',
            __DIR__ . '/../testdata/test_service_rest_client_config.php',
            ['clientCertSource' => $mockClientCertSource]
        );

        $reflectionClass = new \ReflectionClass($transport);
        $reflectionProp = $reflectionClass->getProperty('clientCertSource');
        $reflectionProp->setAccessible(true);
        $actualClientCertSource = $reflectionProp->getValue($transport);

        $this->assertEquals($mockClientCertSource, $actualClientCertSource);
    }

    public function testClientCertSourceOptionInvalid()
    {
        $this->requiresPhp7();

        $mockClientCertSource = 'foo';

        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches('/must be.+callable/i');

        RestTransport::build(
            'address.com:123',
            __DIR__ . '/../testdata/test_service_rest_client_config.php',
            ['clientCertSource' => $mockClientCertSource]
        );
    }

    /**
     * @dataProvider buildInvalidData
     */
    public function testBuildInvalid($apiEndpoint, $restConfigPath, $args)
    {
        $this->expectException(ValidationException::class);

        RestTransport::build($apiEndpoint, $restConfigPath, $args);
    }

    public function buildInvalidData()
    {
        $restConfigPath = __DIR__ . '/../testdata/test_service_rest_client_config.php';
        return [
            [
                "addresswithtoo:many:segments",
                $restConfigPath,
                [],
            ],
            [
                "address.com",
                "badpath",
                [],
            ],
        ];
    }

    public function testNonJsonResponseException()
    {
        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::rejectionFor(
                RequestException::create(
                    new Request('POST', 'http://www.example.com'),
                    new Response(
                        404,
                        [],
                        "<html><body>This is an HTML response</body></html>"
                    )
                )
            );
        };

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(5);
        $this->expectExceptionMessage('<html><body>This is an HTML response<\/body><\/html>');

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, [])
            ->wait();
    }

    public function testAudienceOption()
    {
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->getAuthorizationHeaderCallback('an-audience')
            ->shouldBeCalledOnce()
            ->willReturn(function () {
                return [];
            });

        $options = [
            'audience' => 'an-audience',
            'credentialsWrapper' => $credentialsWrapper->reveal(),
        ];

        $httpHandler = function (RequestInterface $request, array $options = []) {
            return Create::promiseFor(new Response(200, [], '{}'));
        };

        $this->getTransport($httpHandler)
            ->startUnaryCall($this->call, $options)
            ->wait();
    }

    public function testNonArrayHeadersThrowsException()
    {
        $options = [
            'headers' => 'not-an-array',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "headers" option must be an array');

        $this->getTransport()
            ->startUnaryCall($this->call, $options);
    }

    public function testNonArrayAuthorizationHeaderThrowsException()
    {
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->getAuthorizationHeaderCallback(null)
            ->shouldBeCalledOnce()
            ->willReturn(function () {
                return '';
            });

        $options = [
            'credentialsWrapper' => $credentialsWrapper->reveal(),
        ];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Expected array response from authorization header callback');

        $this->getTransport()
            ->startUnaryCall($this->call, $options);
    }
}
