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

namespace Google\Cloud\Spanner\OpenTelemetry;

use Google\ApiCore\CredentialsWrapper;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use OpenTelemetry\Contrib\Otlp\MetricExporter as OtlpMetricExporter;
use OpenTelemetry\SDK\Common\Export\Http\PsrTransportFactory;
use OpenTelemetry\SDK\Metrics\AggregationTemporalitySelectorInterface;
use OpenTelemetry\SDK\Metrics\Data\Metric as OTelMetric;
use OpenTelemetry\SDK\Metrics\Data\Temporality;
use OpenTelemetry\SDK\Metrics\MetricMetadataInterface;
use OpenTelemetry\SDK\Metrics\PushMetricExporterInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * OtlpMetricsExporter encapsulates the standard OpenTelemetry OTLP MetricExporter
 * targeting Google Cloud Telemetry endpoint.
 *
 * @internal
 */
class OtlpMetricsExporter implements PushMetricExporterInterface, AggregationTemporalitySelectorInterface
{
    private const DEFAULT_ENDPOINT = 'https://telemetry.googleapis.com/v1/metrics';

    private PushMetricExporterInterface $otlpExporter;

    /**
     * @param CredentialsWrapper $credentials The credentials wrapper for metric export.
     * @param int $timeoutMillis The timeout defined for the metrics client during export.
     * @param array $options Optional configuration parameters.
     * @param PushMetricExporterInterface|null $otlpExporter Optional inner exporter for testing.
     */
    public function __construct(
        CredentialsWrapper $credentials,
        int $timeoutMillis = 100,
        array $options = [],
        ?PushMetricExporterInterface $otlpExporter = null
    ) {
        if ($otlpExporter !== null) {
            $this->otlpExporter = $otlpExporter;
            return;
        }

        $authCallback = $credentials->getAuthorizationHeaderCallback();
        $quotaProject = $credentials->getQuotaProject();
        $handlerStack = $options['handlerStack'] ?? HandlerStack::create();
        $handlerStack->push(function (callable $handler) use ($authCallback, $quotaProject) {
            return function (RequestInterface $request, array $options) use ($authCallback, $handler, $quotaProject) {
                $headers = $authCallback ? $authCallback() : [];
                foreach ($headers as $name => $values) {
                    $request = $request->withHeader($name, $values);
                }
                if ($quotaProject) {
                    $request = $request->withHeader('x-goog-user-project', $quotaProject);
                }
                return $handler($request, $options);
            };
        });

        $guzzleClient = new GuzzleClient([
            'handler' => $handlerStack,
            'auth' => 'google_auth',
            'timeout' => $timeoutMillis / 1000,
        ]);

        $transport = (new PsrTransportFactory($guzzleClient))->create(
            self::DEFAULT_ENDPOINT,
            'application/x-protobuf'
        );

        $this->otlpExporter = new OtlpMetricExporter($transport, Temporality::CUMULATIVE);
    }

    /**
     * Exports a batch of OTel metrics using the inner OTLP exporter.
     *
     * @param iterable<OTelMetric> $batch
     * @return bool
     */
    public function export(iterable $batch): bool
    {
        try {
            return $this->otlpExporter->export($batch);
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Implementation of forceFlush method for PushMetricExporterInterface.
     *
     * @return bool
     */
    public function forceFlush(): bool
    {
        try {
            return $this->otlpExporter->forceFlush();
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Implementation of shutdown method for PushMetricExporterInterface.
     *
     * @return bool
     */
    public function shutdown(): bool
    {
        try {
            return $this->otlpExporter->shutdown();
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Returns the aggregation temporality for the given metric.
     *
     * @param MetricMetadataInterface $metric
     * @return Temporality|string|null
     */
    public function temporality(MetricMetadataInterface $metric): Temporality|string|null
    {
        return Temporality::CUMULATIVE;
    }
}
