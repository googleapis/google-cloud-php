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

use Google\Cloud\ValidateTrait;

/**
 * This plain PHP class represents a Trace resource. Traces belong to a
 * project and have many TraceSpans. See:
 * https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces#resource-trace
 *
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $traceClient = $cloud->trace();
 *
 * $trace = $traceClient->trace();
 * ```
 */
class Trace
{
    use ValidateTrait;

    /**
     * The id of the project this trace belongs to.
     * @var string
     */
    private $projectId;

    /**
     * The trace id for this trace. 128-bit numeric formatted as a 32-byte hex string
     * @var string
     */
    private $traceId;

    /**
     * List of TraceSpans to report
     * @var TraceSpan[]
     */
    private $spans = [];

    /**
     * Instantiate a new Trace instance.
     *
     * @param string $projectId The id of the project this trace belongs to.
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $traceId The trace id for this trace. 128-bit numeric
     *            formatted as a 32-byte hex string. If not provided, one will be generated
     *            automatically for you.
     *      @type array $spans List of span data to load.
     * }
     */
    public function __construct($projectId, array $options = [])
    {
        $this->projectId = $projectId;

        if (array_key_exists('traceId', $options)) {
            $this->traceId = $options['traceId'];
        }
        $this->traceId = $this->traceId ?: $this->generateTraceId();

        if (array_key_exists('spans', $options)) {
            foreach ($options['spans'] as $span) {
                array_push($this->spans, new TraceSpan($span));
            }
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
     * Set the trace's projectId
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Returns a serializable array representing this trace.
     *
     * @return array
     */
    public function info()
    {
        return [
            'projectId' => $this->projectId,
            'traceId' => $this->traceId,
            'spans' => array_map(function ($span) {
                return $span->info();
            }, $this->spans)
        ];
    }

    /**
     * Retrieves the spans for this trace.
     *
     * @return array
     */
    public function spans()
    {
        return $this->spans;
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
