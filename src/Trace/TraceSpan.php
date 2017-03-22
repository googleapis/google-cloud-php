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

use Google\Cloud\Core\ArrayTrait;

/**
 * This plain PHP class represents a
 * [TraceSpan resource](https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces#TraceSpan)
 * A span represents a single timed event within a Trace. Spans can be nested
 * and form a trace tree. Often, a trace contains a root span that describes
 * the end-to-end latency of an operation and, optionally, one or more subspans
 * for its suboperations. Spans do not need to be contiguous. There may be
 * gaps between spans in a trace.
 */
class TraceSpan
{
    use ArrayTrait;

    const SPAN_KIND_UNSPECIFIED = 'SPAN_KIND_UNSPECIFIED';
    const SPAN_KIND_RPC_SERVER = 'RPC_SERVER';
    const SPAN_KIND_RPC_CLIENT = 'RPC_CLIENT';

    /**
     * @var array Associative array containing all the fields representing this TraceSpan.
     */
    private $info;

    /**
     * Instantiate a new TraceSpan instance.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $spanId The ID of the span. If not provided,
     *            one will be generated automatically for you.
     *      @type string $kind Distinguishes between spans generated
     *            in a particular context. **Defaults to**
     *            SPAN_KIND_UNSPECIFIED.
     *      @type string $name The name of the span.
     *      @type string $startTime Start time of the span in
     *            nanoseconds in "Zulu" format.
     *      @type string $endTime End time of the span in
     *            nanoseconds in "Zulu" format.
     *      @type string $parentSpanId ID of the parent span if any.
     *      @type array $labels Associative array of $label => $value
     *            to attach to this span.
     * }
     */
    public function __construct($options = [])
    {
        $this->info = $this->pluckArray(
            ['spanId', 'kind', 'name', 'startTime', 'endTime', 'parentSpanId', 'labels'],
            $options
        );
        $this->info += [
            'kind' => self::SPAN_KIND_UNSPECIFIED
        ];

        if (!array_key_exists('spanId', $this->info)) {
            $this->info['spanId'] = $this->generateSpanId();
        }

        if (!array_key_exists('name', $this->info)) {
            $this->info['name'] = $this->generateSpanName();
        }
    }

    /**
     * Set the start time for this span.
     *
     * @param  \DateTimeInterface $when [optional] The start time of this span.
     *         **Defaults to** now.
     */
    public function setStart(\DateTimeInterface $when = null)
    {
        $this->info['startTime'] = $this->formatDate($when);
    }

    /**
     * Set the end time for this span.
     *
     * @param  \DateTimeInterface $when [optional] The end time of this span.
     *         **Defaults to** now.
     */
    public function setFinish(\DateTimeInterface $when = null)
    {
        $this->info['endTime'] = $this->formatDate($when);
    }

    /**
     * Retrieve the ID of this span.
     *
     * @return string
     */
    public function spanId()
    {
        return $this->info['spanId'];
    }

    /**
     * Retrieve the name of this span.
     *
     * @return string
     */
    public function name()
    {
        return $this->info['name'];
    }

    /**
     * Returns a serializable array representing this span.
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Attach labels to this span.
     *
     * @param array $labels Labels in the form of $label => $value
     */
    public function addLabels(array $labels)
    {
        foreach ($labels as $label => $value) {
            $this->addLabel($label, $value);
        }
    }

    /**
     * Attach a single label to this span.
     *
     * @param string $label The name of the label.
     * @param mixed $value The value of the label. Will be cast to a string
     */
    public function addLabel($label, $value)
    {
        if (!array_key_exists('labels', $this->info)) {
            $this->info['labels'] = [];
        }
        $this->info['labels'][$label] = (string) $value;
    }

    /**
     * Returns a "Zulu" formatted string representing the
     * provided \DateTime.
     *
     * @param  \DateTimeInterface $when [optional] The end time of this span.
     *         **Defaults to** now.
     * @return string
     */
    private function formatDate(\DateTimeInterface $when = null)
    {
        if (!$when) {
            list($usec, $sec) = explode(' ', microtime());
            $micro = sprintf("%06d", $usec * 1000000);
            $when = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        }
        $when->setTimezone(new \DateTimeZone('UTC'));
        return $when->format('Y-m-d\TH:i:s.u000\Z');
    }

    /**
     * Generate a random ID for this span. Must be unique per trace,
     * but does not need to be globally unique.
     *
     * @return string
     */
    private function generateSpanId()
    {
        return '' . mt_rand();
    }

    /**
     * Generate a name for this span. Attempts to generate a name
     * based on the caller's code.
     *
     * @return string
     */
    private function generateSpanName()
    {
        // FIXME: clean backtrace rather than guessing the stack depth
        $caller = debug_backtrace(0, 5)[4];
        return sprintf('app/%s/%s/%d', $caller['class'], $caller['function'], $caller['line']);
    }
}
