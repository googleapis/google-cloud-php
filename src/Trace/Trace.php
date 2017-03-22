<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Trace\Connection\ConnectionInterface;

/**
 * This plain PHP class represents a Trace resource. For more information see
 * [TraceResource](https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces#resource-trace)
 */
class Trace
{
    use ValidateTrait;

    /**
     * @var ConnectionInterface Represents a connection to Stackdriver Trace.
     */
    private $connection;

    /**
     * @var string The id of the project this trace belongs to.
     */
    private $projectId;

    /**
     * @var string The trace id for this trace. 128-bit numeric formatted as a 32-byte hex string
     */
    private $traceId;

    /**
     * @var TraceSpan[] List of TraceSpans to report
     */
    private $spans = [];

    /**
     * Instantiate a new Trace instance.
     *
     * @param ConnectionInterface $connection The connection to Stackdriver Trace.
     * @param string $projectId The id of the project this trace belongs to.
     * @param string $traceId [optional] The id of the trace. If not provided, one will be generated
     *        automatically for you.
     * @param array $spans [optional] Array of TraceSpan constructor arguments. See
     *        {@see Google\Cloud\Trace\TraceSpan::__construct()} for configuration details.
     * }
     */
    public function __construct(ConnectionInterface $connection, $projectId, $traceId = null, $spans = null)
    {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->traceId = $traceId ?: $this->generateTraceId();
        if ($spans) {
            $this->spans = array_map(function ($span) {
                return new TraceSpan($span);
            }, $spans);
        }
    }

    /**
     * Retrieves the trace's id.
     *
     * @return string
     */
    public function traceId()
    {
        return $this->traceId;
    }

    /**
     * Returns a serializable array representing this trace. If no span data
     * is cached, a network request will be made to retrieve it.
     *
     * @see https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces/get Traces get API documentation.
     *
     * @param array $options [optional] Configuration Options
     * @return array
     */
    public function info(array $options = [])
    {
        // We don't want to maintain both an info array and array of TraceSpans,
        // so we'll rely on the presence of the loaded/specified spans for whether
        // or not we should fetch remote data.
        if (!$this->spans) {
            $this->reload($options);
        }

        return [
            'projectId' => $this->projectId,
            'traceId' => $this->traceId,
            'spans' => array_map(function ($span) {
                return $span->info();
            }, $this->spans)
        ];
    }

    /**
     * Triggers a network request to load a span's details.
     *
     * @see https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces/get Traces get API documentation.
     *
     * @param array $options [optional] Configuration Options
     */
    public function reload(array $options = [])
    {
        $trace = $this->connection->getTrace([
            'projectId' => $this->projectId,
            'traceId' => $this->traceId
        ] + $options);

        if (empty($trace)) {
            throw new NotFoundException('Trace ID does not exist', 404);
        }

        $this->spans = array_map(function ($span) {
            return new TraceSpan($span);
        }, $trace['spans']);
    }

    /**
     * Retrieves the spans for this trace.
     *
     * @return TraceSpan[]
     */
    public function spans()
    {
        return $this->spans;
    }

    /**
     * Create an instance of {@see Google\Cloud\Trace\TraceSpan}
     *
     * @param array $options [optional] See {@see Google\Cloud\Trace\TraceSpan::__construct()}
     *      for configuration details.
     * @return TraceSpan
     */
    public function span(array $options = [])
    {
        return new TraceSpan($options);
    }

    /**
     * Set the spans for this trace.
     *
     * @param TraceSpan[] $spans
     */
    public function setSpans(array $spans)
    {
        $this->validateBatch($spans, TraceSpan::class);
        $this->spans = $spans;
    }

    /**
     * Generates a random trace id as a UUID without dashes.
     *
     * @return string
     */
    private function generateTraceId()
    {
        return sprintf(
            '%04x%04x%04x%04x%04x%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
