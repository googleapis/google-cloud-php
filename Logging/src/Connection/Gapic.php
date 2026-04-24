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

use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\V2\Client\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\Client\LoggingServiceV2Client;
use Google\Cloud\Logging\V2\Client\MetricsServiceV2Client;
use Google\Cloud\Logging\V2\CreateLogMetricRequest;
use Google\Cloud\Logging\V2\CreateSinkRequest;
use Google\Cloud\Logging\V2\DeleteLogMetricRequest;
use Google\Cloud\Logging\V2\DeleteLogRequest;
use Google\Cloud\Logging\V2\DeleteSinkRequest;
use Google\Cloud\Logging\V2\GetLogMetricRequest;
use Google\Cloud\Logging\V2\GetSinkRequest;
use Google\Cloud\Logging\V2\ListLogEntriesRequest;
use Google\Cloud\Logging\V2\ListLogMetricsRequest;
use Google\Cloud\Logging\V2\ListSinksRequest;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\LogSink;
use Google\Cloud\Logging\V2\UpdateLogMetricRequest;
use Google\Cloud\Logging\V2\UpdateSinkRequest;
use Google\Cloud\Logging\V2\WriteLogEntriesRequest;

/**
 * Implementation of the
 * [Google Stackdriver Logging gRPC API](https://cloud.google.com/logging/docs/).
 *
 * @internal
 */
class Gapic
{
    use ApiHelperTrait;
    use RequestProcessorTrait;

    private ConfigServiceV2Client $configClient;
    private LoggingServiceV2Client $loggingClient;
    private MetricsServiceV2Client $metricsClient;
    private Serializer $serializer;

    /**
     * @param array $config
     */
    public function __construct(private array $config = [])
    {
        $this->serializer = new Serializer([
            'timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'severity' => function ($v) {
                return Logger::getLogLevelMap()[$v];
            },
            'json_payload' => function ($v) {
                return $this->unpackStructFromApi($v);
            }
        ], [], [
            'json_payload' => function ($v) {
                return $this->formatStructForApi($v);
            },
            'severity' => function ($v) {
                return array_flip(Logger::getLogLevelMap())[strtoupper($v)];
            }
        ], [
            'google.protobuf.Duration' => function ($v) {
                return $this->formatDurationForApi($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampForApi($v);
            }
        ]);
        $this->optionsValidator = new OptionsValidator($this->serializer);
    }

    private function getConfigClient()
    {
        return $this->configClient = $this->configClient
            ?? $this->config['configGapicClient']
            ?? new ConfigServiceV2Client($this->config);
    }

    private function getLoggingClient()
    {
        return $this->loggingClient = $this->loggingClient
            ?? $this->config['loggingGapicClient']
            ?? new LoggingServiceV2Client($this->config);
    }

    private function getMetricsClient()
    {
        return $this->metricsClient = $this->metricsClient
            ?? $this->config['metricsGapicClient']
            ?? new MetricsServiceV2Client($this->config);
    }

    /**
     * @param array $args
     * @return array
     */
    public function writeLogEntries(array $args = [])
    {
        /**
         * @var WriteLogEntriesRequest $writeLogEntriesRequest
         * @var array $callOptions
         */
        [$writeLogEntriesRequest, $callOptions] = $this->validateOptions(
            $args,
            new WriteLogEntriesRequest(),
            CallOptions::class
        );

        return $this->handleResponse(
            $this->getLoggingClient()->writeLogEntries($writeLogEntriesRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function listLogEntries(array $args = [])
    {
        /**
         * @var ListLogEntriesRequest $listLogEntriesRequest
         * @var array $callOptions
         */
        [$listLogEntriesRequest, $callOptions] = $this->validateOptions(
            $args,
            new ListLogEntriesRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getLoggingClient()->listLogEntries($listLogEntriesRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function createSink(array $args = [])
    {
        /**
         * @var LogSink $logSink
         * @var CreateSinkRequest $createSinkRequest
         * @var array $callOptions
         */
        [$logSink, $createSinkRequest, $callOptions] = $this->validateOptions(
            $args,
            new LogSink(),
            new CreateSinkRequest(),
            CallOptions::class
        );

        $createSinkRequest->setSink($logSink);

        return $this->handleResponse(
            $this->getConfigClient()->createSink($createSinkRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function getSink(array $args = [])
    {
        /**
         * @var GetSinkRequest $getSinkRequest
         * @var array $callOptions
         */
        [$getSinkRequest, $callOptions] = $this->validateOptions(
            $args,
            new GetSinkRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getConfigClient()->getSink($getSinkRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function listSinks(array $args = [])
    {
        /**
         * @var ListSinksRequest $listSinksRequest
         * @var array $callOptions
         */
        [$listSinksRequest, $callOptions] = $this->validateOptions(
            $args,
            new ListSinksRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getConfigClient()->listSinks($listSinksRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateSink(array $args = [])
    {
        /**
         * @var LogSink $logSink
         * @var UpdateSinkRequest $updateSinkRequest
         * @var array $callOptions
         */
        [$logSink, $updateSinkRequest, $callOptions] = $this->validateOptions(
            $args,
            new LogSink(),
            new UpdateSinkRequest(),
            CallOptions::class
        );

        $updateSinkRequest->setSink($logSink);

        return $this->handleResponse(
            $this->getConfigClient()->updateSink($updateSinkRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteSink(array $args = [])
    {
        /**
         * @var DeleteSinkRequest $deleteSinkRequest
         * @var array $callOptions
         */
        [$deleteSinkRequest, $callOptions] = $this->validateOptions(
            $args,
            new DeleteSinkRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getConfigClient()->deleteSink($deleteSinkRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function createLogMetric(array $args = [])
    {
        /**
         * @var LogMetric $logMetric
         * @var CreateLogMetricRequest $createLogMetricRequest
         * @var array $callOptions
         */
        [$logMetric, $createLogMetricRequest, $callOptions] = $this->validateOptions(
            $args,
            new LogMetric(),
            new CreateLogMetricRequest(),
            CallOptions::class
        );

        $createLogMetricRequest->setMetric($logMetric);

        return $this->handleResponse(
            $this->getMetricsClient()->createLogMetric($createLogMetricRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function getLogMetric(array $args = [])
    {
        /**
         * @var GetLogMetricRequest $getLogMetricRequest
         * @var array $callOptions
         */
        [$getLogMetricRequest, $callOptions] = $this->validateOptions(
            $args,
            new GetLogMetricRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getMetricsClient()->getLogMetric($getLogMetricRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function listLogMetrics(array $args = [])
    {
        /**
         * @var ListLogMetricsRequest $listLogMetricsRequest
         * @var array $callOptions
         */
        [$listLogMetricsRequest, $callOptions] = $this->validateOptions(
            $args,
            new ListLogMetricsRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getMetricsClient()->listLogMetrics($listLogMetricsRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateLogMetric(array $args = [])
    {
        /**
         * @var LogMetric $logMetric
         * @var UpdateLogMetricRequest $updateLogMetricRequest
         * @var array $callOptions
         */
        [$logMetric, $updateLogMetricRequest, $callOptions] = $this->validateOptions(
            $args,
            new LogMetric(),
            new UpdateLogMetricRequest(),
            CallOptions::class
        );

        $updateLogMetricRequest->setMetric($logMetric);

        return $this->handleResponse(
            $this->getMetricsClient()->updateLogMetric($updateLogMetricRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteLogMetric(array $args = [])
    {
        /**
         * @var DeleteLogMetricRequest $deleteLogMetricRequest
         * @var array $callOptions
         */
        [$deleteLogMetricRequest, $callOptions] = $this->validateOptions(
            $args,
            new DeleteLogMetricRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getMetricsClient()->deleteLogMetric($deleteLogMetricRequest, $callOptions)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteLog(array $args = [])
    {
        /**
         * @var DeleteLogRequest $deleteLogRequest
         * @var array $callOptions
         */
        [$deleteLogRequest, $callOptions] = $this->validateOptions(
            $args,
            new DeleteLogRequest(),
            CallOptions::class
        );
        return $this->handleResponse(
            $this->getLoggingClient()->deleteLog($deleteLogRequest, $callOptions)
        );
    }
}
