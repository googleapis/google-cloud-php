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

namespace Google\Cloud\Trace\Tracer;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;

/**
 * This implementation of the TracerInterface is the null object implementation.
 * All methods are no ops. This tracer should be used if tracing is disabled.
 */
class ExtensionTracer implements TracerInterface
{
    use ArrayTrait;

    /**
     * @var TraceContext The current context of this tracer.
     */
    private $context;

    /**
     * Create a new ContextTracer
     *
     * @param TraceContext $context [optional] The TraceContext to begin with. If none
     *      provided, a fresh TraceContext will be generated.
     */
    public function __construct(TraceContext $context = null)
    {
        $context = $context ?: new TraceContext();
        stackdriver_trace_set_context($context->traceId(), (int) $context->spanId());
    }

    /**
     * Instrument a callable by creating a TraceSpan
     *
     * @param array $spanOptions Options for the span.
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()}
     * @param callable $callable The callable to inSpan.
     * @param array $arguments [optional] Arguments for the callable.
     * @return mixed The result of the callable
     */
    public function inSpan(array $spanOptions, callable $callable, array $arguments = [])
    {
        $name = $this->pluck('name', $spanOptions, false) ?: $this->generateSpanName();
        stackdriver_trace_begin($name, $spanOptions);
        try {
            return call_user_func_array($callable, $arguments);
        } finally {
            stackdriver_trace_finish();
        }
    }

    /**
     * Start a new Span. The start time is already set to the current time.
     *
     * @param array $spanOptions [optional] Options for the span.
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()}
     */
    public function startSpan(array $spanOptions)
    {
        $name = $this->pluck('name', $spanOptions, false) ?: $this->generateSpanName();
        stackdriver_trace_begin($name, $spanOptions);
    }

    /**
     * Finish the current context's Span.
     */
    public function endSpan()
    {
        return stackdriver_trace_finish();
    }

    /**
     * Return the current context.
     *
     * @return TraceContext
     */
    public function context()
    {
        $context = stackdriver_trace_context() + [
            'spanId' => null
        ];
        return new TraceContext(
            $context['traceId'],
            $context['spanId']
        );
    }

    /**
     * Return the spans collected.
     *
     * @return TraceSpan[]
     */
    public function spans()
    {
        return array_map(function ($span) {
            return new TraceSpan($span);
        }, stackdriver_trace_list());
    }

    /**
     * Add a label to the primary TraceSpan
     *
     * @param string $label
     * @param string $value
     */
    public function addLabel($label, $value)
    {
    }

    /**
     * Whether or not this tracer is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return true;
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
