<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\ApiCore\Tests\Unit\Telemetry;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\Middleware\TracingMiddleware;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Tests\Unit\TestTrait;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\Rpc\Code;
use Google\Rpc\ErrorInfo;
use Google\Rpc\Status;
use Grpc\ChannelCredentials;
use Grpc\UnaryCall;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise;
use InvalidArgumentException;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use RuntimeException;
use stdClass;

/**
 * Tests OpenTelemetry tracing behavior against the client library tracing test plan:
 * - F1: Low-level T4 tracing
 * - F2: Client-level T3 tracing
 * - F3: T3/T4 Span Hierarchy and Aggregation
 */
class TracingTestPlanTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    private const RPC_METHOD = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';
    private const SERVER_ADDRESS = 'secretmanager.googleapis.com';
    private const SERVER_PORT = 443;
    private const CLIENT_VERSION = '1.2.3';

    private InMemoryExporter $exporter;
    private TracerProvider $tracerProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->exporter = new InMemoryExporter();
        $this->tracerProvider = new TracerProvider(new SimpleSpanProcessor($this->exporter));
    }

    protected function tearDown(): void
    {
        $this->tracerProvider->shutdown();
        parent::tearDown();
    }

    /**
     * F1.1: HTTP no traces emitted unless enabled.
     */
    public function testF1_1_HttpNoTracesEmittedUnlessEnabled(): void
    {
        $response = new Status(['code' => Code::OK]);
        $restTransport = $this->prophesize(RestTransport::class);
        $restTransport->startUnaryCall(\Prophecy\Argument::type(Call::class), \Prophecy\Argument::type('array'))
            ->shouldBeCalledOnce()
            ->willReturn(Create::promiseFor($response));

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $restTransport->reveal()->startUnaryCall($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        $spans = $this->exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    /**
     * F1.6: gRPC no traces emitted unless enabled.
     */
    public function testF1_6_GrpcNoTracesEmittedUnlessEnabled(): void
    {
        $response = new Status(['code' => Code::OK]);
        $status = new stdClass();
        $status->code = Code::OK;

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()->shouldBeCalledOnce()->willReturn([$response, $status]);

        $transport = $this->createGrpcTransport([$unaryCall->reveal()]);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $transport->startUnaryCall($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        $spans = $this->exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    /**
     * F1.7: gRPC T4 success case name and attributes conform to requirements.
     */
    public function testF1_7_GrpcT4Success(): void
    {
        $response = new Status(['code' => Code::OK]);
        $status = new stdClass();
        $status->code = Code::OK;

        $unaryCall = $this->prophesize(UnaryCall::class);
        $unaryCall->wait()->shouldBeCalledOnce()->willReturn([$response, $status]);

        $transport = $this->createGrpcTransport([$unaryCall->reveal()], [
            'openTelemetryTracerProvider' => $this->tracerProvider,
            'clientVersion' => self::CLIENT_VERSION,
        ]);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $transport->startUnaryCall($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(2, $spans);

        $t4Span = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $t4Span->getParentSpanId());
        $this->assertSame($exportedAppSpan->getTraceId(), $t4Span->getTraceId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Span->getKind());
        $this->assertSame(self::RPC_METHOD, $t4Span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $t4Span->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $t4Span->getInstrumentationScope()->getName());
        $this->assertSame(self::CLIENT_VERSION, $t4Span->getInstrumentationScope()->getVersion());

        $attributes = $t4Span->getAttributes()->toArray();
        $this->assertSame('grpc', $attributes[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(self::RPC_METHOD, $attributes[SpanAttributes::RPC_METHOD]);
        $this->assertSame('OK', $attributes[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame(self::SERVER_ADDRESS, $attributes[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(self::SERVER_PORT, $attributes[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $attributes);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attributes);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $attributes);
    }

    /**
     * F1.8: gRPC T4 server failures case name and attributes conform to requirements
     * (testing both standard gRPC status code and ErrorInfo reason).
     */
    public function testF1_8_GrpcT4ServerFailures(): void
    {
        // Case 1: Server failure without ErrorInfo (uses status code string)
        $statusWithoutErrorInfo = new stdClass();
        $statusWithoutErrorInfo->code = Code::UNAVAILABLE;
        $statusWithoutErrorInfo->details = 'Service unavailable';

        // Case 2: Server failure with ErrorInfo (uses ErrorInfo reason)
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

        $transport = $this->createGrpcTransport(
            [$unaryCall1->reveal(), $unaryCall2->reveal()],
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());

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
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(3, $spans);

        $t4Span1 = $spans[0];
        $t4Span2 = $spans[1];
        $exportedAppSpan = $spans[2];

        // Verify T4 span 1 (without ErrorInfo)
        $this->assertSame($exportedAppSpan->getSpanId(), $t4Span1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Span1->getKind());
        $this->assertSame(self::RPC_METHOD, $t4Span1->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4Span1->getStatus()->getCode());
        $this->assertSame('Service unavailable', $t4Span1->getStatus()->getDescription());
        $attrs1 = $t4Span1->getAttributes()->toArray();
        $this->assertSame('grpc', $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(self::RPC_METHOD, $attrs1[SpanAttributes::RPC_METHOD]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Service unavailable', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame(self::SERVER_ADDRESS, $attrs1[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(self::SERVER_PORT, $attrs1[SpanAttributes::SERVER_PORT]);

        // Verify T4 span 2 (with ErrorInfo)
        $this->assertSame($exportedAppSpan->getSpanId(), $t4Span2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Span2->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4Span2->getStatus()->getCode());
        $this->assertSame('Permission denied on resource', $t4Span2->getStatus()->getDescription());
        $attrs2 = $t4Span2->getAttributes()->toArray();
        $this->assertSame('PERMISSION_DENIED', $attrs2[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
        $this->assertSame('IAM_PERMISSION_DENIED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Permission denied on resource', $attrs2[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs2[SpanAttributes::EXCEPTION_TYPE]);
    }

    /**
     * F1.9: gRPC T4 client failures case name and attributes conform to requirements
     * (testing both client-side exception before response and client cancellation).
     */
    public function testF1_9_GrpcT4ClientFailures(): void
    {
        $unaryCallForCancel = $this->prophesize(UnaryCall::class);
        $unaryCallForCancel->cancel()->shouldBeCalledOnce();

        $callCount = 0;
        $transport = new class(
            self::SERVER_ADDRESS . ':' . self::SERVER_PORT,
            function () use (&$callCount, $unaryCallForCancel) {
                $callCount++;
                if ($callCount === 1) {
                    throw new RuntimeException('Client deadline exceeded before sending request');
                }
                return $unaryCallForCancel->reveal();
            },
            ['openTelemetryTracerProvider' => $this->tracerProvider]
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

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());

            // Case 1: Client-side exception thrown before receiving response
            try {
                $transport->startUnaryCall($call, []);
                $this->fail('Expected RuntimeException');
            } catch (RuntimeException $e) {
                $this->assertSame('Client deadline exceeded before sending request', $e->getMessage());
            }

            // Case 2: Client cancels the in-flight RPC promise
            $promise = $transport->startUnaryCall($call, []);
            $promise->cancel();
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(3, $spans);

        $t4ExceptionSpan = $spans[0];
        $t4CancelledSpan = $spans[1];
        $exportedAppSpan = $spans[2];

        // Verify client exception span
        $this->assertSame($exportedAppSpan->getSpanId(), $t4ExceptionSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4ExceptionSpan->getKind());
        $this->assertSame(self::RPC_METHOD, $t4ExceptionSpan->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4ExceptionSpan->getStatus()->getCode());
        $attrs1 = $t4ExceptionSpan->getAttributes()->toArray();
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(RuntimeException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Client deadline exceeded before sending request', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs1);

        // Verify client cancellation span
        $this->assertSame($exportedAppSpan->getSpanId(), $t4CancelledSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4CancelledSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4CancelledSpan->getStatus()->getCode());
        $attrs2 = $t4CancelledSpan->getAttributes()->toArray();
        $this->assertSame('CANCELLED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs2);
    }

    /**
     * F1.10: gRPC T4 retries.
     */
    public function testF1_10_GrpcT4Retries(): void
    {
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

        $transport = $this->createGrpcTransport(
            [$unaryCall1->reveal(), $unaryCall2->reveal()],
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::UNAVAILABLE],
                'initialRetryDelayMillis' => 1,
                'maxRetryDelayMillis' => 5,
            ]);

        $retryMiddleware = new RetryMiddleware([$transport, 'startUnaryCall'], $retrySettings);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $retryMiddleware($call, [])->wait();
            $this->assertSame($okResponse, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(3, $spans);

        $t4Attempt1 = $spans[0];
        $t4Attempt2 = $spans[1];
        $exportedAppSpan = $spans[2];

        // First attempt fails
        $this->assertSame($exportedAppSpan->getSpanId(), $t4Attempt1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Attempt1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4Attempt1->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $t4Attempt1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertSame('UNAVAILABLE', $t4Attempt1->getAttributes()->get(SpanAttributes::ERROR_TYPE));

        // Second attempt succeeds
        $this->assertSame($exportedAppSpan->getSpanId(), $t4Attempt2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Attempt2->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $t4Attempt2->getStatus()->getCode());
        $this->assertSame('OK', $t4Attempt2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertNull($t4Attempt2->getAttributes()->get(SpanAttributes::ERROR_TYPE));
    }

    /**
     * F2.1: HTTP no traces emitted unless enabled.
     */
    public function testF2_1_HttpNoTracesEmittedUnlessEnabled(): void
    {
        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'http',
            ['openTelemetryTracerProvider' => null]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $middleware($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        $spans = $this->exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    /**
     * F2.2: HTTP T3 case name and attributes conform to requirements.
     */
    public function testF2_2_HttpT3Success(): void
    {
        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'http',
            [
                'openTelemetryTracerProvider' => $this->tracerProvider,
                'clientVersion' => self::CLIENT_VERSION,
            ]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $middleware($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(2, $spans);

        $t3Span = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame($exportedAppSpan->getTraceId(), $t3Span->getTraceId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(self::RPC_METHOD, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $t3Span->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $t3Span->getInstrumentationScope()->getName());
        $this->assertSame(self::CLIENT_VERSION, $t3Span->getInstrumentationScope()->getVersion());

        $attrs = $t3Span->getAttributes()->toArray();
        $this->assertSame('http', $attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(self::RPC_METHOD, $attrs[SpanAttributes::RPC_METHOD]);
        $this->assertSame(self::SERVER_ADDRESS, $attrs[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(self::SERVER_PORT, $attrs[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $attrs);
    }

    /**
     * F2.3: HTTP T3 server failures case name and attributes conform to requirements.
     */
    public function testF2_3_HttpT3ServerFailures(): void
    {
        $apiException1 = ApiException::createFromRestApiResponse(
            'Service unavailable',
            Code::UNAVAILABLE
        );
        $apiException2 = ApiException::createFromRestApiResponse(
            'API disabled in project',
            Code::PERMISSION_DENIED,
            [
                [
                    '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
                    'reason' => 'SERVICE_DISABLED',
                    'domain' => 'googleapis.com',
                    'metadata' => [],
                ],
            ]
        );

        $exceptions = [$apiException1, $apiException2];
        $nextHandler = function () use (&$exceptions) {
            return Create::rejectionFor(array_shift($exceptions));
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'http',
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());

            try {
                $middleware($call, [])->wait();
                $this->fail('Expected ApiException 1');
            } catch (ApiException $e) {
                $this->assertSame('UNAVAILABLE', $e->getStatus());
            }

            try {
                $middleware($call, [])->wait();
                $this->fail('Expected ApiException 2');
            } catch (ApiException $e) {
                $this->assertSame('SERVICE_DISABLED', $e->getReason());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(3, $spans);

        $t3Span1 = $spans[0];
        $t3Span2 = $spans[1];
        $exportedAppSpan = $spans[2];

        // Span 1: status code fallback
        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span1->getStatus()->getCode());
        $attrs1 = $t3Span1->getAttributes()->toArray();
        $this->assertSame('http', $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Service unavailable', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);

        // Span 2: ErrorInfo reason
        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span2->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span2->getStatus()->getCode());
        $attrs2 = $t3Span2->getAttributes()->toArray();
        $this->assertSame('SERVICE_DISABLED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('API disabled in project', $attrs2[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs2[SpanAttributes::EXCEPTION_TYPE]);
    }

    /**
     * F2.4: HTTP T3 client failures case name and attributes conform to requirements.
     */
    public function testF2_4_HttpT3ClientFailures(): void
    {
        $callIndex = 0;
        $nextHandler = function () use (&$callIndex) {
            $callIndex++;
            if ($callIndex === 1) {
                throw new InvalidArgumentException('Client request validation failed');
            }
            $pending = new Promise(function () {
            }, function () {
            });
            return $pending;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'http',
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());

            try {
                $middleware($call, []);
                $this->fail('Expected InvalidArgumentException');
            } catch (InvalidArgumentException $e) {
                $this->assertSame('Client request validation failed', $e->getMessage());
            }

            $promise = $middleware($call, []);
            $promise->cancel();
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(3, $spans);

        $t3ExceptionSpan = $spans[0];
        $t3CancelSpan = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3ExceptionSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3ExceptionSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3ExceptionSpan->getStatus()->getCode());
        $attrs1 = $t3ExceptionSpan->getAttributes()->toArray();
        $this->assertSame('http', $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(InvalidArgumentException::class, $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(InvalidArgumentException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Client request validation failed', $attrs1[SpanAttributes::STATUS_MESSAGE]);

        $this->assertSame($exportedAppSpan->getSpanId(), $t3CancelSpan->getParentSpanId());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3CancelSpan->getStatus()->getCode());
        $attrs2 = $t3CancelSpan->getAttributes()->toArray();
        $this->assertSame('CANCELLED', $attrs2[SpanAttributes::ERROR_TYPE]);
    }

    /**
     * F2.5: gRPC no traces emitted unless enabled.
     */
    public function testF2_5_GrpcNoTracesEmittedUnlessEnabled(): void
    {
        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            ['openTelemetryTracerProvider' => null]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $middleware($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        $spans = $this->exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    /**
     * F2.6: gRPC T3 success case name and attributes conform to requirements.
     */
    public function testF2_6_GrpcT3Success(): void
    {
        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            [
                'openTelemetryTracerProvider' => $this->tracerProvider,
                'clientVersion' => self::CLIENT_VERSION,
            ]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $middleware($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(2, $spans);

        $t3Span = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame($exportedAppSpan->getTraceId(), $t3Span->getTraceId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(self::RPC_METHOD, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $t3Span->getStatus()->getCode());

        $attrs = $t3Span->getAttributes()->toArray();
        $this->assertSame('grpc', $attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(self::RPC_METHOD, $attrs[SpanAttributes::RPC_METHOD]);
        $this->assertSame(self::SERVER_ADDRESS, $attrs[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(self::SERVER_PORT, $attrs[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $attrs);
    }

    /**
     * F2.7: gRPC T3 server failures case name and attributes conform to requirements.
     */
    public function testF2_7_GrpcT3ServerFailures(): void
    {
        $errorInfo = new ErrorInfo([
            'reason' => 'RESOURCE_MISSING',
            'domain' => 'googleapis.com',
        ]);
        $status = new stdClass();
        $status->code = Code::NOT_FOUND;
        $status->details = 'Secret version not found';
        $status->metadata = [
            'google.rpc.errorinfo-bin' => [$errorInfo->serializeToString()],
        ];
        $apiException = ApiException::createFromStdClass($status);

        $nextHandler = fn () => Create::rejectionFor($apiException);

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            try {
                $middleware($call, [])->wait();
                $this->fail('Expected ApiException');
            } catch (ApiException $e) {
                $this->assertSame('RESOURCE_MISSING', $e->getReason());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(2, $spans);

        $t3Span = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span->getStatus()->getCode());
        $this->assertSame('Secret version not found', $t3Span->getStatus()->getDescription());

        $attrs = $t3Span->getAttributes()->toArray();
        $this->assertSame('grpc', $attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame('RESOURCE_MISSING', $attrs[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Secret version not found', $attrs[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs[SpanAttributes::EXCEPTION_TYPE]);
    }

    /**
     * F2.8: gRPC T3 client failures case name and attributes conform to requirements.
     */
    public function testF2_8_GrpcT3ClientFailures(): void
    {
        $nextHandler = function () {
            throw new RuntimeException('Client connection setup error');
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            ['openTelemetryTracerProvider' => $this->tracerProvider]
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            try {
                $middleware($call, []);
                $this->fail('Expected RuntimeException');
            } catch (RuntimeException $e) {
                $this->assertSame('Client connection setup error', $e->getMessage());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(2, $spans);

        $t3Span = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span->getStatus()->getCode());
        $attrs = $t3Span->getAttributes()->toArray();
        $this->assertSame(RuntimeException::class, $attrs[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(RuntimeException::class, $attrs[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Client connection setup error', $attrs[SpanAttributes::STATUS_MESSAGE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs);
    }

    /**
     * F3.3: gRPC T3/T4 retry succeeds.
     */
    public function testF3_3_GrpcT3T4RetrySucceeds(): void
    {
        $failStatus = new stdClass();
        $failStatus->code = Code::UNAVAILABLE;
        $failStatus->details = 'Transient error on attempt 1';

        $okResponse = new Status(['code' => Code::OK]);
        $okStatus = new stdClass();
        $okStatus->code = Code::OK;

        $unaryCall1 = $this->prophesize(UnaryCall::class);
        $unaryCall1->wait()->shouldBeCalledOnce()->willReturn([null, $failStatus]);

        $unaryCall2 = $this->prophesize(UnaryCall::class);
        $unaryCall2->wait()->shouldBeCalledOnce()->willReturn([$okResponse, $okStatus]);

        $telemetryOptions = [
            'openTelemetryTracerProvider' => $this->tracerProvider,
            'clientVersion' => self::CLIENT_VERSION,
        ];

        $transport = $this->createGrpcTransport(
            [$unaryCall1->reveal(), $unaryCall2->reveal()],
            $telemetryOptions
        );

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::UNAVAILABLE],
                'initialRetryDelayMillis' => 1,
                'maxRetryDelayMillis' => 5,
            ]);

        $callStack = new RetryMiddleware([$transport, 'startUnaryCall'], $retrySettings);
        $callStack = new TracingMiddleware(
            $callStack,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            $telemetryOptions
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            $result = $callStack($call, [])->wait();
            $this->assertSame($okResponse, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(4, $spans);

        $t4Span1 = $spans[0];
        $t4Span2 = $spans[1];
        $t3Span = $spans[2];
        $exportedAppSpan = $spans[3];

        // Verify parent-child hierarchy: APP -> T3 -> (T4_1, T4_2)
        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame($t3Span->getSpanId(), $t4Span1->getParentSpanId());
        $this->assertSame($t3Span->getSpanId(), $t4Span2->getParentSpanId());

        // Verify T4_1 matches failure requirements (F1.8)
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Span1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t4Span1->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $t4Span1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertSame('UNAVAILABLE', $t4Span1->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame(
            'Transient error on attempt 1',
            $t4Span1->getAttributes()->get(SpanAttributes::STATUS_MESSAGE)
        );

        // Verify T4_2 matches success requirements (F1.7)
        $this->assertSame(SpanKind::KIND_CLIENT, $t4Span2->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $t4Span2->getStatus()->getCode());
        $this->assertSame('OK', $t4Span2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertNull($t4Span2->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertNull($t4Span2->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));

        // Verify T3 matches success requirements (F2.6)
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $t3Span->getStatus()->getCode());
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    /**
     * F3.4: gRPC T3/T4 retries exhausted.
     */
    public function testF3_4_GrpcT3T4RetriesExhausted(): void
    {
        $failStatus = new stdClass();
        $failStatus->code = Code::UNAVAILABLE;
        $failStatus->details = 'Persistent backend outage';

        $unaryCalls = [];
        for ($i = 0; $i < 3; $i++) {
            $call = $this->prophesize(UnaryCall::class);
            $call->wait()->shouldBeCalledOnce()->willReturn([null, $failStatus]);
            $unaryCalls[] = $call->reveal();
        }

        $telemetryOptions = [
            'openTelemetryTracerProvider' => $this->tracerProvider,
            'clientVersion' => self::CLIENT_VERSION,
        ];

        $transport = $this->createGrpcTransport($unaryCalls, $telemetryOptions);

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::UNAVAILABLE],
                'maxRetries' => 2,
                'initialRetryDelayMillis' => 1,
                'maxRetryDelayMillis' => 5,
            ]);

        $callStack = new RetryMiddleware([$transport, 'startUnaryCall'], $retrySettings);
        $callStack = new TracingMiddleware(
            $callStack,
            self::SERVER_ADDRESS,
            self::SERVER_PORT,
            'grpc',
            $telemetryOptions
        );

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(self::RPC_METHOD, Status::class, new MockRequest());
            try {
                $callStack($call, [])->wait();
                $this->fail('Expected ApiException after exhausting retries');
            } catch (ApiException $e) {
                $this->assertSame('UNAVAILABLE', $e->getStatus());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $this->assertCount(5, $spans);

        $t4Spans = [$spans[0], $spans[1], $spans[2]];
        $t3Span = $spans[3];
        $exportedAppSpan = $spans[4];

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());

        foreach ($t4Spans as $t4Span) {
            $this->assertSame($t3Span->getSpanId(), $t4Span->getParentSpanId());
            $this->assertSame(SpanKind::KIND_CLIENT, $t4Span->getKind());
            $this->assertSame(StatusCode::STATUS_ERROR, $t4Span->getStatus()->getCode());
            $this->assertSame('UNAVAILABLE', $t4Span->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
            $this->assertSame('UNAVAILABLE', $t4Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
            $this->assertSame(
                'Persistent backend outage',
                $t4Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE)
            );
        }

        // Verify T3 span matches failure requirements (F2.7)
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $t3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame('Persistent backend outage', $t3Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertSame(ApiException::class, $t3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    /**
     * @param UnaryCall[] $unaryCalls
     * @param array<string, mixed> $telemetryOptions
     */
    private function createGrpcTransport(array $unaryCalls, array $telemetryOptions = []): GrpcTransport
    {
        return new class(
            self::SERVER_ADDRESS . ':' . self::SERVER_PORT,
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
