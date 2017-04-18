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
 * use Google\Cloud\ServiceBuilder;
 * use Google\Cloud\Trace\Reporter\SyncReporter;
 *
 * $builder = new ServiceBuilder();
 * $reporter = new SyncReporter($builder->trace());
 * RequestTracer::start($reporter);
 * ```
 *
 * In the above example, every request is traced. This is not advised as it will
 * add some latency to each request. We provide a sampling mechanism via the
 * `SamplerInterface`. To add a sampler to your request tracer, provide the `sampler`
 * option to your `start` function.
 *
 * Example:
 * ```
 * use Cache\Adapter\Common\CacheItem;
 * use Cache\Adapter\Apcu\ApcuCachePool;
 * use Google\Cloud\Trace\Sampler\QpsSampler;
 *
 * // a PSR-6 cache implementation
 * $cache = new ApcuCachePool();
 * $sampler = new QpsSampler($cache, CacheItem::class, 0.1);
 * RequestTracer::start($reporter, [
 *   'sampler' => $sampler
 * ]);
 * ```
 *
 * The above uses a query-per-second sampler at 0.1 requests/second. The implementation
 * requires a PSR-6 cache. See {@see Google\Cloud\Trace\Sampler\QpsSampler} for more information.
 * You may provide your own implementation of `SamplerInterface` or use one of the provided.
 * You may provide a configuration array for the sampler instead. See
 * {@see Google\Cloud\Trace\Sampler\SamplerFactory::build()} for builder options.
 *
 * Example using configuration:
 * ```
 * use Cache\Adapter\Common\CacheItem;
 * use Cache\Adapter\Apcu\ApcuCachePool;
 *
 * $cache = new ApcuCachePool();
 * RequestTracer::start([
 *   'sampler' => [
 *     'type' => 'qps',
 *     'rate' => 0.1,
 *     'cache' => $cache,
 *     'cacheItemClass' => CacheItem::class
 *   ]
 * ]);
 * ```
 *
 * To trace code, you can use static functions on the `RequestTracer`. To create a `TraceSpan`
 * for a callable, use the `RequestTracer::inSpan` function. The following code creates 1 Trace
 * with 3 nested TraceSpan instances - the root span, the 'outer' span, and the 'inner' span.
 *
 * Example:
 * ```
 * RequestTracer::start();
 * RequestTracer::inSpan(['name' => 'outer'], function () {
 *   // some code
 *   RequestTracer::inSpan(['name' => 'inner'], function () {
 *     // some code
 *   });
 *   // some code
 * });
 * ```
 *
 * You can also start and finish spans independently throughout your code.
 *
 * Example:
 * ```
 * RequestTracer::startSpan(['name' => 'expensive-operation']);
 * // do expensive operation
 * RequestTracer::endSpan();
 * ```
 *
 * It is recommended that you use the `inSpan` method where you can. An uncaught exception between a
 * `startSpan` and `endSpan` may not correctly close spans.
 */
class RequestTracer
{
    /**
     * @var RequestTracer Singleton instance
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
     * @return RequestTracer
     */
    public static function start(ReporterInterface $reporter, array $options = [])
    {
        $samplerOptions = array_key_exists('sampler', $options) ? $options['sampler'] : [];
        unset($options['sampler']);
        $sampler = SamplerFactory::build($samplerOptions);

        return self::$instance = new RequestHandler($reporter, $sampler, $options);
    }

    /**
     * Instrument a callable by creating a TraceSpan that manages the startTime and endTime.
     * If an exception is thrown while executing the callable, the exception will be caught,
     * the span will be closed, and the exception will be re-thrown.
     *
     * Example:
     * ```
     * RequestTracer::inSpan(['name' => 'expensive-operation'], function () {
     *   // do something expensive
     * });
     *
     * function fib($n) {
     *   // do something expensive
     * }
     * $number = RequestTracer::inSpan(['name' => 'fibonacci'], 'fib', [10]);
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
     * RequestTracer::startSpan(['name'= > 'expensive-operation']);
     * // do something expensive
     * RequestTracer::endSpan();
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
}
