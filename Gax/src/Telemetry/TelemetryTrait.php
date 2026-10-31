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

use Google\ApiCore\ApiException;
use Google\ApiCore\ServiceAddressTrait;
use Google\ApiCore\ValidationException;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Throwable;

/**
 * Common telemetry properties and span building helpers for transports and middleware.
 *
 * @internal
 */
trait TelemetryTrait
{
    use ServiceAddressTrait;

    private ?TracerProviderInterface $openTelemetryTracerProvider = null;
    private ?string $clientVersion = null;
    private ?string $serverAddress = null;
    private ?int $serverPort = null;

    /**
     * Sets telemetry options and initializes tracing properties.
     *
     * @param array $telemetryOptions
     * @param string|null $apiEndpoint
     * @return $this
     */
    private function setTelemetryOptions(array $telemetryOptions, ?string $apiEndpoint = null): self
    {
        $this->openTelemetryTracerProvider = $telemetryOptions['openTelemetryTracerProvider'] ?? null;
        $this->clientVersion = $telemetryOptions['clientVersion'] ?? null;
        if ($this->openTelemetryTracerProvider && $apiEndpoint) {
            try {
                [$addr, $port] = self::normalizeServiceAddress($apiEndpoint);
                $this->serverAddress = $addr;
                $this->serverPort = (int) $port;
            } catch (ValidationException $e) {
                // Ignore invalid apiEndpoint formats when setting span attributes
            }
        }
        return $this;
    }

    /**
     * Returns default telemetry config options for transport build methods.
     *
     * @return array
     */
    private static function getTelemetryDefaultConfig(): array
    {
        return [
            'openTelemetryTracerProvider' => null,
            'clientVersion' => null,
        ];
    }

    /**
     * Builds and starts a span with standard client metadata attributes.
     *
     * @param string $spanName
     * @param array<string, mixed> $attributes
     * @param SpanKind::KIND_* $spanKind
     * @return SpanInterface|null
     */
    private function startSpan(
        string $spanName,
        array $attributes = [],
        int $spanKind = SpanKind::KIND_INTERNAL
    ): ?SpanInterface {
        if (!$this->openTelemetryTracerProvider) {
            return null;
        }

        $tracer = $this->openTelemetryTracerProvider->getTracer('google-cloud-php', $this->clientVersion);
        $spanBuilder = $tracer->spanBuilder($spanName)
            ->setSpanKind($spanKind);

        foreach ($attributes as $key => $value) {
            if ($value !== null) {
                $spanBuilder->setAttribute($key, $value);
            }
        }

        return $spanBuilder->startSpan();
    }

    /**
     * Records error status and attributes on a span from a Throwable.
     *
     * @param SpanInterface|null $span
     * @param Throwable $e
     * @param bool $end
     */
    private function recordException(?SpanInterface $span, Throwable $e, bool $end = false): void
    {
        if ($span === null) {
            return;
        }

        if ($e instanceof ApiException) {
            $errorType = $e->getReason() ?: $e->getStatus() ?: get_class($e);
            $message = $e->getBasicMessage() ?? $e->getMessage();
        } else {
            $errorType = get_class($e);
            $message = $e->getMessage();
        }

        $span->recordException($e);
        $span->setStatus(StatusCode::STATUS_ERROR, $message);
        $span->setAttribute(SpanAttributes::ERROR_TYPE, $errorType);
        $span->setAttribute(SpanAttributes::EXCEPTION_TYPE, get_class($e));
        $span->setAttribute(SpanAttributes::STATUS_MESSAGE, $message);

        if ($end) {
            $span->end();
        }
    }
}
