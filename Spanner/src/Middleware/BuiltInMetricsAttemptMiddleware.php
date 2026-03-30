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
class BuiltInMetricsAttemptMiddleware implements MiddlewareInterface
{
    private HistogramInterface $attemptLatencyHistogram;
    private CounterInterface $attemptCountCounter;
    private HistogramInterface $attemptGfeHistogram;
    private CounterInterface $gfeConnectivityErrorCounter;

    /** @var callable */
    private $nextHandler;
    private string $projectId;
    private string $clientId;
    private string $clientName;

    private const INSTANCE_CONFIG = 'unknown';
    private const LOCATION_LABEL = 'global';

    /**
     * Creates a middleware that tracks all the attempts of an RPC call
     *
     * @param callable $nextHandler
     * @param MeterInterface $meter
     * @param string $clientId
     * @param string $projectId
     * @param string $clientName
     */
    public function __construct(
        callable $nextHandler,
        MeterInterface $meter,
        string $clientId,
        string $projectId,
        string $clientName,
    ) {
        $this->nextHandler = $nextHandler;
        $this->attemptLatencyHistogram = $meter->createHistogram(
            'attempt_latencies',
            'ms',
            'The latency of an RPC attempt'
        );
        $this->attemptCountCounter = $meter->createCounter(
            'attempt_count',
            '1',
            'The number of RPC attempts'
        );
        $this->attemptGfeHistogram = $meter->createHistogram(
            'gfe_latencies',
            'ms',
            'Latency between Google\'s network receiving an RPC and reading back the first byte of the response'
        );
        $this->gfeConnectivityErrorCounter = $meter->createCounter(
            'gfe_connectivity_error_count',
            '1',
            'Number of RPC attempts that failed to reach the GFE or returned no GFE headers'
        );
        $this->clientId = $clientId;
        $this->projectId = $projectId;
        $this->clientName = $clientName;
    }

    public function __invoke(Call $call, array $options)
    {
        $next = $this->nextHandler;

        $startTime = microtime(true);

        // In case that something else is using this callback,
        // we take the original one and call it later.
        $originalCallback = $options['metadataCallback'] ?? null;

        // This gets the metadata on an ok status meaning we can get the GFE latency header for unary calls
        $options['metadataCallback'] = function ($metadata) use ($originalCallback, $call, $options) {
            $this->recordGfeLatency($metadata, $call, $options);
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
            $this->recordAttempt($startTime, $e->getCode(), $call->getMethod(), $options);
            $this->recordGfeError($e, $call, $options);
            throw $e;
        }

        if ($response instanceof ServerStream) {
            $this->recordAttempt($startTime, Code::OK, $call->getMethod(), $options);
            $this->recordGfeLatency($response->getServerStreamingCall()->getMetadata(), $call, $options);
        }

        if ($response instanceof PromiseInterface) {
            return $response->then(
                function ($response) use ($startTime, $options, $call) {
                    $this->recordAttempt($startTime, Code::OK, $call->getMethod(), $options);
                    return $response;
                },
                function ($e) use ($startTime, $options, $call) {
                    $this->recordAttempt($startTime, $e->getCode(), $call->getMethod(), $options);
                    $this->recordGfeError($e, $call, $options);
                    throw $e;
                }
            );
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
    private function recordAttempt(float $startTime, int $code, string $method, array $options): void
    {
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // Convert to MS

        $labels = $this->getMetricLabels($method, $options, $code);

        $this->attemptCountCounter->add(1, $labels);
        $this->attemptLatencyHistogram->record($duration, $labels);
    }

    private function recordGfeLatency($metadata, Call $call, array $options): void
    {
        $serverTiming = $metadata['server-timing'][0] ?? null;
        $gfeLatency = null;

        if ($serverTiming) {
            if (preg_match('/gfet4t7;\s*dur=(\d+(\.\d+)?)/', $serverTiming, $matches)) {
                $gfeLatency = (float) $matches[1];
            }
        }

        $labels = $this->getMetricLabels($call->getMethod(), $options, Code::OK);

        if ($gfeLatency !== null) {
            $this->attemptGfeHistogram->record($gfeLatency, $labels);
        } else {
            $this->gfeConnectivityErrorCounter->add(1, $labels);
        }
    }

    private function getMetricLabels(string $method, array $options, int $code): array
    {
        $codeName = Code::name($code);

        // Extract resource information from the GAX routing header.
        $params = $options['headers']['x-goog-request-params'][0] ?? '';
        $prefix = urldecode($params);

        if (preg_match('/instances\/([^\/]+)\/databases\/([^\/]+)/', $prefix, $matches)) {
            $instanceId = $matches[1];
            $databaseId = $matches[2];
        }

        return [
            'method' => $method,
            'status' => $codeName,
            'instance_id' => $instanceId ?? '',
            'database' => $databaseId ?? '',
            'project_id' => $this->projectId,
            'client_uid' => $this->clientId,
            'client_name' => $this->clientName,
            'instance_config' => self::INSTANCE_CONFIG,
            'location' => self::LOCATION_LABEL
        ];
    }

    private function recordGfeError(Exception $e, Call $call, array $options): void
    {
        if ($e instanceof ApiException) {
            $this->recordGfeLatency($e->getMetadata() ?? [], $call, $options);
        } else {
            $this->recordGfeLatency([], $call, $options);
        }
    }
}
