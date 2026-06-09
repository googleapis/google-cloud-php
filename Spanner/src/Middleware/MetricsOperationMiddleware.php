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
 * A middleware to be added outside of the retry loops of GAX. This middleware handles the recording of Built-in metrics
 * for an Operation, where an Operation is an end to end call to an RPC with either a success or a failing result.
 */
class MetricsOperationMiddleware implements MiddlewareInterface
{
    private HistogramInterface $operationLatencyHistogram;
    private CounterInterface $operationCountCounter;

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
     * Creates a middleware that handles an entire operation for an RPC call
     *
     * @param callable $nextHandler
     * @param MeterInterface $meter
     * @param string $clientId
     * @param string $projectId
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
        $this->operationLatencyHistogram = $meter->createHistogram(
            'operation_latencies',
            'ms',
            'The latency of an RPC operations',
            $advisory
        );
        $this->operationCountCounter = $meter->createCounter(
            'operation_count',
            '1',
            'The number of RPC operations'
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

        /** @var MetricsContext|null $metricsContext */
        $metricsContext = $options['middlewareOptions']['metricsContext'] ?? null;

        if ($metricsContext) {
            $metricsContext->setOperationInstruments(
                $this->operationCountCounter,
                $this->operationLatencyHistogram
            );

            if ($metricsContext->isResume()) {
                return $next($call, $options);
            }
        }

        $startTime = microtime(true);
        $directPathUsed = false;

        $originalCallback = $options['metadataCallback'] ?? null;
        $options['metadataCallback'] = function ($metadata) use ($originalCallback, &$directPathUsed) {
            $serverTiming = $metadata['server-timing'][0] ?? null;
            if ($serverTiming && strpos($serverTiming, 'afe;') !== false) {
                $directPathUsed = true;
            }
            if ($originalCallback) {
                $originalCallback($metadata);
            }
        };

        try {
            $response = $next(
                $call,
                $options
            );
        } catch (Exception $ex) {
            $this->recordOperation($startTime, $ex->getCode(), $call->getMethod(), $options, $directPathUsed);
            throw $ex;
        }

        if ($response instanceof ServerStream) {
            // Let the stream iterator (Result.php) log the final operation metrics!
        }

        if ($response instanceof PromiseInterface) {
            return $response->then(
                function ($response) use ($startTime, $options, $call, &$directPathUsed) {
                    $this->recordOperation($startTime, Code::OK, $call->getMethod(), $options, $directPathUsed);
                    return $response;
                },
                function ($e) use ($startTime, $options, $call, &$directPathUsed) {
                    $this->recordOperation($startTime, $e->getCode(), $call->getMethod(), $options, $directPathUsed);
                    throw $e;
                }
            );
        }

        // response can be a stream
        return $response;
    }

    /**
     * Records a completed operation (failures are considered completions).
     *
     * @param float $startTime The start time of the operation
     * @param int $code The resulting code of the operation
     * @param string $method The RPC name being called
     * @param array $options The options used for middleware communication
     * @param bool $directPathUsed Whether DirectPath was used
     *
     * @return void
     */
    private function recordOperation(
        float $startTime,
        int $code,
        string $method,
        array $options,
        bool $directPathUsed = false
    ): void {
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // Convert seconds to ms
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

        $labels = [
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

        $this->operationCountCounter->add(1, $labels);
        $this->operationLatencyHistogram->record($duration, $labels);
    }
}
