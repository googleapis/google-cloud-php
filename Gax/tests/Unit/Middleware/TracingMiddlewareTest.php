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
use Google\ApiCore\Call;
use Google\ApiCore\Middleware\TracingMiddleware;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\ValidationException;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\RejectedPromise;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\ScopeInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class TracingMiddlewareTest extends TestCase
{
    public function testTracingDisabledReturnsHandlerResult(): void
    {
        $call = $this->createMock(Call::class);
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

        $nextHandler = function ($c, $opts) {
            return new FulfilledPromise('response-payload');
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            $tracerProvider,
            'secretmanager.googleapis.com',
            443,
            'grpc',
            ['clientVersion' => '1.0.0']
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

        $apiException = new ApiException('Secret not found', 5, 'NOT_FOUND');
        $nextHandler = function ($c, $opts) use ($apiException) {
            return new RejectedPromise($apiException);
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            $tracerProvider,
            'secretmanager.googleapis.com',
            443,
            'grpc'
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

        $nextHandler = function ($c, $opts) {
            throw new ValidationException('Validation failed');
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            $tracerProvider,
            'secretmanager.googleapis.com',
            443,
            'grpc'
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

    public function testStreamingCallSuccess(): void
    {
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $method = 'google.cloud.pubsub.v1.Subscriber/StreamingPull';

        $tracerProvider->method('getTracer')->willReturn($tracer);
        $tracer->method('spanBuilder')->willReturn($spanBuilder);
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->method('startSpan')->willReturn($span);
        $span->method('activate')->willReturn($scope);

        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);

        $span->expects($this->once())
            ->method('end');

        $scope->expects($this->once())
            ->method('detach');

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

        $mockStream = new stdClass();
        $nextHandler = function ($c, $opts) use ($mockStream) {
            return $mockStream;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            $tracerProvider,
            'pubsub.googleapis.com',
            443,
            'grpc'
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

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
            $tracerProvider,
            'secretmanager.googleapis.com',
            443,
            'grpc'
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn($method);

        $apiException = new ApiException('Call failed in wait', 14, 'UNAVAILABLE');
        $innerPromise = new Promise(function () use (&$innerPromise, $apiException) {
            $innerPromise->reject($apiException);
        });

        $nextHandler = function ($c, $opts) use ($innerPromise) {
            return $innerPromise;
        };

        $middleware = new TracingMiddleware(
            $nextHandler,
            $tracerProvider,
            'secretmanager.googleapis.com',
            443,
            'grpc'
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

    public function testPendingPromiseCancellationCancelsInnerPromise(): void
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

        $call = $this->createMock(Call::class);
        $call->method('getMethod')->willReturn('some/method');

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
            $tracerProvider,
            'test.googleapis.com',
            443,
            'grpc'
        );

        $wrappedPromise = $middleware($call, []);
        $wrappedPromise->cancel();

        $this->assertTrue($cancelled);
    }
}
