# Google PHP Stackdriver Trace

> Idiomatic PHP client for [Stackdriver Trace](https://cloud.google.com/trace/).

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-storage/latest/trace/traceclient)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Installation

1. Install with `composer` or add to your `composer.json`.

```
$ composer require google/cloud-trace
```

2. Include and start the library as the first action in your application:

```php
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\RequestTracer;

$trace = new TraceClient();
$reporter = $trace->reporter();
RequestTracer::start($reporter);
```

## Customizing

### Reporting Traces

The above sample uses the `AsyncReporter` to report trace results to the Stackdriver servers.
If you are using the experimental
[google-cloud-batch daemon](https://github.com/GoogleCloudPlatform/google-cloud-php-core/blob/master/Batch/BatchDaemon.php)
and have set the `IS_BATCH_DAEMON_RUNNING=true` environment variable, then the reporting of the trace will happen
asynchronously. If not, the reporting will happen at the end of the request and can add some latency to your request.

For testing/development, we also provide an `EchoReporter`, `FileReporter` and `LoggerReporter`.

If you would like to provide your own reporter, create a class that implements `ReporterInterface`.

### Sampling Rate

By default we attempt to trace all requests. This is not ideal as a little bit of
latency and require more memory for requests that are traced. To trace a sampling
of requests, configure a sampler.

The preferred sampler is the `QpsSampler` (Queries Per Second). This sampler implementation
requires a PSR-6 cache implementation to function.

```php
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Reporter\SyncReporter;
use Google\Cloud\Trace\Sampler\QpsSampler;

$trace = new TraceClient();
$reporter = new SyncReporter($trace);
$cache = new SomeCacheImplementation();
$sampler = new QpsSampler($cache, ['rate' => 0.1]); // sample 0.1 requests per second
RequestTracer::start($reporter, ['sampler' => $sampler]);
```

Please note: While required for the `QpsSampler`, a PSR-6 implementation is
not included in this library. It will be necessary to include a separate
dependency to fulfill this requirement. For PSR-6 implementations, please see the
[Packagist PHP Package Repository](https://packagist.org/providers/psr/cache-implementation).
If the APCu extension is available (available on Google AppEngine Flexible Environment)
and you include the cache/apcu-adapter composer package, we will set up the cache for you.

You can also choose to use the `RandomSampler` which simply samples a flat
percentage of requests.

```php
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Reporter\SyncReporter;
use Google\Cloud\Trace\Sampler\RandomSampler;

$trace = new TraceClient();
$reporter = new SyncReporter($trace);
$sampler = new RandomSampler(0.1); // sample 10% of requests
RequestTracer::start($reporter, ['sampler' => $sampler]);
```

If you would like to provide your own sampler, create a class that implements `SamplerInterface`.

## Tracing Code Blocks

To add tracing to a block of code, you can use the closure/callable form or explicitly open
and close spans yourself.

### Closure/Callable (preferred)

```php
$pi = RequestTracer::inSpan(['name' => 'expensive-operation'], function() {
    // some expensive operation
    return calculatePi(1000);
});

$pi = RequestTracer::inSpan(['name' => 'expensive-operation'], 'calculatePi', [1000]);
```

### Explicit Span Management

```php
RequestTracer::startSpan(['name' => 'expensive-operation']);
try {
    $pi = calculatePi(1000);
} finally {
    // Make sure we close the span to avoid mismatched span boundaries
    RequestTracer::endSpan();
}
```
