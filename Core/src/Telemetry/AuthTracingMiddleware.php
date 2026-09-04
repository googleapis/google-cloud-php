<?php

/**
 * Copyright 2026 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Telemetry;

use GuzzleHttp\Promise\PromiseInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Middleware for tracing authentication requests.
 */
class AuthTracingMiddleware
{
    /**
     * @var callable
     */
    private $httpHandler;

    private TracerProviderInterface $openTelemetryTracerProvider;

    /**
     * @param callable $httpHandler The HTTP handler to wrap.
     * @param TracerProviderInterface $openTelemetryTracerProvider The tracer provider.
     */
    public function __construct(callable $httpHandler, TracerProviderInterface $openTelemetryTracerProvider)
    {
        $this->httpHandler = $httpHandler;
        $this->openTelemetryTracerProvider = $openTelemetryTracerProvider;
    }

    /**
     * Can be used as a callable for google-auth-library-php
     *
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface|PromiseInterface
     */
    public function __invoke(RequestInterface $request, array $options = [])
    {
        $span = $this->openTelemetryTracerProvider->getTracer('google-cloud-php', '')
            ->spanBuilder('AuthRequest')
            ->setSpanKind(SpanKind::KIND_CLIENT)
            ->setAttribute('http.request.method', $request->getMethod())
            ->setAttribute('url.full', (string) $request->getUri())
            ->startSpan();

        $scope = $span->activate();

        try {
            $handler = $this->httpHandler;
            $response = $handler($request, $options);

            if ($response instanceof PromiseInterface) {
                return $response->then(
                    function (ResponseInterface $res) use ($span) {
                        $span->setStatus(StatusCode::STATUS_OK);
                        $span->end();
                        return $res;
                    },
                    function (\Throwable $e) use ($span) {
                        $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
                        $span->end();
                        throw $e;
                    }
                );
            }

            $span->setStatus(StatusCode::STATUS_OK);
            return $response;
        } catch (\Throwable $e) {
            $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
            throw $e;
        } finally {
            $scope->detach();
            if (!isset($response) || !($response instanceof PromiseInterface)) {
                $span->end();
            }
        }
    }
}
