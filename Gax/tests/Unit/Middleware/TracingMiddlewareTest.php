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

namespace Google\ApiCore\Tests\Unit\Middleware;

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
use Google\ApiCore\ValidationException;
use Google\Rpc\Code;
use Google\Rpc\ErrorInfo;
use Google\Rpc\Status;
use Grpc\ChannelCredentials;
use Grpc\UnaryCall;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\RejectedPromise;
use InvalidArgumentException;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\ScopeInterface;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use RuntimeException;
use stdClass;

class TracingMiddlewareTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;
    public function testTracingDisabledReturnsHandlerResult(): void
    {
        $call = new Call('test/method');
        $nextHandlerCalled = false;
        $nextHandler = function ($call, $options) use (&$nextHandlerCalled) {
            $nextHandlerCalled = true;
            return new FulfilledPromise('success');
        };

        $middleware = new TracingMiddleware($nextHandler);
        $promise = $middleware($call, []);
        $result = $promise->wait();

        $this->assertTrue($nextHandlerCalled);
        $this->assertSame('success', $result);
    }

    public function testUnaryCallSuccessEmitsT3Span(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

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
            ->with(SpanKind::KIND_INTERNAL)
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

        $span->expects($this->once())
            ->method('activate')
            ->willReturn($scope);

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);

        $span->expects($this->once())
            ->method('end');

        $scope->expects($this->once())
            ->method('detach');

        $call = new Call($method);

        $nextHandler = function ($c, $opts) {
            return new FulfilledPromise('response-payload');
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            [
                'openTelemetryTracerProvider' => $tracerProvider,
                'clientVersion' => '1.0.0',
            ]
        );

        $promise = $middleware($call, []);
        $result = $promise->wait();

        $this->assertSame('response-payload', $result);
        $this->assertSame('grpc', $attributes[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attributes[SpanAttributes::RPC_METHOD]);
        $this->assertSame('secretmanager.googleapis.com', $attributes[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attributes[SpanAttributes::SERVER_PORT]);
    }

    public function testUnaryCallFailureRecordsExceptionAndErrorStatus(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $recordedAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedAttributes, $span) {
                $recordedAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Secret not found');

        $span->expects($this->once())
            ->method('end');

        $scope->expects($this->once())
            ->method('detach');

        $call = new Call($method);

        $apiException = ApiException::createFromRestApiResponse('Secret not found', 5);
        $nextHandler = function ($c, $opts) use ($apiException) {
            return new RejectedPromise($apiException);
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $promise = $middleware($call, []);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Secret not found');

        try {
            $promise->wait();
        } finally {
            $this->assertSame('NOT_FOUND', $recordedAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame(ApiException::class, $recordedAttributes[SpanAttributes::EXCEPTION_TYPE]);
            $this->assertSame('Secret not found', $recordedAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }

    public function testUnaryCallFailureUsesErrorInfoReasonWhenPresent(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $recordedAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedAttributes, $span) {
                $recordedAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'API key not valid');

        $span->expects($this->once())
            ->method('end');

        $call = new Call('google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion');

        $apiException = ApiException::createFromRestApiResponse(
            'API key not valid',
            3,
            [
                [
                    '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
                    'reason' => 'API_KEY_INVALID',
                    'domain' => 'googleapis.com',
                    'metadata' => ['service' => 'secretmanager.googleapis.com'],
                ],
            ]
        );
        $nextHandler = function () use ($apiException) {
            return new RejectedPromise($apiException);
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'http',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $promise = $middleware($call, []);

        $this->expectException(ApiException::class);

        try {
            $promise->wait();
        } finally {
            $this->assertSame('API_KEY_INVALID', $recordedAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame(ApiException::class, $recordedAttributes[SpanAttributes::EXCEPTION_TYPE]);
            $this->assertSame('API key not valid', $recordedAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }

    public function testSynchronousExceptionInHandlerRecordsErrorAndRethrows(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $recordedAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedAttributes, $span) {
                $recordedAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Validation failed');

        $span->expects($this->once())
            ->method('end');

        $scope->expects($this->once())
            ->method('detach');

        $call = new Call($method);

        $nextHandler = function ($c, $opts) {
            throw new ValidationException('Validation failed');
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        try {
            $middleware($call, []);
        } finally {
            $this->assertSame(ValidationException::class, $recordedAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame(ValidationException::class, $recordedAttributes[SpanAttributes::EXCEPTION_TYPE]);
            $this->assertSame('Validation failed', $recordedAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }

    public function testStreamingCallSkipsTracing(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracerProvider->expects($this->never())->method('getTracer');

        $method = 'google.cloud.pubsub.v1.Subscriber/StreamingPull';
        $call = new Call($method, null, null, [], Call::BIDI_STREAMING_CALL);

        $mockStream = new stdClass();
        $nextHandler = function ($c, $opts) use ($mockStream) {
            return $mockStream;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'pubsub.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $result = $middleware($call, []);
        $this->assertSame($mockStream, $result);
    }

    public function testPendingPromiseWaitActivatesAndDetachesScopeDuringWait(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $initialScope = $this->createMock(ScopeInterface::class);
        $waitScope = $this->createMock(ScopeInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);

        // First activate() in __invoke(), second activate() in wait() callback
        $span->expects($this->exactly(2))
            ->method('activate')
            ->willReturnOnConsecutiveCalls($initialScope, $waitScope);

        // Initial scope must detach synchronously before wait()
        $initialScopeDetached = false;
        $initialScope->expects($this->once())
            ->method('detach')
            ->willReturnCallback(function () use (&$initialScopeDetached) {
                $initialScopeDetached = true;
                return 0;
            });

        // Wait scope must detach during wait()
        $waitScopeDetached = false;
        $waitScope->expects($this->once())
            ->method('detach')
            ->willReturnCallback(function () use (&$waitScopeDetached) {
                $waitScopeDetached = true;
                return 0;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);
        $span->expects($this->once())
            ->method('end');

        $call = new Call($method);

        // Create a pending promise whose waitfn verifies scopes
        $innerWaitExecuted = false;
        $innerPromise = new Promise(
            function () use (
                &$innerWaitExecuted,
                &$initialScopeDetached,
                &$waitScopeDetached,
                &$innerPromise
            ) {
                $innerWaitExecuted = true;
                $this->assertTrue($initialScopeDetached, 'Initial scope must be detached before wait executes');
                $this->assertFalse($waitScopeDetached, 'Wait scope must not be detached while wait is executing');
                $innerPromise->resolve('success-result');
            }
        );

        $nextHandler = function ($c, $opts) use ($innerPromise) {
            return $innerPromise;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $wrappedPromise = $middleware($call, []);

        // Before wait(), initial scope must already be detached
        $this->assertTrue($initialScopeDetached, 'Initial scope must be detached immediately after __invoke');
        $this->assertFalse($innerWaitExecuted, 'Wait should not have executed yet');
        $this->assertFalse($waitScopeDetached, 'Wait scope should not have detached yet');

        $result = $wrappedPromise->wait();

        $this->assertSame('success-result', $result);
        $this->assertTrue($innerWaitExecuted);
        $this->assertTrue($waitScopeDetached, 'Wait scope must be detached after wait completes');
    }

    public function testPendingPromiseWaitRejectionDetachesScopeAndRecordsException(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $initialScope = $this->createMock(ScopeInterface::class);
        $waitScope = $this->createMock(ScopeInterface::class);

        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);

        $span->expects($this->exactly(2))
            ->method('activate')
            ->willReturnOnConsecutiveCalls($initialScope, $waitScope);

        $initialScopeDetached = false;
        $initialScope->expects($this->once())
            ->method('detach')
            ->willReturnCallback(function () use (&$initialScopeDetached) {
                $initialScopeDetached = true;
                return 0;
            });

        $waitScopeDetached = false;
        $waitScope->expects($this->once())
            ->method('detach')
            ->willReturnCallback(function () use (&$waitScopeDetached) {
                $waitScopeDetached = true;
                return 0;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Call failed in wait');
        $span->expects($this->once())
            ->method('end');

        $call = new Call($method);

        $apiException = new ApiException('Call failed in wait', 14, 'UNAVAILABLE');
        $innerPromise = new Promise(function () use (&$innerPromise, $apiException) {
            $innerPromise->reject($apiException);
        });

        $nextHandler = function ($c, $opts) use ($innerPromise) {
            return $innerPromise;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $wrappedPromise = $middleware($call, []);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Call failed in wait');

        try {
            $wrappedPromise->wait();
        } finally {
            $this->assertTrue($initialScopeDetached);
            $this->assertTrue($waitScopeDetached);
        }
    }

    public function testPendingPromiseWaitFalseDoesNotThrowOnRejection(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Call failed in wait');
        $span->expects($this->once())
            ->method('end');

        $call = new Call('some/method');
        $apiException = new ApiException('Call failed in wait', 14, 'UNAVAILABLE');
        $innerPromise = new Promise(function () use (&$innerPromise, $apiException) {
            $innerPromise->reject($apiException);
        });

        $middleware = new TracingMiddleware(
            fn () => $innerPromise,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $wrappedPromise = $middleware($call, []);
        $wrappedPromise->wait(false);
        $this->assertSame('rejected', $wrappedPromise->getState());
    }

    public function testPendingPromiseCancellationEndsSpanAndCancelsInnerPromise(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $recordedAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $val) use (&$recordedAttributes, $span) {
                $recordedAttributes[$key] = $val;
                return $span;
            });

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Call cancelled');
        $span->expects($this->once())
            ->method('end');

        $call = new Call('some/method');

        $cancelled = false;
        $innerPromise = new Promise(
            function () {
            },
            function () use (&$cancelled) {
                $cancelled = true;
            }
        );

        $middleware = new TracingMiddleware(
            function () use ($innerPromise) {
                return $innerPromise;
            },
            'test.googleapis.com',
            443,
            'grpc',
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $wrappedPromise = $middleware($call, []);
        $wrappedPromise->cancel();

        $this->assertTrue($cancelled);
        $this->assertSame('CANCELLED', $recordedAttributes[SpanAttributes::ERROR_TYPE]);
    }

    /**
     * @dataProvider transportNameProvider
     */
    public function testTracingDisabledDoesNotEmitSpanToExporter(string $transportName): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );

        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            $transportName,
            ['openTelemetryTracerProvider' => null]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call(
                'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion',
                Status::class,
                new MockRequest()
            );
            $result = $middleware($call, [])->wait();
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

    /**
     * @dataProvider transportNameProvider
     */
    public function testUnaryCallEmitsSpanAsChildOfActiveSpan(string $transportName): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $response = new Status(['code' => Code::OK]);
        $nextHandler = fn (Call $call, array $options) => Create::promiseFor($response);

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            $transportName,
            [
                'openTelemetryTracerProvider' => $tracerProvider,
                'clientVersion' => '1.2.3',
            ]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());
            $result = $middleware($call, [])->wait();
            $this->assertSame($response, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(2, $spans);

        $middlewareSpan = $spans[0];
        $exportedAppSpan = $spans[1];

        $this->assertSame($exportedAppSpan->getSpanId(), $middlewareSpan->getParentSpanId());
        $this->assertSame($exportedAppSpan->getTraceId(), $middlewareSpan->getTraceId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $middlewareSpan->getKind());
        $this->assertSame($method, $middlewareSpan->getName());
        $this->assertSame(StatusCode::STATUS_OK, $middlewareSpan->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $middlewareSpan->getInstrumentationScope()->getName());
        $this->assertSame('1.2.3', $middlewareSpan->getInstrumentationScope()->getVersion());

        $attrs = $middlewareSpan->getAttributes()->toArray();
        $this->assertSame($transportName, $attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($method, $attrs[SpanAttributes::RPC_METHOD]);
        $this->assertSame('secretmanager.googleapis.com', $attrs[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(443, $attrs[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $attrs);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $attrs);
    }

    /**
     * @dataProvider transportNameProvider
     */
    public function testUnaryCallServerFailureAttributesWithInMemoryExporter(string $transportName): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        if ($transportName === 'http') {
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
                        'metadata' => ['service' => 'secretmanager.googleapis.com'],
                    ],
                ]
            );
        } else {
            $status1 = new stdClass();
            $status1->code = Code::UNAVAILABLE;
            $status1->details = 'Service unavailable';
            $apiException1 = ApiException::createFromStdClass($status1);

            $errorInfo = new ErrorInfo([
                'reason' => 'SERVICE_DISABLED',
                'domain' => 'googleapis.com',
            ]);
            $status2 = new stdClass();
            $status2->code = Code::PERMISSION_DENIED;
            $status2->details = 'API disabled in project';
            $status2->metadata = [
                'google.rpc.errorinfo-bin' => [$errorInfo->serializeToString()],
            ];
            $apiException2 = ApiException::createFromStdClass($status2);
        }

        $exceptions = [$apiException1, $apiException2];
        $nextHandler = function () use (&$exceptions) {
            return Create::rejectionFor(array_shift($exceptions));
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            $transportName,
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());

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
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(3, $spans);

        $span1 = $spans[0];
        $span2 = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $span1->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $span1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $span1->getStatus()->getCode());
        $attrs1 = $span1->getAttributes()->toArray();
        $this->assertSame($transportName, $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame('UNAVAILABLE', $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('Service unavailable', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);

        $this->assertSame($exportedAppSpan->getSpanId(), $span2->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $span2->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $span2->getStatus()->getCode());
        $attrs2 = $span2->getAttributes()->toArray();
        $this->assertSame($transportName, $attrs2[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame('SERVICE_DISABLED', $attrs2[SpanAttributes::ERROR_TYPE]);
        $this->assertSame('API disabled in project', $attrs2[SpanAttributes::STATUS_MESSAGE]);
        $this->assertSame(ApiException::class, $attrs2[SpanAttributes::EXCEPTION_TYPE]);
    }

    /**
     * @dataProvider transportNameProvider
     */
    public function testUnaryCallClientFailureAndCancellationWithInMemoryExporter(string $transportName): void
    {
        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

        $callIndex = 0;
        $nextHandler = function () use (&$callIndex) {
            $callIndex++;
            if ($callIndex === 1) {
                throw new InvalidArgumentException('Client request validation failed');
            }
            return new Promise(function () {
            }, function () {
            });
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            'secretmanager.googleapis.com',
            443,
            $transportName,
            ['openTelemetryTracerProvider' => $tracerProvider]
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());

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
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(3, $spans);

        $exceptionSpan = $spans[0];
        $cancelSpan = $spans[1];
        $exportedAppSpan = $spans[2];

        $this->assertSame($exportedAppSpan->getSpanId(), $exceptionSpan->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $exceptionSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $exceptionSpan->getStatus()->getCode());
        $attrs1 = $exceptionSpan->getAttributes()->toArray();
        $this->assertSame($transportName, $attrs1[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame(InvalidArgumentException::class, $attrs1[SpanAttributes::ERROR_TYPE]);
        $this->assertSame(InvalidArgumentException::class, $attrs1[SpanAttributes::EXCEPTION_TYPE]);
        $this->assertSame('Client request validation failed', $attrs1[SpanAttributes::STATUS_MESSAGE]);
        $this->assertArrayNotHasKey(SpanAttributes::RPC_RESPONSE_STATUS_CODE, $attrs1);

        $this->assertSame($exportedAppSpan->getSpanId(), $cancelSpan->getParentSpanId());
        $this->assertSame(StatusCode::STATUS_ERROR, $cancelSpan->getStatus()->getCode());
        $attrs2 = $cancelSpan->getAttributes()->toArray();
        $this->assertSame('CANCELLED', $attrs2[SpanAttributes::ERROR_TYPE]);
    }

    /**
     * @return array<array{string}>
     */
    public function transportNameProvider(): array
    {
        return [
            ['http'],
            ['grpc'],
        ];
    }

    public function testRetrySucceedsLinksAttemptSpansToParentMiddlewareSpan(): void
    {
        self::requiresGrpcExtension();

        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

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
            'openTelemetryTracerProvider' => $tracerProvider,
            'clientVersion' => '1.2.3',
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
            'secretmanager.googleapis.com',
            443,
            'grpc',
            $telemetryOptions
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());
            $result = $callStack($call, [])->wait();
            $this->assertSame($okResponse, $result);
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(4, $spans);

        $attemptSpan1 = $spans[0];
        $attemptSpan2 = $spans[1];
        $middlewareSpan = $spans[2];
        $exportedAppSpan = $spans[3];

        $this->assertSame($exportedAppSpan->getSpanId(), $middlewareSpan->getParentSpanId());
        $this->assertSame($middlewareSpan->getSpanId(), $attemptSpan1->getParentSpanId());
        $this->assertSame($middlewareSpan->getSpanId(), $attemptSpan2->getParentSpanId());

        $this->assertSame(SpanKind::KIND_CLIENT, $attemptSpan1->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $attemptSpan1->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $attemptSpan1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertSame('UNAVAILABLE', $attemptSpan1->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame(
            'Transient error on attempt 1',
            $attemptSpan1->getAttributes()->get(SpanAttributes::STATUS_MESSAGE)
        );

        $this->assertSame(SpanKind::KIND_CLIENT, $attemptSpan2->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $attemptSpan2->getStatus()->getCode());
        $this->assertSame('OK', $attemptSpan2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
        $this->assertNull($attemptSpan2->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertNull($attemptSpan2->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));

        $this->assertSame(SpanKind::KIND_INTERNAL, $middlewareSpan->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $middlewareSpan->getStatus()->getCode());
        $this->assertNull($middlewareSpan->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertNull($middlewareSpan->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertNull($middlewareSpan->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    public function testRetriesExhaustedLinksAllAttemptSpansAndMarksParentSpanAsError(): void
    {
        self::requiresGrpcExtension();

        $exporter = new InMemoryExporter();
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($exporter),
            null,
            ResourceInfoFactory::emptyResource()
        );
        $method = 'google.cloud.secretmanager.v1.SecretManagerService/AccessSecretVersion';

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
            'openTelemetryTracerProvider' => $tracerProvider,
            'clientVersion' => '1.2.3',
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
            'secretmanager.googleapis.com',
            443,
            'grpc',
            $telemetryOptions
        );

        $appSpan = $tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $call = new Call($method, Status::class, new MockRequest());
            try {
                $callStack($call, [])->wait();
                $this->fail('Expected ApiException after exhausting retries');
            } catch (ApiException $e) {
                $this->assertSame('UNAVAILABLE', $e->getStatus());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
            $tracerProvider->shutdown();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $exporter->getSpans();
        $this->assertCount(5, $spans);

        $attemptSpans = [$spans[0], $spans[1], $spans[2]];
        $middlewareSpan = $spans[3];
        $exportedAppSpan = $spans[4];

        $this->assertSame($exportedAppSpan->getSpanId(), $middlewareSpan->getParentSpanId());

        foreach ($attemptSpans as $attemptSpan) {
            $this->assertSame($middlewareSpan->getSpanId(), $attemptSpan->getParentSpanId());
            $this->assertSame(SpanKind::KIND_CLIENT, $attemptSpan->getKind());
            $this->assertSame(StatusCode::STATUS_ERROR, $attemptSpan->getStatus()->getCode());
            $this->assertSame(
                'UNAVAILABLE',
                $attemptSpan->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE)
            );
            $this->assertSame('UNAVAILABLE', $attemptSpan->getAttributes()->get(SpanAttributes::ERROR_TYPE));
            $this->assertSame(
                'Persistent backend outage',
                $attemptSpan->getAttributes()->get(SpanAttributes::STATUS_MESSAGE)
            );
        }

        $this->assertSame(SpanKind::KIND_INTERNAL, $middlewareSpan->getKind());
        $this->assertSame(StatusCode::STATUS_ERROR, $middlewareSpan->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $middlewareSpan->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame(
            'Persistent backend outage',
            $middlewareSpan->getAttributes()->get(SpanAttributes::STATUS_MESSAGE)
        );
        $this->assertSame(ApiException::class, $middlewareSpan->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    /**
     * @param UnaryCall[] $unaryCalls
     * @param array<string, mixed> $telemetryOptions
     */
    private function createGrpcTransport(array $unaryCalls, array $telemetryOptions = []): GrpcTransport
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
