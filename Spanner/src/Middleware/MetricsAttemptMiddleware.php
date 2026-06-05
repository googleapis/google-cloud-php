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

namespace Google\Cloud\Spanner\Middleware;

use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\Middleware\MiddlewareInterface;
use Google\ApiCore\ServerStream;
use Google\Cloud\Spanner\OpenTelemetry\MetricsContext;
use Google\Rpc\Code;
use GuzzleHttp\Promise\PromiseInterface;
use OpenTelemetry\API\Metrics\CounterInterface;
use OpenTelemetry\API\Metrics\HistogramInterface;
use OpenTelemetry\API\Metrics\MeterInterface;

/**
 * @internal
 *
 * A middleware to be appended inside of the retry loops of GAX.
 * This middleware handles the recording of Built-in metrics
 * for an Attempt, where an Attempt is an RPC call as part of an Operation.
 * If an Operation fails, said Operation may contain multiple attempts depending on the retry configuration.
 */
class MetricsAttemptMiddleware implements MiddlewareInterface
{
    private HistogramInterface $attemptLatencyHistogram;
    private CounterInterface $attemptCountCounter;
    private HistogramInterface $attemptGfeHistogram;
    private CounterInterface $gfeConnectivityErrorCounter;
    private HistogramInterface $attemptAfeHistogram;
    private CounterInterface $afeConnectivityErrorCounter;

    /** @var callable */
    private $nextHandler;
    private string $projectId;
    private string $clientId;
    private string $clientName;
    private string $location;
    private bool $directPathEnabled;

    private const INSTANCE_CONFIG = 'unknown';

    private const BUCKET_BOUNDS = [
        0.0, 0.5, 1.0, 2.0, 3.0, 4.0, 5.0, 6.0, 7.0, 8.0, 9.0, 10.0,
        11.0, 12.0, 13.0, 14.0, 15.0, 16.0, 17.0, 18.0, 19.0, 20.0,
        25.0, 30.0, 40.0, 50.0, 65.0, 80.0, 100.0, 130.0, 160.0, 200.0,
        250.0, 300.0, 400.0, 500.0, 650.0, 800.0, 1000.0, 2000.0, 5000.0,
        10000.0, 20000.0, 50000.0, 100000.0, 200000.0, 400000.0, 800000.0,
        1600000.0, 3200000.0
    ];

    /**
     * Creates a middleware that tracks all the attempts of an RPC call
     *
     * @param callable $nextHandler
     * @param MeterInterface $meter
     * @param string $clientId
     * @param string $projectId
     * @param string $clientName
     * @param string $location
     */
    public function __construct(
        callable $nextHandler,
        MeterInterface $meter,
        string $clientId,
        string $projectId,
        string $clientName,
        string $location
    ) {
        $this->nextHandler = $nextHandler;
        $advisory = ['ExplicitBucketBoundaries' => self::BUCKET_BOUNDS];
        $this->attemptLatencyHistogram = $meter->createHistogram(
            'attempt_latencies',
            'ms',
            'The latency of an RPC attempt',
            $advisory
        );
        $this->attemptCountCounter = $meter->createCounter(
            'attempt_count',
            '1',
            'The number of RPC attempts'
        );
        $this->attemptGfeHistogram = $meter->createHistogram(
            'gfe_latencies',
            'ms',
            'Latency between Google\'s network receiving an RPC and reading back the first byte of the response',
            $advisory
        );
        $this->gfeConnectivityErrorCounter = $meter->createCounter(
            'gfe_connectivity_error_count',
            '1',
            'Number of RPC attempts that failed to reach the GFE or returned no GFE headers'
        );
        $this->attemptAfeHistogram = $meter->createHistogram(
            'afe_latencies',
            'ms',
            'Latency between Spanner Spanner AFE receiving and returning a response.',
            $advisory
        );
        $this->afeConnectivityErrorCounter = $meter->createCounter(
            'afe_connectivity_error_count',
            '1',
            'Number of connectivity errors for Spanner AFE'
        );
        $this->clientId = $clientId;
        $this->projectId = $projectId;
        $this->clientName = 'spanner-php/' . $clientName;
        $this->location = $location;
        $this->directPathEnabled = filter_var(
            getenv('GOOGLE_SPANNER_ENABLE_DIRECT_ACCESS'),
            FILTER_VALIDATE_BOOLEAN
        );
    }

    public function __invoke(Call $call, array $options)
    {
        $next = $this->nextHandler;

        $startTime = microtime(true);
        $directPathUsed = false;

        /** @var MetricsContext|null $metricsContext */
        $metricsContext = $options['middlewareOptions']['metricsContext'] ?? null;
        if ($metricsContext) {
            $metricsContext->setAttemptInstruments(
                $this->attemptCountCounter,
                $this->attemptLatencyHistogram
            );
            $baseLabels = $this->getMetricLabels($call->getMethod(), $options, Code::OK, $directPathUsed);
            unset($baseLabels['status']);
            $metricsContext->setBaseLabels($baseLabels);

            $metricsContext->incrementAttemptCount();
            $metricsContext->setLastAttemptStartTime($startTime);
        }

        // In case that something else is using this callback,
        // we take the original one and call it later.
        $originalCallback = $options['metadataCallback'] ?? null;

        // This gets the metadata on an ok status meaning we can get the GFE latency header for unary calls
        $options['metadataCallback'] = function ($metadata) use ($originalCallback, $call, $options, &$directPathUsed) {
            $serverTiming = $metadata['server-timing'][0] ?? null;
            if ($serverTiming && strpos($serverTiming, 'afe;') !== false) {
                $directPathUsed = true;
            }
            $this->recordGfeAndAfeLatency($metadata, $call, $options, Code::OK);
            if ($originalCallback) {
                $originalCallback($metadata);
            }
        };

        try {
            $response = $next(
                $call,
                $options
            );
        } catch (Exception $e) {
            // In case that the call is not a unary call and it is a streaming call error.
            $this->recordAttempt($startTime, $e->getCode(), $call->getMethod(), $options, $directPathUsed);
            $this->recordGfeAndAfeError($e, $call, $options);
            throw $e;
        }

        if ($response instanceof PromiseInterface) {
            return $response->then(
                function ($response) use ($startTime, $options, $call, &$directPathUsed) {
                    $this->recordAttempt($startTime, Code::OK, $call->getMethod(), $options, $directPathUsed);
                    return $response;
                },
                function ($e) use ($startTime, $options, $call, &$directPathUsed) {
                    $this->recordAttempt($startTime, $e->getCode(), $call->getMethod(), $options, $directPathUsed);
                    $this->recordGfeAndAfeError($e, $call, $options);
                    throw $e;
                }
            );
        }

        if ($response instanceof ServerStream) {
            $metadata = $response->getServerStreamingCall()->getMetadata();
            $this->recordGfeAndAfeLatency($metadata, $call, $options, Code::OK);
        }

        // The response can be a stream
        return $response;
    }

    /**
     * Records an Attempt
     *
     * @param array $options The options being used for the middleware layer to communicate amongst middlewares
     * @param float $startTime The start time of the RPC attempt
     * @param int $code The resulting code of the attempt
     * @param string $method The RPC method name that is being called
     *
     * @return void
     */
    private function recordAttempt(
        float $startTime,
        int $code,
        string $method,
        array $options,
        bool $directPathUsed = false
    ): void {
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // Convert to MS

        $labels = $this->getMetricLabels($method, $options, $code, $directPathUsed);

        $this->attemptCountCounter->add(1, $labels);
        $this->attemptLatencyHistogram->record($duration, $labels);
    }

    /**
     * Records the Gfe and Afe latency
     *
     * @param mixed $metadata
     * @param Call $call
     * @param array $options
     *
     * @return void
     */
    private function recordGfeAndAfeLatency(mixed $metadata, Call $call, array $options, int $status): void
    {
        $serverTiming = $metadata['server-timing'][0] ?? null;
        $gfeLatency = null;
        $afeLatency = null;

        if ($serverTiming) {
            if (preg_match('/gfet4t7;\s*dur=(\d+(\.\d+)?)/', $serverTiming, $matches)) {
                $gfeLatency = (float) $matches[1];
            }

            if (preg_match('/afe;\s*dur=(\d+(\.\d+)?)/', $serverTiming, $matches)) {
                $afeLatency = (float) $matches[1];
            }
        }

        $directPathUsed = ($serverTiming && strpos($serverTiming, 'afe;') !== false);
        $labels = $this->getMetricLabels($call->getMethod(), $options, $status, $directPathUsed);

        if ($serverTiming) {
            if (!is_null($gfeLatency)) {
                $this->attemptGfeHistogram->record($gfeLatency, $labels);
            }
            if (!is_null($afeLatency)) {
                $this->attemptAfeHistogram->record($afeLatency, $labels);
            }
        } else {
            if ($this->directPathEnabled) {
                $this->afeConnectivityErrorCounter->add(1, $labels);
            } else {
                $this->gfeConnectivityErrorCounter->add(1, $labels);
            }
        }
    }

    /**
     * Creates an array containing the labels for metrics.
     *
     * @param string $method
     * @param array $options
     * @param int $code
     *
     * @return array
     */
    private function getMetricLabels(string $method, array $options, int $code, bool $directPathUsed = false): array
    {
        $codeName = Code::name($code);

        // Format method name to match the Go/spec format (e.g. Spanner.Commit)
        $methodName = $method;
        if (strpos($methodName, '/') === 0) {
            $methodName = substr($methodName, 1);
        }
        if (strpos($methodName, 'google.spanner.v1.') === 0) {
            $methodName = substr($methodName, strlen('google.spanner.v1.'));
        }
        $methodName = str_replace('/', '.', $methodName);

        // Extract resource information from the GAX routing header.
        $params = $options['headers']['x-goog-request-params'][0] ?? '';
        $prefix = urldecode($params);

        $instanceId = 'unknown';
        $databaseId = 'unknown';
        if (preg_match('/instances\/([^\/]+)\/databases\/([^\/]+)/', $prefix, $matches)) {
            $instanceId = $matches[1];
            $databaseId = $matches[2];
        }

        return [
            'method' => $methodName,
            'status' => $codeName,
            'instance_id' => $instanceId,
            'database' => $databaseId,
            'project_id' => $this->projectId,
            'client_uid' => $this->clientId,
            'client_name' => $this->clientName,
            'instance_config' => self::INSTANCE_CONFIG,
            'location' => $this->location,
            'directpath_enabled' => $this->directPathEnabled ? 'true' : 'false',
            'directpath_used' => $directPathUsed ? 'true' : 'false'
        ];
    }

    /**
     * Records an GFE and/or an AFE error
     *
     * @param Exception $e
     * @param Call $call
     * @param array $options
     *
     * @return void
     */
    private function recordGfeAndAfeError(Exception $e, Call $call, array $options): void
    {
        if ($e instanceof ApiException) {
            $this->recordGfeAndAfeLatency($e->getMetadata() ?? [], $call, $options, $e->getCode());
        } else {
            $this->recordGfeAndAfeLatency([], $call, $options, Code::UNKNOWN);
        }
    }
}
