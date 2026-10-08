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
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\ResumableUpload\ResumableUploadTransportInterface;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockRequestBody;
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
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use RuntimeException;
use TypeError;
use UnexpectedValueException;

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

    private function getTransport(?callable $httpHandler = null, $apiEndpoint = 'http://www.example.com')
    {
        $request = new Request('POST', $apiEndpoint);
        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build(Argument::cetera())
            ->willReturn($request);
        $requestBuilder->getUriTemplate(Argument::cetera())
            ->willReturn(null);
        $requestBuilder->pathExists(Argument::type('string'))
            ->willReturn(true);

        return new RestTransport(
            $requestBuilder->reveal(),
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
            ''
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
            ['www.example.com'],
            ['www.example.com:443'],
            ['www.example.com:447'],
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
        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->pathExists(Argument::type('string'))
            ->willReturn(false);

        $transport = new RestTransport($requestBuilder->reveal(), HttpHandlerFactory::build());

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
            ''
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
            ''
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
        return '[' . implode(',', $data) . ']';
    }

    public function buildServerStreamMessages()
    {
        return [
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
        $uri = 'address.com';
        $apiEndpoint = "$uri:443";
        $restConfigPath = __DIR__ . '/../testdata/resources/test_service_rest_client_config.php';
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
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            ['clientCertSource' => $mockClientCertSource]
        );

        $reflectionClass = new \ReflectionClass($transport);
        $reflectionProp = $reflectionClass->getProperty('clientCertSource');
        $actualClientCertSource = $reflectionProp->getValue($transport);

        $this->assertEquals($mockClientCertSource, $actualClientCertSource);
    }

    public function testClientCertSourceOptionInvalid()
    {
        $mockClientCertSource = 'foo';

        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches('/must be.+callable/i');

        RestTransport::build(
            'address.com:123',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
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
        $restConfigPath = __DIR__ . '/../testdata/resources/test_service_rest_client_config.php';
        return [
            [
                'addresswithtoo:many:segments',
                $restConfigPath,
                [],
            ],
            [
                'address.com',
                'badpath',
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
                        '<html><body>This is an HTML response</body></html>'
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

    public function testImplementsResumableUploadTransportInterface()
    {
        $transport = $this->getTransport();
        $this->assertInstanceOf(ResumableUploadTransportInterface::class, $transport);
    }

    public function testSendRawRequest()
    {
        $expectedRequest = new Request('POST', 'http://www.example.com/resumable/upload', ['foo' => 'bar'], 'body');
        $expectedOptions = ['timeout' => 30];
        $expectedResponse = new Response(200, ['header' => 'val'], 'response body');

        $httpHandler = function (
            RequestInterface $request,
            array $options = []
        ) use (
            $expectedRequest,
            $expectedOptions,
            $expectedResponse
        ) {
            $this->assertSame($expectedRequest, $request);
            $this->assertEquals($expectedOptions, $options);
            return $expectedResponse;
        };

        $transport = $this->getTransport($httpHandler);
        $response = $transport->sendRawRequest($expectedRequest, $expectedOptions);

        $this->assertSame($expectedResponse, $response);
    }

    public function testSendRawRequestWithDefaultOptions()
    {
        $expectedRequest = new Request('GET', 'http://www.example.com/status');
        $expectedResponse = new Response(200, [], 'ok');

        $httpHandler = function (
            RequestInterface $request,
            array $options = []
        ) use (
            $expectedRequest,
            $expectedResponse
        ) {
            $this->assertSame($expectedRequest, $request);
            $this->assertEquals([], $options);
            return $expectedResponse;
        };

        $transport = $this->getTransport($httpHandler);
        $response = $transport->sendRawRequest($expectedRequest);

        $this->assertSame($expectedResponse, $response);
    }

    public function testBuildRequest()
    {
        $method = 'v1/test:create';
        $message = new MockRequest();
        $headers = ['custom-header' => ['value1']];
        $expectedRequest = new Request('POST', 'http://www.example.com/v1/test:create', $headers);

        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build($method, $message, $headers)
            ->shouldBeCalledOnce()
            ->willReturn($expectedRequest);

        $transport = new RestTransport(
            $requestBuilder->reveal(),
            HttpHandlerFactory::build()
        );

        $actualRequest = $transport->buildRequest($method, $message, $headers);
        $this->assertSame($expectedRequest, $actualRequest);
    }

    public function testBuildRequestWithDefaultHeaders()
    {
        $method = 'v1/test:get';
        $message = new MockRequest();
        $expectedRequest = new Request('GET', 'http://www.example.com/v1/test:get');

        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build($method, $message, [])
            ->shouldBeCalledOnce()
            ->willReturn($expectedRequest);

        $transport = new RestTransport(
            $requestBuilder->reveal(),
            HttpHandlerFactory::build()
        );

        $actualRequest = $transport->buildRequest($method, $message);
        $this->assertSame($expectedRequest, $actualRequest);
    }

    public function testStartUnaryCallEmitsT4ClientSpanOnSuccess(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);

        $method = 'test.interface.v1.api/MethodWithBodyAndUrlPlaceholder';

        $tracerProvider->expects($this->once())
            ->method('getTracer')
            ->with('google-cloud-php', '1.0.0')
            ->willReturn($tracer);

        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->with('POST /v1/{name=message/**}')
            ->willReturn($spanBuilder);

        $spanBuilder->expects($this->once())
            ->method('setSpanKind')
            ->with(SpanKind::KIND_CLIENT)
            ->willReturnSelf();

        $attributes = [];
        $spanBuilder->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$attributes, $spanBuilder) {
                $attributes[$key] = $val;
                return $spanBuilder;
            });

        $spanBuilder->expects($this->once())
            ->method('startSpan')
            ->willReturn($span);

        $recordedSpanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedSpanAttributes, $span) {
                $recordedSpanAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);

        $span->expects($this->once())
            ->method('end');

        $body = ['name' => 'hello', 'number' => 15];
        $httpHandler = fn (RequestInterface $request, array $options = []) => Create::promiseFor(
            new Response(200, [], json_encode($body))
        );

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'httpHandler' => $httpHandler,
                'openTelemetryTracerProvider' => $tracerProvider,
                'clientVersion' => '1.0.0',
            ]
        );

        $message = (new MockRequestBody())->setName('message/foo');
        $call = new Call($method, MockResponse::class, $message);
        $result = $transport->startUnaryCall($call, ['retryAttempt' => 2])->wait();

        $this->assertSame('hello', $result->getName());
        $this->assertSame('http', $attributes[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attributes[SpanAttributes::RPC_METHOD]);
        $this->assertSame('POST', $attributes[SpanAttributes::HTTP_REQUEST_METHOD]);
        $this->assertSame('https://secretmanager.googleapis.com/v1/message/foo', $attributes[SpanAttributes::URL_FULL]);
        $this->assertSame('/v1/{name=message/**}', $attributes[SpanAttributes::URL_TEMPLATE]);
        $this->assertSame('secretmanager.googleapis.com', $attributes[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attributes[SpanAttributes::SERVER_PORT]);
        $this->assertSame(2, $attributes[SpanAttributes::HTTP_REQUEST_RESEND_COUNT]);
        $this->assertSame(200, $recordedSpanAttributes[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
        $this->assertSame('OK', $recordedSpanAttributes[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
    }

    public function testStartUnaryCallEmitsT4ClientSpanOnFailure(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);

        $recordedSpanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedSpanAttributes, $span) {
                $recordedSpanAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Resource not found');

        $span->expects($this->once())
            ->method('end');

        $httpHandler = fn (RequestInterface $request, array $options = []) => Create::rejectionFor(
            RequestException::create(
                $request,
                new Response(
                    404,
                    [],
                    json_encode([
                        'error' => [
                            'status' => 'NOT_FOUND',
                            'message' => 'Resource not found',
                        ],
                    ])
                )
            )
        );

        $transport = $this->getTransport($httpHandler);
        $this->setTelemetryOptions($transport, [
            'openTelemetryTracerProvider' => $tracerProvider,
        ]);

        $this->expectException(ApiException::class);

        try {
            $transport->startUnaryCall($this->call, [])->wait();
        } finally {
            $this->assertSame(404, $recordedSpanAttributes[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
            $this->assertSame('NOT_FOUND', $recordedSpanAttributes[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
            $this->assertSame('NOT_FOUND', $recordedSpanAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame('Resource not found', $recordedSpanAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }

    public function testStartUnaryCallEndsSpanOnSynchronousException(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Auth callback failed');
        $span->expects($this->once())
            ->method('end');

        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->getAuthorizationHeaderCallback(null)
            ->willThrow(new RuntimeException('Auth callback failed'));

        $transport = $this->getTransport();
        $this->setTelemetryOptions($transport, [
            'openTelemetryTracerProvider' => $tracerProvider,
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Auth callback failed');

        $transport->startUnaryCall($this->call, [
            'credentialsWrapper' => $credentialsWrapper->reveal(),
        ]);
    }

    public function testBuildSetsTelemetryOptions(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'openTelemetryTracerProvider' => $tracerProvider,
                'clientVersion' => '1.0.0',
            ]
        );

        $ref = new ReflectionClass($transport);
        $prop = $ref->getProperty('openTelemetryTracerProvider');
        $this->assertSame($tracerProvider, $prop->getValue($transport));

        $addrProp = $ref->getProperty('serverAddress');
        $this->assertSame('secretmanager.googleapis.com', $addrProp->getValue($transport));

        $portProp = $ref->getProperty('serverPort');
        $this->assertSame(443, $portProp->getValue($transport));
    }

    public function testStartUnaryCallDoesNotEmitSpanWhenTracerProviderNotConfigured(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $body = ['name' => 'hello', 'number' => 15];
        $httpHandler = fn (RequestInterface $request, array $options = []) => Create::promiseFor(
            new Response(200, [], json_encode($body))
        );

        $transport = $this->getTransport($httpHandler);
        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $response = $transport->startUnaryCall($this->call, [])->wait();
            $this->assertSame('hello', $response->getName());
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        $spans = $exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    public function testStartUnaryCallExportsHttpSuccessSpan(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $method = 'test.interface.v1.api/MethodWithBodyAndUrlPlaceholder';
        $body = ['name' => 'hello', 'number' => 15];
        $httpHandler = fn (RequestInterface $request, array $options = []) => Create::promiseFor(
            new Response(200, [], json_encode($body))
        );

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'httpHandler' => $httpHandler,
                'openTelemetryTracerProvider' => $tracerProvider,
                'clientVersion' => '1.2.3',
            ]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $message = (new MockRequestBody())->setName('message/foo');
            $call = new Call($method, MockResponse::class, $message);
            $result = $transport->startUnaryCall($call, [])->wait();
            $this->assertSame('hello', $result->getName());
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(2, $spans);

        $httpSpan = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $httpSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $httpSpan->getKind());
        $this->assertSame('POST /v1/{name=message/**}', $httpSpan->getName());
        $this->assertSame(StatusCode::STATUS_OK, $httpSpan->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $httpSpan->getInstrumentationScope()->getName());
        $this->assertSame('1.2.3', $httpSpan->getInstrumentationScope()->getVersion());

        $attrs = $httpSpan->getAttributes()->toArray();
        $this->assertSame('http', $attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attrs[SpanAttributes::RPC_METHOD]);
        $this->assertSame('OK', $attrs[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('POST', $attrs[SpanAttributes::HTTP_REQUEST_METHOD]);
        $this->assertSame(200, $attrs[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
        $this->assertSame('https://secretmanager.googleapis.com/v1/message/foo', $attrs[SpanAttributes::URL_FULL]);
        $this->assertSame('/v1/{name=message/**}', $attrs[SpanAttributes::URL_TEMPLATE]);
        $this->assertSame('secretmanager.googleapis.com', $attrs[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attrs[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::HTTP_REQUEST_RESEND_COUNT, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attrs);
    }

    public function testStartUnaryCallExportsHttpErrorSpans(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $method = 'test.interface.v1.api/MethodWithUrlPlaceholder';
        $errorInfo = new ErrorInfo([
            'reason' => 'IAM_PERMISSION_DENIED',
            'domain' => 'googleapis.com',
            'metadata' => ['key' => 'value'],
        ]);
        $anyDetail = new Any();
        $anyDetail->pack($errorInfo);

        $responses = [
            new Response(
                503,
                [],
                json_encode([
                    'error' => [
                        'code' => 503,
                        'status' => 'UNAVAILABLE',
                        'message' => 'Service unavailable',
                    ],
                ])
            ),
            new Response(
                403,
                [],
                json_encode([
                    'error' => [
                        'code' => 403,
                        'status' => 'PERMISSION_DENIED',
                        'message' => 'Permission denied on resource',
                        'details' => [json_decode($anyDetail->serializeToJsonString(), true)],
                    ],
                ])
            ),
        ];

        $httpHandler = function (RequestInterface $request, array $options = []) use (&$responses) {
            $response = array_shift($responses);
            return Create::rejectionFor(RequestException::create($request, $response));
        };

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'httpHandler' => $httpHandler,
                'openTelemetryTracerProvider' => $tracerProvider,
            ]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $message = (new MockRequestBody())->setName('message/foo');
            $call = new Call($method, MockResponse::class, $message);

            try {
                $transport->startUnaryCall($call, [])->wait();
                $this->fail('Expected ApiException for call 1');
            } catch (ApiException $e) {
                $this->assertSame('UNAVAILABLE', $e->getStatus());
            }

            try {
                $transport->startUnaryCall($call, [])->wait();
                $this->fail('Expected ApiException for call 2');
            } catch (ApiException $e) {
                $this->assertSame('PERMISSION_DENIED', $e->getStatus());
                $this->assertSame('IAM_PERMISSION_DENIED', $e->getReason());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(3, $spans);

        $span1 = $spans[0];
        $span2 = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $span1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $span1->getKind());
        $this->assertSame('GET /v1/{name=message/**}', $span1->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $span1->getStatus()->getCode());
        $attrs1 = $span1->getAttributes()->toArray();
        $this->assertSame(503, $attrs1[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Service unavailable', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);

        $this->assertSame($exportedAppSpan->getSpanId(), $span2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $span2->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $span2->getStatus()->getCode());
        $attrs2 = $span2->getAttributes()->toArray();
        $this->assertSame(403, $attrs2[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
        $this->assertSame('PERMISSION_DENIED', $attrs2[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('IAM_PERMISSION_DENIED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Permission denied on resource', $attrs2[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs2[SpanAttributes::EXCEPTION_TYPE]);
    }

    public function testStartUnaryCallRecordsClientFailureAndCancellationOnSpan(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $method = 'test.interface.v1.api/MethodWithUrlPlaceholder';
        $callCount = 0;
        $httpHandler = function (RequestInterface $request, array $options = []) use (&$callCount) {
            $callCount++;
            if ($callCount === 1) {
                return Create::rejectionFor(new RuntimeException('Connection timed out'));
            }
            return new Promise();
        };

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'httpHandler' => $httpHandler,
                'openTelemetryTracerProvider' => $tracerProvider,
            ]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $message = (new MockRequestBody())->setName('message/foo');
            $call = new Call($method, MockResponse::class, $message);

            try {
                $transport->startUnaryCall($call, [])->wait();
                $this->fail('Expected RuntimeException');
            } catch (RuntimeException $e) {
                $this->assertSame('Connection timed out', $e->getMessage());
            }

            $promise = $transport->startUnaryCall($call, []);
            $promise->cancel();
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(3, $spans);

        $exceptionSpan = $spans[0];
        $cancelledSpan = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $exceptionSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $exceptionSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $exceptionSpan->getStatus()->getCode());
        $attrs1 = $exceptionSpan->getAttributes()->toArray();
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Connection timed out', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertArrayNotHasKey(SpanAttributes::HTTP_RESPONSE_STATUS_CODE, $attrs1);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs1);

        $this->assertSame($exportedAppSpan->getSpanId(), $cancelledSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $cancelledSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $cancelledSpan->getStatus()->getCode());
        $attrs2 = $cancelledSpan->getAttributes()->toArray();
        $this->assertSame('CANCELLED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertArrayNotHasKey(SpanAttributes::HTTP_RESPONSE_STATUS_CODE, $attrs2);
    }

    public function testStartUnaryCallWithRetryMiddlewareEmitsSpanPerAttemptWithResendCount(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $method = 'test.interface.v1.api/MethodWithBodyAndUrlPlaceholder';
        $callCount = 0;
        $httpHandler = function (RequestInterface $request, array $options = []) use (&$callCount) {
            $callCount++;
            if ($callCount === 1) {
                return Create::rejectionFor(
                    RequestException::create(
                        $request,
                        new Response(
                            503,
                            [],
                            json_encode([
                                'error' => [
                                    'code' => 503,
                                    'status' => 'UNAVAILABLE',
                                    'message' => 'Temporary backend error',
                                ],
                            ])
                        )
                    )
                );
            }
            return Create::promiseFor(new Response(200, [], json_encode(['name' => 'ok', 'number' => 1])));
        };

        $transport = RestTransport::build(
            'secretmanager.googleapis.com:443',
            __DIR__ . '/../testdata/resources/test_service_rest_client_config.php',
            [
                'httpHandler' => $httpHandler,
                'openTelemetryTracerProvider' => $tracerProvider,
            ]
        );

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::UNAVAILABLE],
                'initialRetryDelayMillis' => 1,
                'maxRetryDelayMillis' => 5,
            ]);

        $retryMiddleware = new RetryMiddleware([$transport, 'startUnaryCall'], $retrySettings);

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $message = (new MockRequestBody())->setName('message/foo');
            $call = new Call($method, MockResponse::class, $message);
            $result = $retryMiddleware($call, [])->wait();
            $this->assertSame('ok', $result->getName());
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(3, $spans);

        $attempt1 = $spans[0];
        $attempt2 = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $attempt1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $attempt1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $attempt1->getStatus()->getCode());
        $this->assertSame(503, $attempt1->getAttributes()->get(SpanAttributes::HTTP_RESPONSE_STATUS_CODE));
        $this->assertSame('UNAVAILABLE', $attempt1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertNull($attempt1->getAttributes()->get(SpanAttributes::HTTP_REQUEST_RESEND_COUNT));

        $this->assertSame($exportedAppSpan->getSpanId(), $attempt2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $attempt2->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $attempt2->getStatus()->getCode());
        $this->assertSame(200, $attempt2->getAttributes()->get(SpanAttributes::HTTP_RESPONSE_STATUS_CODE));
        $this->assertSame('OK', $attempt2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertSame(1, $attempt2->getAttributes()->get(SpanAttributes::HTTP_REQUEST_RESEND_COUNT));
    }

    private function setTelemetryOptions(RestTransport $transport, array $options): void
    {
        (new ReflectionClass(RestTransport::class))
            ->getMethod('setTelemetryOptions')
            ->invoke($transport, $options);
    }
}
