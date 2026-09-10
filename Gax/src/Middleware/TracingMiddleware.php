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

namespace Google\ApiCore\Middleware;

use Google\ApiCore\Call;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\Telemetry\TelemetryTrait;
use GuzzleHttp\Promise\PromiseInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Throwable;

/**
 * Middleware that wraps API calls in an OpenTelemetry T3 Client Request span.
 *
 * @internal
 */
class TracingMiddleware implements MiddlewareInterface
{
    use TelemetryTrait;

    /** @var MiddlewareInterface|callable */
    private $nextHandler;
    private string $serverAddress;
    private int $serverPort;
    private string $systemName;

    /**
     * @param MiddlewareInterface|callable $nextHandler
     * @param TracerProviderInterface|null $openTelemetryTracerProvider
     * @param string $serverAddress
     * @param int $serverPort
     * @param string $systemName
     * @param array $telemetryOptions
     */
    public function __construct(
        $nextHandler,
        ?TracerProviderInterface $openTelemetryTracerProvider = null,
        string $serverAddress = '',
        int $serverPort = 443,
        string $systemName = 'grpc',
        array $telemetryOptions = []
    ) {
        $this->nextHandler = $nextHandler;
        $this->serverAddress = $serverAddress;
        $this->serverPort = $serverPort;
        $this->systemName = $systemName;
        $this->initTelemetry($telemetryOptions, $openTelemetryTracerProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Call $call, array $options)
    {
        if (!$this->openTelemetryTracerProvider) {
            return ($this->nextHandler)($call, $options);
        }

        $span = $this->startSpan(
            $call->getMethod(),
            [
                SpanAttributes::RPC_SYSTEM_NAME => $this->systemName,
                SpanAttributes::RPC_METHOD => $call->getMethod(),
                SpanAttributes::SERVER_ADDRESS => $this->serverAddress,
                SpanAttributes::SERVER_PORT => $this->serverPort,
            ],
            SpanKind::KIND_INTERNAL
        );

        if (!$span) {
            return ($this->nextHandler)($call, $options);
        }

        $scope = $span->activate();

        $onFulfilled = function ($response) use ($span, $scope) {
            $span->setStatus(StatusCode::STATUS_OK);
            $scope->detach();
            $span->end();
            return $response;
        };

        $onRejected = function (Throwable $e) use ($span, $scope) {
            $this->recordException($span, $e);
            $scope->detach();
            $span->end();
            throw $e;
        };

        try {
            $result = ($this->nextHandler)($call, $options);
            if ($result instanceof PromiseInterface) {
                return $result->then($onFulfilled, $onRejected);
            }

            $span->setStatus(StatusCode::STATUS_OK);
            $scope->detach();
            $span->end();
            return $result;
        } catch (Throwable $e) {
            $this->recordException($span, $e);
            $scope->detach();
            $span->end();
            throw $e;
        }
    }
}
