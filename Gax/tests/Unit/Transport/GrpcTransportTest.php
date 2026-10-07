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

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Testing\MockGrpcTransport;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\Tests\Unit\TestTrait;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\ValidationException;
use Google\Auth\Logging\StdOutLogger;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\RepeatedField;
use Google\Rpc\Code;
use Google\Rpc\ErrorInfo;
use Google\Rpc\Status;
use Grpc\BaseStub;
use Grpc\CallInvoker;
use Grpc\ChannelCredentials;
use Grpc\ClientStreamingCall;
use Grpc\Interceptor;
use Grpc\ServerStreamingCall;
use Grpc\UnaryCall;
use GuzzleHttp\Promise\Promise;
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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use RuntimeException;
use stdClass;
use TypeError;

class GrpcTransportTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    public function setUp(): void
    {
        self::requiresGrpcExtension();
    }

    private function callCredentialsCallback(MockGrpcTransport $transport)
    {
        $mockCall = new Call('method', '', null);
        $options = [];

        $response = $transport->startUnaryCall($mockCall, $options)->wait();
        $args = $transport->getRequestArguments();
        return call_user_func($args['options']['call_credentials_callback']);
    }

    public function testClientStreamingSuccessObject()
    {
        $response = new Status();
        $response->setCode(Code::OK);
        $response->setMessage('response');

        $status = new stdClass();
        $status->code = Code::OK;

        $clientStreamingCall = $this->prophesize(ClientStreamingCall::class);
        $clientStreamingCall->wait()
            ->shouldBeCalledOnce()
            ->willReturn([$response, $status]);

        $transport = new MockGrpcTransport($clientStreamingCall->reveal());

        $stream = $transport->startClientStreamingCall(
            new Call('method', null),
            []
        );

        /* @var $stream \Google\ApiCore\ClientStream */
        $actualResponse = $stream->writeAllAndReadResponse([]);
        $this->assertEquals($response, $actualResponse);
    }

    public function testClientStreamingFailure()
    {
        $request = 'request';
        $response = 'response';

        $status = new stdClass();
        $status->code = Code::INTERNAL;
        $status->details = 'client streaming failure';

        $clientStreamingCall = $this->prophesize(ClientStreamingCall::class);
        $clientStreamingCall->wait()
            ->shouldBeCalledOnce()
            ->willReturn([$response, $status]);

        $transport = new MockGrpcTransport($clientStreamingCall->reveal());

        $stream = $transport->startClientStreamingCall(
            new Call('takeAction', null),
            []
        );

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('client streaming failure');

        $stream->readResponse();
    }

    public function testServerStreamingSuccess()
    {
        $response = 'response';

        $status = new stdClass();
        $status->code = Code::OK;

        $message = $this->createMockRequest();

        $serverStreamingCall = $this->prophesize(\Grpc\ServerStreamingCall::class);
        $serverStreamingCall->responses()
            ->shouldBeCalledOnce()
            ->willReturn([$response]);
        $serverStreamingCall->getStatus()
            ->shouldBeCalledOnce()
            ->willReturn($status);

        $transport = new MockGrpcTransport($serverStreamingCall->reveal());

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $transport->startServerStreamingCall(
            new Call('takeAction', null, $message),
            []
        );

        $actualResponsesArray = [];
        foreach ($stream->readAll() as $actualResponse) {
            $actualResponsesArray[] = $actualResponse;
        }

        $this->assertEquals([$response], $actualResponsesArray);
    }

    public function testServerStreamingSuccessResources()
    {
        $responses = ['resource1', 'resource2'];
        $repeatedField = new RepeatedField(GPBType::STRING);
        foreach ($responses as $response) {
            $repeatedField[] = $response;
        }

        $response = $this->createMockResponse('nextPageToken', $repeatedField);

        $status = new stdClass();
        $status->code = Code::OK;

        $message = $this->createMockRequest();

        $call = $this->prophesize(\Grpc\ServerStreamingCall::class);
        $call->responses()
            ->shouldBeCalledOnce()
            ->willReturn([$response]);
        $call->getStatus()
            ->shouldBeCalledOnce()
            ->willReturn($status);

        $transport = new MockGrpcTransport($call->reveal());

        $call = new Call(
            'takeAction',
            null,
            $message,
            ['resourcesGetMethod' => 'getResourcesList']
        );
        $options = [];

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $transport->startServerStreamingCall(
            $call,
            $options
        );

        $actualResponsesArray = [];
        foreach ($stream->readAll() as $actualResponse) {
            $actualResponsesArray[] = $actualResponse;
        }
        $this->assertEquals($responses, $actualResponsesArray);
    }

    public function testServerStreamingFailure()
    {
        $status = new stdClass();
        $status->code = Code::INTERNAL;
        $status->details = 'server streaming failure';

        $message = $this->createMockRequest();

        $serverStreamingCall = $this->prophesize(\Grpc\ServerStreamingCall::class);
        $serverStreamingCall->responses()
            ->shouldBeCalledOnce()
            ->willReturn(['response1']);
        $serverStreamingCall->getStatus()
            ->shouldBeCalledOnce()
            ->willReturn($status);

        $transport = new MockGrpcTransport($serverStreamingCall->reveal());

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $transport->startServerStreamingCall(
            new Call('takeAction', null, $message),
            []
        );

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('server streaming failure');

        foreach ($stream->readAll() as $actualResponse) {
            // for loop to trigger generator and API exception
        }
    }

    public function testBidiStreamingSuccessSimple()
    {
        $response = 'response';
        $status = new stdClass();
        $status->code = Code::OK;

        $bidiStreamingCall = $this->prophesize(\Grpc\BidiStreamingCall::class);
        $bidiStreamingCall->read()
            ->shouldBeCalled()
            ->willReturn($response, null);
        $bidiStreamingCall->getStatus()
            ->shouldBeCalled()
            ->willReturn($status);
        $bidiStreamingCall->writesDone()
            ->shouldBeCalledOnce();

        $transport = new MockGrpcTransport($bidiStreamingCall->reveal());

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $transport->startBidiStreamingCall(
            new Call('takeAction', null),
            []
        );

        $actualResponsesArray = [];
        foreach ($stream->closeWriteAndReadAll() as $actualResponse) {
            $actualResponsesArray[] = $actualResponse;
        }
        $this->assertEquals([$response], $actualResponsesArray);
    }

    public function testBidiOpeningRequestLogsRpcName()
    {
        $status = new stdClass();
        $status->code = Code::OK;
        $rpcName = 'takeAction';

        $bidiStreamingCall = $this->prophesize(\Grpc\BidiStreamingCall::class);

        $transport = new MockGrpcTransport(
            $bidiStreamingCall->reveal(),
            logger: new StdOutLogger()
        );

        /* @var \Google\ApiCore\BidiStream $stream*/
        $stream = $transport->startBidiStreamingCall(
            new Call($rpcName, null),
            ['headers' => [
                ['thisis' => 'a header']
            ]]
        );

        $buffer = $this->getActualOutput();
        $unserializedBuffer = json_decode($buffer, true);

        $this->assertNotEmpty($unserializedBuffer);
        $this->assertNotEmpty($unserializedBuffer['rpcName']);
        $this->assertEquals($rpcName, $unserializedBuffer['rpcName']);
        $this->assertNotEmpty($unserializedBuffer['jsonPayload']);
        $this->assertEquals('grpc://', $unserializedBuffer['jsonPayload']['request.url']);
    }

    public function testServerStreamingRequestLogsUrl()
    {
        $rpcName = 'takeAction';
        $serverStreamingCall = $this->prophesize(\Grpc\ServerStreamingCall::class);
        $message = $this->createMockRequest();

        $transport = new MockGrpcTransport(
            $serverStreamingCall->reveal(),
            logger: new StdOutLogger()
        );

        $stream = $transport->startServerStreamingCall(
            new Call($rpcName, null, $message),
            ['headers' => []]
        );

        $buffer = $this->getActualOutput();
        $unserializedBuffer = json_decode($buffer, true);

        $this->assertNotEmpty($unserializedBuffer);
        $this->assertNotEmpty($unserializedBuffer['jsonPayload']);
        $this->assertEquals('grpc://', $unserializedBuffer['jsonPayload']['request.url']);
    }

    public function testUnaryRequestLogsUrl()
    {
        $rpcName = 'takeAction';
        $unaryCall = $this->prophesize(\Grpc\UnaryCall::class);
        $message = $this->createMockRequest();

        $transport = new MockGrpcTransport(
            $unaryCall->reveal(),
            logger: new StdOutLogger()
        );

        $transport->startUnaryCall(
            new Call($rpcName, null, $message),
            ['headers' => []]
        );

        $buffer = $this->getActualOutput();
        $unserializedBuffer = json_decode($buffer, true);

        $this->assertNotEmpty($unserializedBuffer);
        $this->assertNotEmpty($unserializedBuffer['jsonPayload']);
        $this->assertEquals('grpc://', $unserializedBuffer['jsonPayload']['request.url']);
    }

    public function testBidiStreamingSuccessObject()
    {
        $response = new Status();
        $response->setCode(Code::OK);
        $response->setMessage('response');

        $status = new stdClass();
        $status->code = Code::OK;

        $bidiStreamingCall = $this->prophesize(\Grpc\BidiStreamingCall::class);
        $bidiStreamingCall->read()
            ->shouldBeCalled()
            ->willReturn($response, null);
        $bidiStreamingCall->getStatus()
            ->shouldBeCalled()
            ->willReturn($status);
        $bidiStreamingCall->writesDone()
            ->shouldBeCalledOnce();

        $transport = new MockGrpcTransport($bidiStreamingCall->reveal());

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $transport->startBidiStreamingCall(
            new Call('takeAction', null),
            []
        );

        $actualResponsesArray = [];
        foreach ($stream->closeWriteAndReadAll() as $actualResponse) {
            $actualResponsesArray[] = $actualResponse;
        }
        $this->assertEquals([$response], $actualResponsesArray);
    }

    public function testBidiStreamingSuccessResources()
    {
        $responses = ['resource1', 'resource2'];
        $repeatedField = new RepeatedField(GPBType::STRING);
        foreach ($responses as $response) {
            $repeatedField[] = $response;
        }

        $response = $this->createMockResponse('nextPageToken', $repeatedField);

        $status = new stdClass();
        $status->code = Code::OK;

        $bidiStreamingCall = $this->prophesize(\Grpc\BidiStreamingCall::class);
        $bidiStreamingCall->read()
            ->shouldBeCalled()
            ->willReturn($response, null);
        $bidiStreamingCall->getStatus()
            ->shouldBeCalled()
            ->willReturn($status);
        $bidiStreamingCall->writesDone()
            ->shouldBeCalledOnce();

        $transport = new MockGrpcTransport($bidiStreamingCall->reveal());

        $call = new Call(
            'takeAction',
            null,
            null,
            ['resourcesGetMethod' => 'getResourcesList']
        );

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $transport->startBidiStreamingCall(
            $call,
            []
        );

        $actualResponsesArray = [];
        foreach ($stream->closeWriteAndReadAll() as $actualResponse) {
            $actualResponsesArray[] = $actualResponse;
        }
        $this->assertEquals($responses, $actualResponsesArray);
    }

    public function testBidiStreamingFailure()
    {
        $response = 'response';
        $status = new stdClass();
        $status->code = Code::INTERNAL;
        $status->details = 'bidi failure';

        $bidiStreamingCall = $this->prophesize(\Grpc\BidiStreamingCall::class);
        $bidiStreamingCall->read()
            ->shouldBeCalled()
            ->willReturn($response, null);
        $bidiStreamingCall->getStatus()
            ->shouldBeCalled()
            ->willReturn($status);
        $bidiStreamingCall->writesDone()
            ->shouldBeCalledOnce();

        $transport = new MockGrpcTransport($bidiStreamingCall->reveal());

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $transport->startBidiStreamingCall(
            new Call('takeAction', null),
            []
        );

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('bidi failure');

        foreach ($stream->closeWriteAndReadAll() as $actualResponse) {
            // for loop to trigger generator and API exception
        }
    }

    public function testAudienceOption()
    {
        $message = $this->createMockRequest();

        $call = $this->prophesize(Call::class);
        $call->getMessage()->willReturn($message);
        $call->getMethod()->shouldBeCalledOnce();
        $call->getDecodeType()->shouldBeCalledOnce();

        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->checkUniverseDomain()
            ->shouldBeCalledOnce();
        $credentialsWrapper->getAuthorizationHeaderCallback('an-audience')
            ->shouldBeCalledOnce();
        $hostname = '';
        $opts = ['credentials' => ChannelCredentials::createInsecure()];
        $transport = new GrpcTransport($hostname, $opts);
        $options = [
            'audience' => 'an-audience',
            'credentialsWrapper' => $credentialsWrapper->reveal(),
        ];
        $transport->startUnaryCall($call->reveal(), $options);
    }

    public function testClientCertSourceOptionValid()
    {
        $mockClientCertSource = function () {
            return ['MOCK_KEY', 'MOCK_CERT'];
        };
        $transport = GrpcTransport::build(
            'address.com:123',
            ['clientCertSource' => $mockClientCertSource]
        );

        $this->assertNotNull($transport);
    }

    public function testClientCertSourceOptionInvalid()
    {
        $mockClientCertSource = 'foo';

        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches('/must be.+callable/i');

        GrpcTransport::build(
            'address.com:123',
            ['clientCertSource' => $mockClientCertSource]
        );
    }

    /**
     * @dataProvider buildDataGrpc
     */
    public function testBuildGrpc($apiEndpoint, $config, $expectedTransportProvider)
    {
        $expectedTransport = $expectedTransportProvider();
        $actualTransport = GrpcTransport::build($apiEndpoint, $config);
        $this->assertEquals($expectedTransport, $actualTransport);
    }

    public function buildDataGrpc()
    {
        $uri = 'address.com';
        $apiEndpoint = "$uri:447";
        $apiEndpointDefaultPort = "$uri:443";
        return [
            [
                $apiEndpoint,
                [],
                function () use ($apiEndpoint) {
                    return new GrpcTransport(
                        $apiEndpoint,
                        [
                            'credentials' => null,
                        ],
                        null
                    );
                },
            ],
            [
                $uri,
                [],
                function () use ($apiEndpointDefaultPort) {
                    return new GrpcTransport(
                        $apiEndpointDefaultPort,
                        [
                            'credentials' => null,
                        ],
                        null
                    );
                },
            ],
        ];
    }

    /**
     * @dataProvider buildInvalidData
     */
    public function testBuildInvalid($apiEndpoint, $args)
    {
        $this->expectException(ValidationException::class);

        GrpcTransport::build($apiEndpoint, $args);
    }

    public function buildInvalidData()
    {
        return [
            [
                'addresswithtoo:many:segments',
                [],
            ],
            [
                'example.com',
                [
                    'channel' => 'not a channel',
                ]
            ]
        ];
    }

    /**
     * @dataProvider interceptorDataProvider
     */
    public function testExperimentalInterceptors($callType, $interceptor)
    {
        $mockCallInvoker = new class($this->buildMockCallForInterceptor($callType)) {
            private $called = false;
            private $mockCall;

            public function __construct($mockCall)
            {
                $this->mockCall = $mockCall;
            }

            public function createChannelFactory($hostname, $opts)
            {
                // no-op
            }

            public function UnaryCall($channel, $method, $deserialize, $options)
            {
                $this->called = true;
                return $this->mockCall;
            }

            public function ServerStreamingCall($channel, $method, $deserialize, $options)
            {
                $this->called = true;
                return $this->mockCall;
            }

            public function ClientStreamingCall($channel, $method, $deserialize, $options)
            {
                // no-op
            }

            public function BidiStreamingCall($channel, $method, $deserialize, $options)
            {
                // no-op
            }

            public function wasCalled()
            {
                return $this->called;
            }
        };

        $transport = new GrpcTransport(
            'example.com',
            [
                'credentials' => ChannelCredentials::createInsecure()
            ],
            null,
            [$interceptor]
        );

        $r = new \ReflectionProperty(BaseStub::class, 'call_invoker');
        $r->setValue(
            $transport,
            $mockCallInvoker
        );

        $call = new Call('method1', '', new MockRequest());

        $callMethod = $callType == UnaryCall::class ? 'startUnaryCall' : 'startServerStreamingCall';
        $transport->$callMethod($call, [
            'transportOptions' => [
                'grpcOptions' => [
                    'call-option' => 'call-option-value'
                ]
            ]
        ]);

        $this->assertTrue($mockCallInvoker->wasCalled());
    }

    public function interceptorDataProvider()
    {
        $this->autoloadTestdata('mocks', __NAMESPACE__);

        $deprecatedInterceptors = (new \ReflectionClass(Interceptor::class))
            ->getMethod('interceptUnaryUnary')
            ->getParameters()[3]
            ->getName() === 'metadata';

        $interceptor = $deprecatedInterceptors ? new DeprecatedTestInterceptor(): new TestInterceptor();
        $unaryInterceptor = $deprecatedInterceptors ? new DeprecatedTestUnaryInterceptor(): new TestUnaryInterceptor();

        return [
            [
                UnaryCall::class,
                $unaryInterceptor
            ],
            [
                UnaryCall::class,
                $interceptor
            ],
            [
                ServerStreamingCall::class,
                $interceptor
            ]
        ];
    }

    private function buildMockCallForInterceptor($callType)
    {
        $mockCall = $this->prophesize($callType);
        $mockCall->start(
            Argument::type(Message::class),
            [],
            [
                'call-option' => 'call-option-value',
                'test-interceptor-insert' => 'inserted-value'
            ]
        )->shouldBeCalled();

        if ($callType === UnaryCall::class) {
            $mockCall->wait()
                ->willReturn([
                    null,
                    Code::OK
                ]);
        }

        return $mockCall->reveal();
    }

    public function testStartUnaryCallEmitsT4ClientSpanOnSuccess(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $tracerProvider->expects($this->once())
            ->method('getTracer')
            ->with('google-cloud-php', '1.0.0')
            ->willReturn($tracer);

        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->with($method)
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

        $response = new Status();
        $response->setCode(Code::OK);

        $status = new stdClass();
        $status->code = Code::OK;

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()
            ->shouldBeCalledOnce()
            ->willReturn([$response, $status]);

        $transport = new MockGrpcTransport($unaryCall->reveal());
        $transport->setTelemetryOptions([
            'openTelemetryTracerProvider' => $tracerProvider,
            'clientVersion' => '1.0.0',
        ]);

        $call = new Call($method, Status::class, new MockRequest());
        $promise = $transport->startUnaryCall($call, []);
        $result = $promise->wait();

        $this->assertSame($response, $result);
        $this->assertSame('grpc', $attributes[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attributes[SpanAttributes::RPC_METHOD]);
        $this->assertArrayNotHasKey(SpanAttributes::SERVER_ADDRESS, $attributes);
        $this->assertArrayNotHasKey(SpanAttributes::SERVER_PORT, $attributes);
        $this->assertSame('OK', $recordedSpanAttributes[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
    }

    public function testStartUnaryCallEmitsT4ClientSpanOnFailure(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

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

        $status = new stdClass();
        $status->code = Code::NOT_FOUND;
        $status->details = 'Resource not found';

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()
            ->shouldBeCalledOnce()
            ->willReturn([null, $status]);

        $transport = new MockGrpcTransport($unaryCall->reveal());
        $transport->setTelemetryOptions([
            'openTelemetryTracerProvider' => $tracerProvider,
        ]);

        $call = new Call($method, Status::class, new MockRequest());
        $promise = $transport->startUnaryCall($call, []);

        $this->expectException(ApiException::class);

        try {
            $promise->wait();
        } finally {
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
        $credentialsWrapper->checkUniverseDomain()->shouldBeCalledOnce();
        $credentialsWrapper->getAuthorizationHeaderCallback(null)
            ->willThrow(new \RuntimeException('Auth callback failed'));

        $transport = new MockGrpcTransport(null);
        $transport->setTelemetryOptions([
            'openTelemetryTracerProvider' => $tracerProvider,
        ]);

        $call = new Call(
            'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion',
            Status::class,
            new MockRequest()
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Auth callback failed');

        $transport->startUnaryCall($call, [
            'credentialsWrapper' => $credentialsWrapper->reveal(),
        ]);
    }

    public function testBuildSetsTelemetryOptions(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);

        $transport = GrpcTransport::build('secretmanager.googleapis.com:443', [
            'openTelemetryTracerProvider' => $tracerProvider,
            'clientVersion' => '1.0.0',
        ]);

        $ref = new ReflectionClass($transport);
        $prop = $ref->getProperty('openTelemetryTracerProvider');
        $this->assertSame($tracerProvider, $prop->getValue($transport));

        $addrProp = $ref->getProperty('serverAddress');
        $this->assertSame('secretmanager.googleapis.com', $addrProp->getValue($transport));

        $portProp = $ref->getProperty('serverPort');
        $this->assertSame(443, $portProp->getValue($transport));
    }

    public function testStartUnaryCallDoesNotEmitSpanWhenTracingDisabled(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $response = new Status(['code' => Code::OK]);
        $status = new stdClass();
        $status->code = Code::OK;

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()->shouldBeCalledOnce()->willReturn([$response, $status]);

        $transport = $this->createTracedGrpcTransport([$unaryCall->reveal()]);

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(
                'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion',
                Status::class,
                new MockRequest()
            );
            $result = $transport->startUnaryCall($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        $spans = $exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    public function testStartUnaryCallRecordsParentSpanAndServerAttributes(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $response = new Status(['code' => Code::OK]);
        $status = new stdClass();
        $status->code = Code::OK;

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()->shouldBeCalledOnce()->willReturn([$response, $status]);

        $transport = $this->createTracedGrpcTransport([$unaryCall->reveal()], [
            'openTelemetryTracerProvider' => $tracerProvider,
            'clientVersion' => '1.2.3',
        ]);

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());
            $result = $transport->startUnaryCall($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(2, $spans);

        $transportSpan = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $transportSpan->getParentSpanId());
        $this->assertSame($exportedAppSpan->getTraceId(), $transportSpan->getTraceId());
        $this->assertSame(SpanKind::KIND_CLIENT, $transportSpan->getKind());
        $this->assertSame($method, $transportSpan->getName());
        $this->assertSame(StatusCode::STATUS_OK, $transportSpan->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $transportSpan->getInstrumentationScope()->getName());
        $this->assertSame('1.2.3', $transportSpan->getInstrumentationScope()->getVersion());

        $attributes = $transportSpan->getAttributes()->toArray();
        $this->assertSame('grpc', $attributes[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attributes[SpanAttributes::RPC_METHOD]);
        $this->assertSame('OK', $attributes[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('secretmanager.googleapis.com', $attributes[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attributes[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $attributes);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attributes);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $attributes);
    }

    public function testStartUnaryCallRecordsErrorInfoReasonAndServerFailureAttributes(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $statusWithoutErrorInfo = new stdClass();
        $statusWithoutErrorInfo->code = Code::UNAVAILABLE;
        $statusWithoutErrorInfo->details = 'Service unavailable';

        $errorInfo = new ErrorInfo([
            'reason' => 'IAM_PERMISSION_DENIED',
            'domain' => 'googleapis.com',
        ]);
        $statusWithErrorInfo = new stdClass();
        $statusWithErrorInfo->code = Code::PERMISSION_DENIED;
        $statusWithErrorInfo->details = 'Permission denied on resource';
        $statusWithErrorInfo->metadata = [
            'google.rpc.errorinfo-bin' => [$errorInfo->serializeToString()],
        ];

        $unaryCall1 = $this->prophesize(UnaryCall::class);
        $unaryCall1->wait()->shouldBeCalledOnce()->willReturn([null, $statusWithoutErrorInfo]);

        $unaryCall2 = $this->prophesize(UnaryCall::class);
        $unaryCall2->wait()->shouldBeCalledOnce()->willReturn([null, $statusWithErrorInfo]);

        $transport = $this->createTracedGrpcTransport(
            [$unaryCall1->reveal(), $unaryCall2->reveal()],
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());

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
        $this->assertSame($method, $span1->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $span1->getStatus()->getCode());
        $this->assertSame('Service unavailable', $span1->getStatus()->getDescription());
        $attrs1 = $span1->getAttributes()->toArray();
        $this->assertSame('grpc', $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attrs1[SpanAttributes::RPC_METHOD]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Service unavailable', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('secretmanager.googleapis.com', $attrs1[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attrs1[SpanAttributes::SERVER_PORT]);

        $this->assertSame($exportedAppSpan->getSpanId(), $span2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $span2->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $span2->getStatus()->getCode());
        $this->assertSame('Permission denied on resource', $span2->getStatus()->getDescription());
        $attrs2 = $span2->getAttributes()->toArray();
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
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $unaryCallForCancel = $this->prophesize(UnaryCall::class);
        $unaryCallForCancel->cancel()->shouldBeCalledOnce();

        $callCount = 0;
        $transport = new class(
            'secretmanager.googleapis.com:443',
            function () use (&$callCount, $unaryCallForCancel) {
                $callCount++;
                if ($callCount === 1) {
                    throw new RuntimeException('Client deadline exceeded before sending request');
                }
                return $unaryCallForCancel->reveal();
            },
            ['openTelemetryTracerProvider' => $tracerProvider]
        ) extends GrpcTransport {
            /** @var callable */
            private $factory;

            public function __construct(string $hostname, callable $factory, array $telemetryOptions)
            {
                $this->factory = $factory;
                parent::__construct($hostname, ['credentials' => ChannelCredentials::createSsl()]);
                $this->setTelemetryOptions($telemetryOptions);
            }

            // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
            protected function _simpleRequest(
                $method,
                $arguments,
                $deserialize,
                array $metadata = [],
                array $options = []
            ) {
                return ($this->factory)();
            }
        };

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());

            try {
                $transport->startUnaryCall($call, []);
                $this->fail('Expected RuntimeException');
            } catch (RuntimeException $e) {
                $this->assertSame('Client deadline exceeded before sending request', $e->getMessage());
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
        $this->assertSame($method, $exceptionSpan->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $exceptionSpan->getStatus()->getCode());
        $attrs1 = $exceptionSpan->getAttributes()->toArray();
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Client deadline exceeded before sending request', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs1);

        $this->assertSame($exportedAppSpan->getSpanId(), $cancelledSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $cancelledSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $cancelledSpan->getStatus()->getCode());
        $attrs2 = $cancelledSpan->getAttributes()->toArray();
        $this->assertSame('CANCELLED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs2);
    }

    public function testStartUnaryCallWithRetryMiddlewareEmitsSpanPerAttempt(): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $failStatus = new stdClass();
        $failStatus->code = Code::UNAVAILABLE;
        $failStatus->details = 'Temporary backend error';

        $okResponse = new Status(['code' => Code::OK]);
        $okStatus = new stdClass();
        $okStatus->code = Code::OK;

        $unaryCall1 = $this->prophesize(UnaryCall::class);
        $unaryCall1->wait()->shouldBeCalledOnce()->willReturn([null, $failStatus]);

        $unaryCall2 = $this->prophesize(UnaryCall::class);
        $unaryCall2->wait()->shouldBeCalledOnce()->willReturn([$okResponse, $okStatus]);

        $transport = $this->createTracedGrpcTransport(
            [$unaryCall1->reveal(), $unaryCall2->reveal()],
            ['openTelemetryTracerProvider' => $tracerProvider]
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
            $call = new Call($method, Status::class, new MockRequest());
            $result = $retryMiddleware($call, [])->wait();
            $this->assertSame($okResponse, $result);
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
        $this->assertSame('UNAVAILABLE', $attempt1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertSame('UNAVAILABLE', $attempt1->getAttributes()->get(SpanAttributes::ERROR_TYPE));

        $this->assertSame($exportedAppSpan->getSpanId(), $attempt2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $attempt2->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $attempt2->getStatus()->getCode());
        $this->assertSame('OK', $attempt2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertNull($attempt2->getAttributes()->get(SpanAttributes::ERROR_TYPE));
    }

    /**
     * @param UnaryCall[] $unaryCalls
     * @param array<string, mixed> $telemetryOptions
     */
    private function createTracedGrpcTransport(array $unaryCalls, array $telemetryOptions = []): GrpcTransport
    {
        return new class(
            'secretmanager.googleapis.com:443',
            $unaryCalls,
            $telemetryOptions
        ) extends GrpcTransport {
            /** @var UnaryCall[] */
            private array $unaryCalls;

            /**
             * @param UnaryCall[] $unaryCalls
             * @param array<string, mixed> $telemetryOptions
             */
            public function __construct(string $hostname, array $unaryCalls, array $telemetryOptions)
            {
                $this->unaryCalls = $unaryCalls;
                parent::__construct($hostname, ['credentials' => ChannelCredentials::createSsl()]);
                $this->setTelemetryOptions($telemetryOptions);
            }

            // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
            protected function _simpleRequest(
                $method,
                $arguments,
                $deserialize,
                array $metadata = [],
                array $options = []
            ) {
                return array_shift($this->unaryCalls);
            }
        };
    }
}
