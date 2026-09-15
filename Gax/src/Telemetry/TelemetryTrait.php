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

use Google\ApiCore\Call;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Common telemetry properties and span building helpers for transports and middleware.
 *
 * @internal
 */
trait TelemetryTrait
{
    /** @var TracerProviderInterface|null */
    private $openTelemetryTracerProvider;
    private string $clientRepo = '';
    private string $clientArtifact = '';
    private string $clientService = '';
    private string $clientVersion = '';

    /**
     * Sets telemetry options and initializes tracing properties.
     *
     * @param array $telemetryOptions
     * @param TracerProviderInterface|null $openTelemetryTracerProvider
     * @return $this
     */
    public function setTelemetryOptions(
        array $telemetryOptions,
        ?TracerProviderInterface $openTelemetryTracerProvider = null
    ): self {
        $this->initTelemetry($telemetryOptions, $openTelemetryTracerProvider);
        return $this;
    }

    /**
     * Initializes telemetry properties from an options array and optional tracer provider.
     *
     * @param array $telemetryOptions
     * @param TracerProviderInterface|null $openTelemetryTracerProvider
     */
    private function initTelemetry(
        array $telemetryOptions,
        ?TracerProviderInterface $openTelemetryTracerProvider = null
    ): void {
        $this->openTelemetryTracerProvider = $openTelemetryTracerProvider
            ?? $telemetryOptions['openTelemetryTracerProvider']
            ?? null;
        $this->clientRepo = $telemetryOptions[SpanAttributes::GCP_CLIENT_REPO] ?? '';
        $this->clientArtifact = $telemetryOptions[SpanAttributes::GCP_CLIENT_ARTIFACT] ?? '';
        $this->clientService = $telemetryOptions[SpanAttributes::GCP_CLIENT_SERVICE] ?? '';
        $this->clientVersion = $telemetryOptions[SpanAttributes::GCP_CLIENT_VERSION] ?? '';
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
            SpanAttributes::GCP_CLIENT_REPO => '',
            SpanAttributes::GCP_CLIENT_ARTIFACT => '',
            SpanAttributes::GCP_CLIENT_SERVICE => '',
            SpanAttributes::GCP_CLIENT_VERSION => '',
        ];
    }

    /**
     * Returns the telemetry options populated from this instance.
     *
     * @return array
     */
    private function getTelemetryOptions(): array
    {
        return [
            SpanAttributes::GCP_CLIENT_REPO => $this->clientRepo,
            SpanAttributes::GCP_CLIENT_ARTIFACT => $this->clientArtifact,
            SpanAttributes::GCP_CLIENT_SERVICE => $this->clientService,
            SpanAttributes::GCP_CLIENT_VERSION => $this->clientVersion,
        ];
    }

    /**
     * Builds and starts an internal span with standard client metadata attributes.
     *
     * @param string $spanName
     * @param array<string, mixed> $attributes
     * @return SpanInterface|null
     */
    private function startSpan(string $spanName, array $attributes = []): ?SpanInterface
    {
        if (!$this->openTelemetryTracerProvider) {
            return null;
        }

        $tracer = $this->openTelemetryTracerProvider->getTracer('google-cloud-php', $this->clientVersion);
        $spanBuilder = $tracer->spanBuilder($spanName)
            ->setSpanKind(SpanKind::KIND_INTERNAL);

        if ($this->clientRepo) {
            $spanBuilder->setAttribute(SpanAttributes::GCP_CLIENT_REPO, $this->clientRepo);
        }
        if ($this->clientArtifact) {
            $spanBuilder->setAttribute(SpanAttributes::GCP_CLIENT_ARTIFACT, $this->clientArtifact);
        }
        if ($this->clientService) {
            $spanBuilder->setAttribute(SpanAttributes::GCP_CLIENT_SERVICE, $this->clientService);
        }
        if ($this->clientVersion) {
            $spanBuilder->setAttribute(SpanAttributes::GCP_CLIENT_VERSION, $this->clientVersion);
        }

        foreach ($attributes as $key => $value) {
            $spanBuilder->setAttribute($key, $value);
        }

        return $spanBuilder->startSpan();
    }

    /**
     * Starts an internal transport span with standard client metadata attributes.
     *
     * @param string $spanName
     * @param Call $call
     * @return SpanInterface|null
     */
    private function startTransportSpan(string $spanName, Call $call): ?SpanInterface
    {
        return $this->startSpan($spanName, [
            SpanAttributes::RPC_METHOD => $call->getMethod(),
            SpanAttributes::RPC_SYSTEM => 'http',
        ]);
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

        $statusCode = null;
        if (method_exists($e, 'getResponse') && $e->getResponse() instanceof ResponseInterface) {
            $statusCode = $e->getResponse()->getStatusCode();
            $span->setAttribute(SpanAttributes::HTTP_RESPONSE_STATUS_CODE, $statusCode);
        }

        $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
        $span->setAttribute(SpanAttributes::ERROR_TYPE, $statusCode ? (string) $statusCode : get_class($e));
        $span->setAttribute(SpanAttributes::EXCEPTION_TYPE, get_class($e));
        $span->setAttribute(SpanAttributes::STATUS_MESSAGE, $e->getMessage());

        if ($end) {
            $span->end();
        }
    }
}
