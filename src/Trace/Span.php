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

/**
 * This plain PHP class represents a Span resource.
 *
 * A span represents a single timed event within a Trace. Spans can be nested
 * and form a trace tree. Often, a trace contains a root span that describes
 * the end-to-end latency of an operation and, optionally, one or more subspans
 * for its suboperations. Spans do not need to be contiguous. There may be
 * gaps between spans in a trace.
 *
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/projects.traces/batchWrite#Span
 */
class Span implements \JsonSerializable
{
    use AttributeTrait;
    use TimestampTrait;

    /**
     * @var string [TRACE_ID] is a unique identifier for a trace within a
     *      project; it is a 32-character hexadecimal encoding of a 16-byte
     *      array.
     */
    private $traceId;

    /**
     * @var string The [SPAN_ID] portion of the span's resource name.
     */
    private $spanId;

    /**
     * @var string The [SPAN_ID] of this span's parent span. If this is a root
     *      span, then this field must be empty.
     */
    private $parentSpanId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeInterface The start time of the span. On the client side,
     *      this is the time kept by the local machine where the span execution
     *      starts. On the server side, this is the time when the server's
     *      application handler starts running.
     */
    private $startTime;

    /**
     * @var \DateTimeInterface The end time of the span. On the client side,
     *      this is the time kept by the local machine where the span execution
     *      ends. On the server side, this is the time when the server's
     *      application handler stops running.
     */
    private $endTime;

    /**
     * @var array Stack trace captured at the start of the span.
     */
    private $stackTrace;

    /**
     * @var TimeEvent[] A set of time events. You can have up to 32 annotations
     *      and 128 message events per span.
     */
    private $timeEvents;

    /**
     * @var Link[] Links associated with the span. You can have up to 128 links
     *      per Span.
     */
    private $links;

    /**
     * @var Status An optional final status for this span.
     */
    private $status;

    /**
     * @var bool A highly recommended but not required flag that identifies when
     *      a trace crosses a process boundary. True when the parent_span
     *      belongs to the same process as the current span.
     */
    private $sameProcessAsParentSpan;

    /**
     * Instantiate a new Span instance.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $spanId The ID of the span. If not provided,
     *            one will be generated automatically for you.
     *      @type string $name The name of the span.
     *      @type \DateTimeInterface|int|float|string $startTime Start time of the span in nanoseconds.
     *            If provided as a string, it must be in "Zulu" format. If provided as an int or float, it is
     *            expected to be a Unix timestamp.
     *      @type \DateTimeInterface|int|float|string $endTime End time of the span in nanoseconds.
     *            If provided as a string, it must be in "Zulu" format. If provided as an int or float, it is
     *            expected to be a Unix timestamp.
     *      @type string $parentSpanId ID of the parent span if any.
     *      @type array $attributes Associative array of $label => $value
     *            to attach to this span.
     *      @type array $stackTrace Stack trace captured at the start of the span.
     *      @type TimeEvent[] $timeEvents A set of time events. You can have up
     *            to 32 annotations and 128 message events per span.
     *      @type Link[] $links Links associated with the span. You can have up
     *            to 128 links per Span.
     *      @type Status $status An optional final status for this span.
     * }
     */
    public function __construct($traceId, $options = [])
    {
        $this->traceId = $traceId;
        $options += [
            'status' => null,
            'startTime' => null,
            'attributes' => [],
            'timeEvents' => [],
            'links' => []
        ];

        if (array_key_exists('name', $options)) {
            $this->name = $options['name'];
        } else {
            $this->name = $this->generateSpanName();
        }

        if (array_key_exists('spanId', $options)) {
            $this->setSpanId($options['spanId']);
        } else {
            $this->setSpanId($this->generateSpanId());
        }

        if (array_key_exists('parentSpanId', $options)) {
            $this->setParentSpanId($options['parentSpanId']);
        }

        if (array_key_exists('stackTrace', $options)) {
            $this->stackTrace = new StackTrace($options['stackTrace']);
        }

        if (array_key_exists('startTime', $options)) {
            $this->setStartTime($options['startTime']);
        }
        if (array_key_exists('endTime', $options)) {
            $this->setEndTime($options['endTime']);
        }

        $this->status = $options['status'];
        $this->addAttributes($options['attributes']);
        $this->addTimeEvents($options['timeEvents']);
        $this->addLinks($options['links']);
    }

    /**
     * Set the start time for this span.
     *
     * @param  \DateTimeInterface|int|float|string $when [optional] The start time of this span.
     *         **Defaults to** now. If provided as a string, it must be in "Zulu" format.
     *         If provided as an int or float, it is expected to be a Unix timestamp.
     */
    public function setStartTime($when = null)
    {
        $this->startTime = $this->formatDate($when);
    }

    /**
     * Set the end time for this span.
     *
     * @param  \DateTimeInterface|int|float|string $when [optional] The end time of this span.
     *         **Defaults to** now. If provided as a string, it must be in "Zulu" format.
     *         If provided as an int or float, it is expected to be a Unix timestamp.
     */
    public function setEndTime($when = null)
    {
        $this->endTime = $this->formatDate($when);
    }

    /**
     * Set the ID of this span
     *
     * @param string $spanId
     */
    public function setSpanId($spanId)
    {
        $this->spanId = str_pad($spanId, 16, '0', STR_PAD_LEFT);
    }

    /**
     * Set the ID of this span's parent
     *
     * @param string $spanId
     */
    public function setParentSpanId($spanId)
    {
        $this->parentSpanId = str_pad($spanId, 16, '0', STR_PAD_LEFT);
    }

    /**
     * Retrieve the ID of this span.
     *
     * @return string
     */
    public function spanId()
    {
        return $this->spanId;
    }

    /**
     * Retrieve the TraceID of this span
     *
     * @return string
     */
    public function traceId()
    {
        return $this->traceId;
    }

    /**
     * Retrieve the ID of this span's parent if it exists.
     *
     * @return string
     */
    public function parentSpanId()
    {
        return $this->parentSpanId;
    }

    /**
     * Retrieve the name of this span.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the info array for serialization.
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'displayName' => [
                'value' => $this->name
            ],
            'spanId' => $this->spanId,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime
        ];
        if ($this->parentSpanId) {
            $data['parentSpanId'] = $this->parentSpanId;
        }
        if ($this->attributes) {
            $data['attributes'] = $this->attributes;
        }
        if ($this->timeEvents) {
            $data['timeEvents'] = [
                'timeEvent' => $this->timeEvents
            ];
        }
        if ($this->links) {
            $data['links'] = [
                'link' => $this->links
            ];
        }
        if ($this->status) {
            $data['status'] = $this->status;
        }
        if ($this->stackTrace) {
            $data['stackTrace'] = $this->stackTrace;
        }
        return $data;
    }

    /**
     * Add multiple TimeEvent to this span.
     *
     * @param TimeEvent[] $events
     */
    public function addTimeEvents(array $events)
    {
        foreach ($events as $event) {
            $this->addTimeEvent($event);
        }
    }

    /**
     * Add a single TimeEvent to this span.
     *
     * @param TimeEvent $event
     */
    public function addTimeEvent(TimeEvent $event)
    {
        if (!$this->timeEvents) {
            $this->timeEvents = [];
        }
        $this->timeEvents[] = $event;
    }

    /**
     * Add multiple Links to this span.
     *
     * @param Link[] $links
     */
    public function addLinks(array $links)
    {
        foreach ($links as $link) {
            $this->addLink($link);
        }
    }

    /**
     * Add a single Link to this span.
     *
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        if (!$this->links) {
            $this->links = [];
        }
        $this->links[] = $link;
    }

    /**
     * Generate a random ID for this span. Must be unique per trace,
     * but does not need to be globally unique.
     *
     * @return string
     */
    private function generateSpanId()
    {
        return dechex(mt_rand());
    }

    /**
     * Generate a name for this span. Attempts to generate a name
     * based on the caller's code.
     *
     * @return string
     */
    private function generateSpanName()
    {
        // Try to find the first stacktrace class entry that doesn't start with Google\Cloud\Trace
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $bt) {
            $bt += ['line' => null];
            if (!array_key_exists('class', $bt)) {
                return implode('/', array_filter(['app', basename($bt['file']), $bt['function'], $bt['line']]));
            } elseif (substr($bt['class'], 0, 18) != 'Google\Cloud\Trace') {
                return implode('/', array_filter(['app', $bt['class'], $bt['function'], $bt['line']]));
            }
        }

        // We couldn't find a suitable backtrace entry - generate a random one
        return uniqid('span');
    }
}
