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

namespace Google\ApiCore\Telemetry;

use GuzzleHttp\Promise\PromiseInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use UnexpectedValueException;

/**
 * A decorator for callable HTTP handlers that emits an AuthenticationRefresh
 * OpenTelemetry span during token refresh requests.
 *
 * @internal
 */
class AuthHttpHandler
{
    use TelemetryTrait;

    /**
     * @var callable
     */
    private $httpHandler;

    /**
     * @param callable $httpHandler The underlying PSR-7 HTTP handler.
     * @param TracerProviderInterface|null $tracerProvider The OpenTelemetry TracerProvider.
     * @param string $clientVersion Version string for the tracer.
     */
    public function __construct(
        callable $httpHandler,
        ?TracerProviderInterface $tracerProvider = null,
        string $clientVersion = ''
    ) {
        $this->httpHandler = $httpHandler;
        $this->initTelemetry([
            SpanAttributes::GCP_CLIENT_REPO => 'googleapis/google-cloud-php',
            SpanAttributes::GCP_CLIENT_VERSION => $clientVersion,
        ], $tracerProvider);
    }

    /**
     * Execute the request, wrapping it in an AuthenticationRefresh span if tracing is enabled.
     *
     * @param RequestInterface $request
     * @param array<mixed> $options
     * @return ResponseInterface|PromiseInterface
     * @throws Throwable
     */
    public function __invoke(RequestInterface $request, array $options = [])
    {
        if (!$this->openTelemetryTracerProvider) {
            $response = ($this->httpHandler)($request, $options);
            if ($response instanceof ResponseInterface || $response instanceof PromiseInterface) {
                return $response;
            }

            throw new UnexpectedValueException(
                'HTTP handler must return an instance of ResponseInterface or PromiseInterface'
            );
        }

        $tracer = $this->openTelemetryTracerProvider->getTracer('google-cloud-php', $this->clientVersion);
        $spanBuilder = $tracer->spanBuilder('AuthenticationRefresh')
            ->setSpanKind(SpanKind::KIND_CLIENT)
            ->setAttribute(SpanAttributes::GCP_CLIENT_REPO, 'googleapis/google-cloud-php')
            ->setAttribute(SpanAttributes::HTTP_REQUEST_METHOD, $request->getMethod())
            ->setAttribute(SpanAttributes::URL_FULL, (string) $request->getUri());

        $uri = $request->getUri();
        $host = $uri->getHost();
        if ($host) {
            $spanBuilder->setAttribute(SpanAttributes::SERVER_ADDRESS, $host);
            $spanBuilder->setAttribute(SpanAttributes::URL_DOMAIN, $host);
        }
        $scheme = $uri->getScheme();
        $defaultPort = $scheme === 'https' ? 443 : ($scheme === 'http' ? 80 : null);
        $port = $uri->getPort() ?: $defaultPort;
        if ($port) {
            $spanBuilder->setAttribute(SpanAttributes::SERVER_PORT, $port);
        }

        $span = $spanBuilder->startSpan();
        $scope = $span->activate();

        $recordSuccess = function (ResponseInterface $res) use ($span): ResponseInterface {
            $span->setStatus(StatusCode::STATUS_OK);
            $span->setAttribute(SpanAttributes::HTTP_RESPONSE_STATUS_CODE, $res->getStatusCode());
            $span->end();
            return $res;
        };

        $recordFailure = function (Throwable $e) use ($span) {
            $this->recordException($span, $e, true);
            throw $e;
        };

        try {
            $response = ($this->httpHandler)($request, $options);
            if ($response instanceof PromiseInterface) {
                return $response->then($recordSuccess, $recordFailure);
            }

            if ($response instanceof ResponseInterface) {
                return $recordSuccess($response);
            }

            throw new UnexpectedValueException(
                'HTTP handler must return an instance of ResponseInterface or PromiseInterface'
            );
        } catch (Throwable $e) {
            $this->recordException($span, $e, true);
            throw $e;
        } finally {
            $scope->detach();
        }
    }
}
