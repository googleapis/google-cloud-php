<?php
/**
 * Copyright 2026 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Telemetry;

use Google\Cloud\Core\Telemetry\AuthTracingMiddleware;
use PHPUnit\Framework\TestCase;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\Context\ScopeInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @group core
 * @group telemetry
 */
class AuthTracingMiddlewareTest extends TestCase
{
    public function testInvoke()
    {
        $openTelemetryTracerProvider = $this->createMock(TracerProviderInterface::class);
        $tracer = $this->createMock(TracerInterface::class);
        $spanBuilder = $this->createMock(SpanBuilderInterface::class);
        $span = $this->createMock(SpanInterface::class);
        $scope = $this->createMock(ScopeInterface::class);
        
        $openTelemetryTracerProvider->expects($this->once())
            ->method('getTracer')
            ->willReturn($tracer);
            
        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->willReturn($spanBuilder);
            
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->expects($this->once())->method('startSpan')->willReturn($span);
        
        $span->expects($this->once())->method('activate')->willReturn($scope);
        $span->expects($this->once())->method('setStatus');
        $span->expects($this->once())->method('end');
        
        $scope->expects($this->once())->method('detach');
        
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        
        $httpHandler = function ($req, $opts) use ($response) {
            return $response;
        };
        
        $middleware = new AuthTracingMiddleware($httpHandler, $openTelemetryTracerProvider);
        
        $res = $middleware($request, []);
        $this->assertSame($response, $res);
    }

    public function testInvokeWithPromise()
    {
        $openTelemetryTracerProvider = $this->createMock(\OpenTelemetry\API\Trace\TracerProviderInterface::class);
        $tracer = $this->createMock(\OpenTelemetry\API\Trace\TracerInterface::class);
        $spanBuilder = $this->createMock(\OpenTelemetry\API\Trace\SpanBuilderInterface::class);
        $span = $this->createMock(\OpenTelemetry\API\Trace\SpanInterface::class);
        $scope = $this->createMock(\OpenTelemetry\Context\ScopeInterface::class);
        
        $openTelemetryTracerProvider->expects($this->once())
            ->method('getTracer')
            ->willReturn($tracer);
            
        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->willReturn($spanBuilder);
            
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->expects($this->once())->method('startSpan')->willReturn($span);
        
        $span->expects($this->once())->method('activate')->willReturn($scope);
        $span->expects($this->once())->method('setStatus');
        $span->expects($this->once())->method('end');
        
        $scope->expects($this->once())->method('detach');
        
        $request = $this->createMock(\Psr\Http\Message\RequestInterface::class);
        $response = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $promise = new \GuzzleHttp\Promise\Promise(function () use (&$promise, $response) {
            $promise->resolve($response);
        });
        
        $httpHandler = function ($req, $opts) use ($promise) {
            return $promise;
        };
        
        $middleware = new \Google\Cloud\Core\Telemetry\AuthTracingMiddleware(
            $httpHandler,
            $openTelemetryTracerProvider
        );
        
        $resPromise = $middleware($request, []);
        $this->assertSame($response, $resPromise->wait());
    }

    public function testInvokeWithPromiseRejection()
    {
        $openTelemetryTracerProvider = $this->createMock(\OpenTelemetry\API\Trace\TracerProviderInterface::class);
        $tracer = $this->createMock(\OpenTelemetry\API\Trace\TracerInterface::class);
        $spanBuilder = $this->createMock(\OpenTelemetry\API\Trace\SpanBuilderInterface::class);
        $span = $this->createMock(\OpenTelemetry\API\Trace\SpanInterface::class);
        $scope = $this->createMock(\OpenTelemetry\Context\ScopeInterface::class);
        
        $openTelemetryTracerProvider->expects($this->once())
            ->method('getTracer')
            ->willReturn($tracer);
            
        $tracer->expects($this->once())
            ->method('spanBuilder')
            ->willReturn($spanBuilder);
            
        $spanBuilder->method('setSpanKind')->willReturnSelf();
        $spanBuilder->method('setAttribute')->willReturnSelf();
        $spanBuilder->expects($this->once())->method('startSpan')->willReturn($span);
        
        $span->expects($this->once())->method('activate')->willReturn($scope);
        $span->expects($this->once())->method('setStatus');
        $span->expects($this->once())->method('end');
        
        $scope->expects($this->once())->method('detach');
        
        $request = $this->createMock(\Psr\Http\Message\RequestInterface::class);
        $promise = new \GuzzleHttp\Promise\Promise(function () use (&$promise) {
            $promise->reject(new \Exception('Test error'));
        });
        
        $httpHandler = function ($req, $opts) use ($promise) {
            return $promise;
        };
        
        $middleware = new \Google\Cloud\Core\Telemetry\AuthTracingMiddleware(
            $httpHandler,
            $openTelemetryTracerProvider
        );
        
        $resPromise = $middleware($request, []);
        try {
            $resPromise->wait();
            $this->fail('Expected exception');
        } catch (\Exception $e) {
            $this->assertEquals('Test error', $e->getMessage());
        }
    }
}
