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

use Exception;
use Google\ApiCore\Telemetry\AuthHttpHandler;
use Google\ApiCore\Telemetry\SpanAttributes;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\ScopeInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

class AuthHttpHandlerTest extends TestCase
{
    public function testDisabledTracingDoesNotCreateSpan()
    {
        $expectedResponse = new Response(200, [], '{"access_token": "xyz"}');
        $called = false;
        $innerHandler = function (RequestInterface $request, array $options) use ($expectedResponse, &$called) {
            $called = true;
            return $expectedResponse;
        };

        $handler = new AuthHttpHandler($innerHandler, null);
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');
        $response = $handler($request, ['timeout' => 5]);

        $this->assertTrue($called);
        $this->assertSame($expectedResponse, $response);
    }

    public function testSyncSuccess()
    {
        $expectedResponse = new Response(200, [], '{"access_token": "xyz"}');
        $tracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);

        $tracerProvider->expects($this->once())
            ->method('getTracer')
            ->with('google-cloud-php', '1.0.0')
            ->willReturn($tracer);

        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->with('AuthenticationRefresh')
            ->willReturn($spanBuilder);

        $attributes = [];
        $spanBuilder->expects($this->once())
            ->method('setSpanKind')
            ->with(SpanKind::KIND_CLIENT)
            ->willReturnSelf();
        $spanBuilder->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$attributes, $spanBuilder) {
                $attributes[$key] = $value;
                return $spanBuilder;
            });
        $spanBuilder->expects($this->once())
            ->method('startSpan')
            ->willReturn($span);

        $span->expects($this->once())
            ->method('activate')
            ->willReturn($scope);

        $spanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$spanAttributes, $span) {
                $spanAttributes[$key] = $value;
                return $span;
            });
        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);
        $scope->expects($this->once())
            ->method('detach');
        $span->expects($this->once())
            ->method('end');

        $innerHandler = function (RequestInterface $request, array $options) use ($expectedResponse) {
            return $expectedResponse;
        };

        $handler = new AuthHttpHandler($innerHandler, $tracerProvider, '1.0.0');
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');
        $response = $handler($request);

        $this->assertSame($expectedResponse, $response);
        $this->assertSame('googleapis/google-cloud-php', $attributes[SpanAttributes::GCP_CLIENT_REPO]);
        $this->assertSame('POST', $attributes[SpanAttributes::HTTP_REQUEST_METHOD]);
        $this->assertSame('https://oauth2.googleapis.com/token', $attributes[SpanAttributes::URL_FULL]);
        $this->assertSame('oauth2.googleapis.com', $attributes[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame('oauth2.googleapis.com', $attributes[SpanAttributes::URL_DOMAIN]);
        $this->assertSame(443, $attributes[SpanAttributes::SERVER_PORT]);
        $this->assertSame(200, $spanAttributes[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
    }

    public function testSyncFailure()
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

        $spanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$spanAttributes, $span) {
                $spanAttributes[$key] = $value;
                return $span;
            });
        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Connection refused');
        $scope->expects($this->once())
            ->method('detach');
        $span->expects($this->once())
            ->method('end');

        $innerHandler = function () {
            throw new RuntimeException('Connection refused');
        };

        $handler = new AuthHttpHandler($innerHandler, $tracerProvider);
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Connection refused');

        try {
            $handler($request);
        } finally {
            $this->assertSame(RuntimeException::class, $spanAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame(RuntimeException::class, $spanAttributes[SpanAttributes::EXCEPTION_TYPE]);
            $this->assertSame('Connection refused', $spanAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }

    public function testSyncFailureWithResponse()
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

        $spanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$spanAttributes, $span) {
                $spanAttributes[$key] = $value;
                return $span;
            });
        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Unauthorized');
        $scope->expects($this->once())
            ->method('detach');
        $span->expects($this->once())
            ->method('end');

        $errorResponse = new Response(401, [], '{"error": "invalid_grant"}');
        $exception = new class ('Unauthorized', $errorResponse) extends Exception {
            private ResponseInterface $response;

            public function __construct(string $message, ResponseInterface $response)
            {
                parent::__construct($message);
                $this->response = $response;
            }

            public function getResponse(): ResponseInterface
            {
                return $this->response;
            }
        };

        $innerHandler = function () use ($exception) {
            throw $exception;
        };

        $handler = new AuthHttpHandler($innerHandler, $tracerProvider);
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unauthorized');

        try {
            $handler($request);
        } finally {
            $this->assertSame(401, $spanAttributes[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
            $this->assertSame('401', $spanAttributes[SpanAttributes::ERROR_TYPE]);
        }
    }

    public function testAsyncSuccess()
    {
        $expectedResponse = new Response(200, [], '{"access_token": "async_token"}');
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

        $spanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$spanAttributes, $span) {
                $spanAttributes[$key] = $value;
                return $span;
            });
        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_OK);
        $scope->expects($this->once())
            ->method('detach');
        $span->expects($this->once())
            ->method('end');

        $innerHandler = function () use ($expectedResponse) {
            return new FulfilledPromise($expectedResponse);
        };

        $handler = new AuthHttpHandler($innerHandler, $tracerProvider);
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');
        $promise = $handler($request);

        $actualResponse = $promise->wait();
        $this->assertSame($expectedResponse, $actualResponse);
        $this->assertSame(200, $spanAttributes[SpanAttributes::HTTP_RESPONSE_STATUS_CODE]);
    }

    public function testAsyncFailure()
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

        $spanAttributes = [];
        $span->method('setAttribute')
            ->willReturnCallback(function ($key, $value) use (&$spanAttributes, $span) {
                $spanAttributes[$key] = $value;
                return $span;
            });
        $span->expects($this->once())
            ->method('setStatus')
            ->with(StatusCode::STATUS_ERROR, 'Async error');
        $scope->expects($this->once())
            ->method('detach');
        $span->expects($this->once())
            ->method('end');

        $innerHandler = function () {
            return new RejectedPromise(new RuntimeException('Async error'));
        };

        $handler = new AuthHttpHandler($innerHandler, $tracerProvider);
        $request = new Request('POST', 'https://oauth2.googleapis.com/token');
        $promise = $handler($request);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Async error');

        try {
            $promise->wait();
        } finally {
            $this->assertSame(RuntimeException::class, $spanAttributes[SpanAttributes::ERROR_TYPE]);
            $this->assertSame('Async error', $spanAttributes[SpanAttributes::STATUS_MESSAGE]);
        }
    }
}
