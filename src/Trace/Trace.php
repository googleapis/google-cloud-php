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

/**
 * This plain PHP class represents a Trace resource. The model currently has no
 * backing API model and is identified by its traceId.
 */
class Trace implements \JsonSerializable
{
    use IdGeneratorTrait;
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
     * @var Span[] List of Span to report
     */
    private $spans = [];

    /**
     * Instantiate a new Trace instance.
     *
     * @param string $projectId The id of the project this trace belongs to.
     * @param string $traceId [optional] The id of the trace. If not provided, one will be generated
     *        automatically for you.
     * @param array $spans [optional] Array of Span constructor arguments. See
     *        {@see Google\Cloud\Trace\Span::__construct()} for configuration details.
     * }
     */
    public function __construct($projectId, $traceId = null, $spans = null)
    {
        $this->projectId = $projectId;
        $this->traceId = $traceId ?: $this->generateTraceId();
        if ($spans) {
            $this->spans = array_map(function ($span) use ($projectId, $traceId) {
                return new Span($traceId, $span);
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
     * Returns a serializable array representing this trace.
     *
     * @param array $options [optional] Configuration Options
     * @return array
     */
    public function jsonSerialize(array $options = [])
    {
        return [
            'projectId' => $this->projectId,
            'traceId' => $this->traceId,
            'spans' => $this->spans
        ];
    }

    /**
     * Retrieves the spans for this trace.
     *
     * @return Span[]
     */
    public function spans()
    {
        return $this->spans;
    }

    /**
     * Create an instance of {@see Google\Cloud\Trace\Span}
     *
     * @param array $options [optional] See {@see Google\Cloud\Trace\Span::__construct()}
     *        for configuration details.
     * @return Span
     */
    public function span(array $options = [])
    {
        return new Span($this->traceId, $options);
    }

    /**
     * Set the spans for this trace.
     *
     * @param Span[] $spans
     */
    public function setSpans(array $spans)
    {
        $this->validateBatch($spans, Span::class);
        $this->spans = $spans;
    }
}
