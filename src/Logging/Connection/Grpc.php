<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Logging\Connection;

use DrSlump\Protobuf\Codec\CodecInterface;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\V2\ConfigServiceV2Api;
use Google\Cloud\Logging\V2\LoggingServiceV2Api;
use Google\Cloud\Logging\V2\MetricsServiceV2Api;
use Google\Cloud\PhpArray;
use Google\Cloud\GrpcRequestWrapper;
use Google\Cloud\GrpcTrait;
use google\logging\v2\LogEntry;
use google\logging\v2\LogMetric;
use google\logging\v2\LogSink;
use google\logging\v2\LogSink\VersionFormat;

/**
 * Implementation of the
 * [Google Stackdriver Logging gRPC API](https://cloud.google.com/logging/docs/).
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    private static $versionFormatMap = [
        VersionFormat::VERSION_FORMAT_UNSPECIFIED => 'VERSION_FORMAT_UNSPECIFIED',
        VersionFormat::V1 => 'V1',
        VersionFormat::V2 => 'V2'
    ];

    /**
     * @var ConfigServiceV2API
     */
    private $configApi;

    /**
     * @var LoggingServiceV2Api
     */
    private $loggingApi;

    /**
     * @var MetricsServiceV2Api
     */
    private $metricsApi;

    /**
     * @var CodecInterface
     */
    private $codec;

    /**
     * @var array
     */
    private $sinkKeys = [
        'name',
        'destination',
        'filter',
        'outputVersionFormat'
    ];

    /**
     * @var array
     */
    private $metricKeys = [
        'name',
        'description',
        'filter'
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->codec = new PhpArray([
            'timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'severity' => function ($v) {
                return Logger::getLogLevelMap()[$v];
            },
            'outputVersionFormat' => function ($v) {
                return self::$versionFormatMap[$v];
            }
        ]);
        $config['codec'] = $this->codec;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $gaxConfig = $this->getGaxConfig();

        $this->configApi = new ConfigServiceV2Api($gaxConfig);
        $this->loggingApi = new LoggingServiceV2Api($gaxConfig);
        $this->metricsApi = new MetricsServiceV2Api($gaxConfig);
    }

    /**
     * @param array $args
     * @return array
     */
    public function writeEntries(array $args = [])
    {
        $pbEntries = [];
        $entries = $this->pluck('entries', $args);

        foreach ($entries as $entry) {
            $pbEntries[] = $this->buildEntry($entry);
        }

        return $this->send([$this->loggingApi, 'writeLogEntries'], [
            $pbEntries,
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listEntries(array $args = [])
    {
        return $this->send([$this->loggingApi, 'listLogEntries'], [
            $this->pluck('projectIds', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function createSink(array $args = [])
    {
        if (isset($args['outputVersionFormat'])) {
            $args['outputVersionFormat'] = array_flip(self::$versionFormatMap)[$args['outputVersionFormat']];
        }

        $pbSink = (new LogSink())->deserialize(
            $this->pluckArray($this->sinkKeys, $args),
            $this->codec
        );

        return $this->send([$this->configApi, 'createSink'], [
            $this->pluck('parent', $args),
            $pbSink,
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getSink(array $args = [])
    {
        return $this->send([$this->configApi, 'getSink'], [
            $this->pluck('sinkName', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listSinks(array $args = [])
    {
        return $this->send([$this->configApi, 'listSinks'], [
            $this->pluck('parent', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateSink(array $args = [])
    {
        if (isset($args['outputVersionFormat'])) {
            $args['outputVersionFormat'] = array_flip(self::$versionFormatMap)[$args['outputVersionFormat']];
        }

        $pbSink = (new LogSink())->deserialize(
            $this->pluckArray($this->sinkKeys, $args),
            $this->codec
        );

        return $this->send([$this->configApi, 'updateSink'], [
            $this->pluck('sinkName', $args),
            $pbSink,
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteSink(array $args = [])
    {
        return $this->send([$this->configApi, 'deleteSink'], [
            $this->pluck('sinkName', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function createMetric(array $args = [])
    {
        $pbMetric = (new LogMetric())->deserialize(
            $this->pluckArray($this->metricKeys, $args),
            $this->codec
        );

        return $this->send([$this->metricsApi, 'createLogMetric'], [
            $this->pluck('parent', $args),
            $pbMetric,
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getMetric(array $args = [])
    {
        return $this->send([$this->metricsApi, 'getLogMetric'], [
            $this->pluck('metricName', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listMetrics(array $args = [])
    {
        return $this->send([$this->metricsApi, 'listLogMetrics'], [
            $this->pluck('parent', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateMetric(array $args = [])
    {
        $pbMetric = (new LogMetric())->deserialize(
            $this->pluckArray($this->metricKeys, $args),
            $this->codec
        );

        return $this->send([$this->metricsApi, 'updateLogMetric'], [
            $this->pluck('metricName', $args),
            $pbMetric,
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteMetric(array $args = [])
    {
        return $this->send([$this->metricsApi, 'deleteLogMetric'], [
            $this->pluck('metricName', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteLog(array $args = [])
    {
        return $this->send([$this->loggingApi, 'deleteLog'], [
            $this->pluck('logName', $args),
            $args
        ]);
    }

    /**
     * @param array $entry
     * @return LogEntry
     */
    private function buildEntry(array $entry)
    {
        if (isset($entry['jsonPayload'])) {
            $entry['jsonPayload'] = $this->formatStructForApi($entry['jsonPayload']);
        }

        if (isset($entry['labels'])) {
            $entry['labels'] = $this->formatLabelsForApi($entry['labels']);
        }

        if (isset($entry['resource']['labels'])) {
            $entry['resource']['labels'] = $this->formatLabelsForApi($entry['resource']['labels']);
        }

        if (isset($entry['severity'])) {
            $entry['severity'] = array_flip(Logger::getLogLevelMap())[$entry['severity']];
        }

        return (new LogEntry)->deserialize($entry, $this->codec);
    }
}
