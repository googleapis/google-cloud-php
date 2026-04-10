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

    private const INSTANCE_CONFIG = 'unknown';
    private const LOCATION_LABEL = 'global';

    /**
     * Creates a middleware that handles an entire operation for an RPC call
     *
     * @param callable $nextHandler
     * @param MeterInterface $meter
     * @param string $clientId
     * @param string $projectId
     */
    public function __construct(
        callable $nextHandler,
        MeterInterface $meter,
        string $clientId,
        string $projectId,
        string $clientName
    ) {
        $this->nextHandler = $nextHandler;
        $this->operationLatencyHistogram = $meter->createHistogram(
            'operation_latencies',
            'ms',
            'The latency of an RPC operations'
        );
        $this->operationCountCounter = $meter->createCounter(
            'operation_count',
            '1',
            'The number of RPC operations'
        );
        $this->clientId = $clientId;
        $this->projectId = $projectId;
        $this->clientName = $clientName;
    }

    public function __invoke(Call $call, array $options)
    {
        $next = $this->nextHandler;
        $startTime = microtime(true);

        try {
            $response = $next(
                $call,
                $options
            );
        } catch (Exception $ex) {
            $this->recordOperation($startTime, $ex->getCode(), $call->getMethod(), $options);
            throw $ex;
        }

        if ($response instanceof ServerStream) {
            $this->recordOperation($startTime, Code::OK, $call->getMethod(), $options);
        }

        if ($response instanceof PromiseInterface) {
            return $response->then(
                function ($response) use ($startTime, $options, $call) {
                    $this->recordOperation($startTime, Code::OK, $call->getMethod(), $options);
                    return $response;
                },
                function ($e) use ($startTime, $options, $call) {
                    $this->recordOperation($startTime, $e->getCode(), $call->getMethod(), $options);
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
     *
     * @return void
     */
    private function recordOperation(float $startTime, int $code, string $method, array $options): void
    {
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // Convert seconds to ms
        $codeName = Code::name($code);

        // Extract resource information from the GAX routing header.
        $params = $options['headers']['x-goog-request-params'][0] ?? '';
        $prefix = urldecode($params);

        if (preg_match('/instances\/([^\/]+)\/databases\/([^\/]+)/', $prefix, $matches)) {
            $instanceId = $matches[1];
            $databaseId = $matches[2];
        }

        $labels = [
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

        $this->operationCountCounter->add(1, $labels);
        $this->operationLatencyHistogram->record($duration, $labels);
    }
}
