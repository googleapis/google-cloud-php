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

use Google\Cloud\Trace\Sampler\SamplerFactory;
use Google\Cloud\Trace\Sampler\SamplerInterface;
use Google\Cloud\Trace\Reporter\ReporterInterface;

/**
 * This class provides static functions to give you access to the current
 * request's singleton tracer. You should use this class to instrument your code.
 * The first step, is to configure and start your `RequestTracer`. Calling `start`
 * will collect trace data during your request and report the results at the
 * request using the provided reporter.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\RequestTracer;
 * use Google\Cloud\Trace\TraceClient;
 * use Google\Cloud\Trace\Reporter\SyncReporter;
 *
 * $trace = new TraceClient();
 * $reporter = new SyncReporter($trace);
 * RequestTracer::start($reporter);
 * ```
 *
 * In the above example, every request is traced. This is not advised as it will
 * add some latency to each request. We provide a sampling mechanism via the
 * {@see Google\Cloud\Trace\Sampler\SamplerInterface}. To add sampling to your
 * request tracer, provide the "sampler" option:
 *
 * ```
 * // $cache is a PSR-6 cache implementation
 * $sampler = new QpsSampler($cache, ['rate' => 0.1]);
 * RequestTracer::start($reporter, [
 *     'sampler' => $sampler
 * ]);
 * ```
 *
 * The above uses a query-per-second sampler at 0.1 requests/second. The implementation
 * requires a PSR-6 cache. See {@see Google\Cloud\Trace\Sampler\QpsSampler} for more information.
 * You may provide your own implementation of {@see Google\Cloud\Trace\Sampler\SamplerInterface}
 * or use one of the provided. You may provide a configuration array for the sampler instead. See
 * {@see Google\Cloud\Trace\Sampler\SamplerFactory::build()} for builder options:
 *
 * ```
 * // $cache is a PSR-6 cache implementation
 * RequestTracer::start($reporter, [
 *     'sampler' => [
 *         'type' => 'qps',
 *         'rate' => 0.1,
 *         'cache' => $cache
 *     ]
 * ]);
 * ```
 *
 * To trace code, you can use static {@see Google\Cloud\Trace\RequestTracer::inSpan()} helper function:
 *
 * ```
 * RequestTracer::start($reporter);
 * RequestTracer::inSpan(['name' => 'outer'], function () {
 *     // some code
 *     RequestTracer::inSpan(['name' => 'inner'], function () {
 *         // some code
 *     });
 *     // some code
 * });
 * ```
 *
 * You can also start and finish spans independently throughout your code.
 *
 * Explicitly tracing spans:
 * ```
 * RequestTracer::start($reporter);
 * RequestTracer::startSpan(['name' => 'expensive-operation']);
 * try {
 *     // do expensive operation
 * } catch (\Exception $e) {
 *     RequestTracer::endSpan();
 * }
 * ```
 *
 * It is recommended that you use the {@see Google\Cloud\Trace\RequestTracer::inSpan()}
 * method where you can. An uncaught exception between {@see Google\Cloud\Trace\RequestTracer::startSpan()}
 * and {@see Google\Cloud\Trace\RequestTracer::endSpan()} may not correctly close spans.
 */
class RequestTracer
{
    /**
     * @var RequestHandler Singleton instance
     */
    private static $instance;

    /**
     * Start a new trace session for this request. You should call this as early as
     * possible for the most accurate results.
     *
     * @param ReporterInterface $reporter
     * @param array $options {
     *      Configuration options. See
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()} for the other available options.
     *
     *      @type SamplerInterface|array $sampler Sampler or sampler factory build arguments. See
     *          {@see Google\Cloud\Trace\Sampler\SamplerFactory::build()} for the available options.
     *      @type array $headers Optional array of headers to use in place of $_SERVER
     * }
     * @return RequestHandler
     */
    public static function start(ReporterInterface $reporter, array $options = [])
    {
        $samplerOptions = array_key_exists('sampler', $options) ? $options['sampler'] : [];
        unset($options['sampler']);

        $sampler = ($samplerOptions instanceof SamplerInterface)
            ? $samplerOptions
            : SamplerFactory::build($samplerOptions);

        return self::$instance = new RequestHandler($reporter, $sampler, $options);
    }

    /**
     * Instrument a callable by creating a TraceSpan that manages the startTime and endTime.
     * If an exception is thrown while executing the callable, the exception will be caught,
     * the span will be closed, and the exception will be re-thrown.
     *
     * Example:
     * ```
     * // Instrumenting code as a closure
     * RequestTracer::inSpan(['name' => 'some-closure'], function () {
     *   // do something expensive
     * });
     * ```
     *
     * ```
     * // Instrumenting code as a callable (parameters optional)
     * function fib($n) {
     *   // do something expensive
     * }
     * $number = RequestTracer::inSpan(['name' => 'some-callable'], 'fib', [10]);
     * ```
     *
     * @param array $spanOptions Options for the span.
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()}
     * @param  callable $callable The callable to inSpan.
     * @return mixed Returns whatever the callable returns
     */
    public static function inSpan(array $spanOptions, callable $callable, array $arguments = [])
    {
        return self::$instance->inSpan($spanOptions, $callable, $arguments);
    }

    /**
     * Explicitly start a new TraceSpan. You will need to manage finishing the TraceSpan,
     * including handling any thrown exceptions.
     *
     * Example:
     * ```
     * RequestTracer::startSpan(['name' => 'expensive-operation']);
     * try {
     *     // do something expensive
     * } catch (\Exception $e) {
     *     RequestTracer::endSpan();
     * }
     * ```
     *
     * @param array $spanOptions [optional] Options for the span.
     *      {@see Google\Cloud\Trace\TraceSpan::__construct()}
     */
    public static function startSpan(array $spanOptions = [])
    {
        return self::$instance->startSpan($spanOptions);
    }

    /**
    * Explicitly finish the current context (TraceSpan).
     */
    public static function endSpan()
    {
        return self::$instance->endSpan();
    }

    /**
     * Return the current context
     *
     * @return TraceContext
     */
    public static function context()
    {
        return self::$instance->context();
    }

    /**
     * Returns the RequestHandler instance
     *
     * @return RequestHandler
     */
    public static function instance()
    {
        return self::$instance;
    }
}
