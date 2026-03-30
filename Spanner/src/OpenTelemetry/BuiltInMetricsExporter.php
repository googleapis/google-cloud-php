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

use Google\Api\Distribution;
use Google\Api\Distribution\BucketOptions;
use Google\Api\Distribution\BucketOptions\Explicit;
use Google\Api\Metric;
use Google\Api\MetricDescriptor\MetricKind;
use Google\Api\MetricDescriptor\ValueType;
use Google\Api\MonitoredResource;
use Google\Cloud\Monitoring\V3\Client\MetricServiceClient;
use Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\Point;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Cloud\Monitoring\V3\TypedValue;
use Google\Protobuf\Timestamp;
use OpenTelemetry\SDK\Metrics\AggregationTemporalitySelectorInterface;
use OpenTelemetry\SDK\Metrics\Data\DataInterface;
use OpenTelemetry\SDK\Metrics\Data\Histogram;
use OpenTelemetry\SDK\Metrics\Data\HistogramDataPoint;
use OpenTelemetry\SDK\Metrics\Data\Metric as OTelMetric;
use OpenTelemetry\SDK\Metrics\Data\NumberDataPoint;
use OpenTelemetry\SDK\Metrics\Data\Sum;
use OpenTelemetry\SDK\Metrics\Data\Temporality;
use OpenTelemetry\SDK\Metrics\MetricMetadataInterface;
use OpenTelemetry\SDK\Metrics\PushMetricExporterInterface;

/**
 * BuiltInMetricsExporter exports Spanner client metrics to Google Cloud Monitoring
 * using the internal service endpoint.
 */
class BuiltInMetricsExporter implements PushMetricExporterInterface, AggregationTemporalitySelectorInterface
{
    private const SPANNER_RESOURCE_TYPE = 'spanner_instance_client';
    private const NATIVE_METRICS_PREFIX = 'spanner.googleapis.com/internal/client/';
    private const SEND_BATCH_SIZE = 200;

    /**
     * Labels that belong to the MonitoredResource rather than the Metric.
     */
    private static array $MONITORED_RES_LABELS = [
        'project_id' => true,
        'instance_id' => true,
        'instance_config' => true,
        'location' => true,
        'client_hash' => true,
    ];

    private MetricServiceClient $client;
    private string $projectId;
    private string $clientHash;

    /**
     * @param MetricServiceClient $client The monitoring client.
     * @param string $projectId The GCP project ID metrics will be written to.
     * @param string $clientUid The unique client identifier.
     */
    public function __construct(MetricServiceClient $client, string $projectId, string $clientUid)
    {
        $this->client = $client;
        $this->projectId = $projectId;
        $this->clientHash = $this->generateClientHash($clientUid);
    }

    /**
     * Exports a batch of OTel metrics to Cloud Monitoring.
     *
     * @param iterable<OTelMetric> $batch
     * @return bool
     */
    public function export(iterable $batch): bool
    {
        $timeSeriesList = [];
        foreach ($batch as $otelMetric) {
            $timeSeriesList = array_merge($timeSeriesList, $this->mapMetric($otelMetric));
        }

        if (empty($timeSeriesList)) {
            return true;
        }

        $projectName = MetricServiceClient::projectName($this->projectId);
        $chunks = array_chunk($timeSeriesList, self::SEND_BATCH_SIZE);

        foreach ($chunks as $chunk) {
            $request = new CreateTimeSeriesRequest();
            $request->setName($projectName);
            $request->setTimeSeries($chunk);

            try {
                $this->client->createServiceTimeSeries($request);
            } catch (\Exception $e) {
                // Fail silently during shutdown to avoid user-visible errors.
            }
        }

        return true;
    }

    /**
     * Implementation of the forcePush method for PushMetricExporter interface.
     *
     * @return true
     */
    public function forceFlush(): bool
    {
        return true;
    }

    /**
     * Implementation of the shutdown method for PushMetricExporterInterface.
     *
     * @return true
     */
    public function shutdown(): bool
    {
        $this->client->close();
        return true;
    }

    /**
     * Returns the aggregation temporality for the given metric.
     *
     * @param MetricMetadataInterface $metadata
     * @return string
     */
    public function temporality(MetricMetadataInterface $metadata): string
    {
        return Temporality::CUMULATIVE;
    }

    /**
     * Maps an OTel Metric object to one or more GCM TimeSeries objects.
     *
     * @param OTelMetric $otelMetric
     */
    private function mapMetric(OTelMetric $otelMetric): array
    {
        $timeSeriesList = [];
        $metricType = $this->formatMetricName($otelMetric->name);

        $data = $otelMetric->data;
        foreach ($data->dataPoints as $point) {
            $timeSeriesList[] = $this->createTimeSeries($metricType, $point, $otelMetric->unit, $data);
        }

        return $timeSeriesList;
    }

    /**
     * Creates a single GCM TimeSeries from an OTel DataPoint.
     *
     * @param string $metricType
     * @param NumberDataPoint|HistogramDataPoint $otelPoint
     * @param string|null $unit
     * @param DataInterface $otelData
     * @return TimeSeries
     */
    private function createTimeSeries(
        string $metricType,
        NumberDataPoint|HistogramDataPoint $otelPoint,
        ?string $unit,
        DataInterface $otelData
    ): TimeSeries {
        $ts = new TimeSeries();
        $unit = $unit ?? '1';

        $metricLabels = [];
        $resourceLabels = [
            'client_hash' => $this->clientHash,
        ];

        // Distribute attributes between Resource and Metric labels
        foreach ($otelPoint->attributes as $key => $value) {
            $labelKey = str_replace('.', '_', $key);
            if (isset(self::$MONITORED_RES_LABELS[$labelKey])) {
                $resourceLabels[$labelKey] = (string) $value;
            } else {
                $metricLabels[$labelKey] = (string) $value;
            }
        }

        $metric = new Metric();
        $metric->setType($metricType);
        $metric->setLabels($metricLabels);
        $ts->setMetric($metric);

        $resource = new MonitoredResource();
        $resource->setType(self::SPANNER_RESOURCE_TYPE);
        $resource->setLabels($resourceLabels);
        $ts->setResource($resource);

        $ts->setUnit($unit);

        $point = new Point();
        $interval = new TimeInterval();

        // Convert nanoseconds to Protobuf Timestamp
        $interval->setStartTime($this->toTimestamp($otelPoint->startTimestamp));
        $interval->setEndTime($this->toTimestamp($otelPoint->timestamp));
        $point->setInterval($interval);

        $value = new TypedValue();
        if ($otelData instanceof Sum) {
            $ts->setMetricKind($otelData->monotonic ? MetricKind::CUMULATIVE : MetricKind::GAUGE);
            if (is_int($otelPoint->value)) {
                $value->setInt64Value($otelPoint->value);
                $ts->setValueType(ValueType::INT64);
            } else {
                $value->setDoubleValue((float) $otelPoint->value);
                $ts->setValueType(ValueType::DOUBLE);
            }
        } elseif ($otelData instanceof Histogram) {
            $ts->setMetricKind(MetricKind::CUMULATIVE);
            $ts->setValueType(ValueType::DISTRIBUTION);

            $dist = new Distribution();
            $dist->setCount($otelPoint->count);
            if ($otelPoint->count > 0) {
                $dist->setMean($otelPoint->sum / $otelPoint->count);
            }
            $dist->setBucketCounts($otelPoint->bucketCounts);

            $bucketOptions = new BucketOptions();
            $explicit = new Explicit();
            $explicit->setBounds($otelPoint->explicitBounds);
            $bucketOptions->setExplicitBuckets($explicit);
            $dist->setBucketOptions($bucketOptions);

            $value->setDistributionValue($dist);
        }

        $point->setValue($value);
        $ts->setPoints([$point]);

        return $ts;
    }

    /**
     * Formats the metric name for Cloud Monitoring.
     * Built-in metrics MUST use the specific internal namespace.
     *
     * @param string $name The OTel instrument name.
     * @return string The fully qualified GCM metric type.
     */
    private function formatMetricName(string $name): string
    {
        return self::NATIVE_METRICS_PREFIX . $name;
    }

    /**
     * Converts nanoseconds to a php Timestamp
     *
     * @param int $nanos
     * @return Timestamp
     */
    private function toTimestamp(int $nanos): Timestamp
    {
        $timestamp = new Timestamp();
        $timestamp->setSeconds((int) ($nanos / 1_000_000_000));
        $timestamp->setNanos((int) ($nanos % 1_000_000_000));
        return $timestamp;
    }

    /**
     * Returns a hash of the client UUID for the metrics
     *
     * @param string $clientUid
     * @return string
     */
    private function generateClientHash(string $clientUid): string
    {
        if ($clientUid === '') {
            return '000000';
        }

        $hashHex = hash('fnv164', $clientUid);
        $firstFour = substr($hashHex, 0, 4);
        $intVal = hexdec($firstFour);
        $tenBits = $intVal >> 6;
        return sprintf('%06x', $tenBits);
    }
}
