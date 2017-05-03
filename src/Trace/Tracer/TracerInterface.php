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

use Google\Cloud\Trace\TraceContext;
use Google\Cloud\Trace\TraceSpan;

/**
 * This interface allows you to use the null object pattern for your tracer.
 * Whenever you want to instrument your code, you don't need to check if
 * the configured tracer is null or a real tracer.
 */
interface TracerInterface
{
    /**
     * Instrument a callable by creating a TraceSpan
     *
     * @param array $spanOptions Options for the span.
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()}
     * @param callable $callable The callable to inSpan.
     * @param array $arguments [optional] Arguments for the callable.
     * @return mixed The result of the callable
     */
    public function inSpan(array $spanOptions, callable $callable, array $arguments = []);

    /**
     * Start a new Span. The start time is already set to the current time.
     *
     * @param  array  $spanOptions [description]
     */
    public function startSpan(array $spanOptions);

    /**
     * Finish the current context's Span.
     */
    public function endSpan();

    /**
     * Return the current context.
     *
     * @return TraceContext
     */
    public function context();

    /**
     * Return the spans collected.
     *
     * @return TraceSpan[]
     */
    public function spans();

    /**
     * Add a label to the current TraceSpan
     *
     * @param string $label
     * @param string $value
     */
    public function addLabel($label, $value);

    /**
     * Add a label to the primary TraceSpan
     *
     * @param string $label
     * @param string $value
     */
    public function addRootLabel($label, $value);

    /**
     * Whether or not this tracer is enabled.
     *
     * @return bool
     */
    public function enabled();
}
