# Stackdriver Trace for PHP

> Idiomatic PHP client for [Stackdriver Trace][stackdriver-trace].

[![Latest Stable Version](https://poser.pugx.org/google/cloud-trace/v/stable)](https://packagist.org/packages/google/cloud-trace) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-trace.svg)](https://packagist.org/packages/google/cloud-trace)

* [API documentation][api-docs]

**NOTE:** This repository is part of [Google Cloud PHP][homepage]. Any
support requests, bug reports, or development contributions should be directed to
that project.

A distributed tracing system for Google Cloud Platform that collects latency
data from App Engine applications and displays it in near real time in the
Google Cloud Platform Console.

### Installation

To begin, install the preferred dependency manager for PHP,
[Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-trace
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take
advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md)
for more information on authenticating your client. Once authenticated, you'll
be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Trace\TraceClient;

$traceClient = new TraceClient();

// Create a Trace
$trace = $traceClient->trace();
$span = $trace->span([
    'name' => 'main'
]);
$span->setStartTime();
// some expensive operation
$span->setEndTime();

$trace->setSpans([$span]);
$traceClient->insert($trace);

// List recent Traces
foreach($traceClient->traces() as $trace) {
    var_dump($trace->traceId());
}
```

### Creating a Trace

```php
use Google\Cloud\Trace\TraceClient;

$client = new TraceClient();
$trace = $client->trace();
$span = $trace->span(['name' => 'main']);
$trace->setSpans([$span]);

$client->insert($trace);
```

### Using OpenCensus

We highly recommend using the [OpenCensus][opencensus] project to instrument
your application. OpenCensus is an open source, distributed tracing framework
that maintains integrations with popular frameworks and tools. OpenCensus
provides a data exporter for Stackdriver Trace which uses this library. If you
were using google/cloud-trace <= v0.3.3 or google/cloud  <= 0.46.0, then check
out the [migration guide to OpenCensus][opencensus-migration].

Install with `composer` or add to your `composer.json`.

```sh
$ composer require opencensus/opencensus opencensus/opencensus-exporter-stackdriver
```

`opencensus/opencensus` provides a service-agnostic implementation. Be sure to
also require `opencensus/opencensus-exporter-stackdriver` to enable exporting of
traces to Stackdriver Trace.

```php
use OpenCensus\Trace\Exporter\StackdriverExporter;
use OpenCensus\Trace\Tracer;

Tracer::start(new StackdriverExporter());
```

See the [OpenCensus documentation][opencensus-php] for more configuration
options and features.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation][official-documentation].
2. Take a look at [in-depth usage samples][usage-samples].


[stackdriver-trace]: https://cloud.google.com/trace/
[homepage]: https://cloud.google.com/php/docs/reference
[api-docs]: https://cloud.google.com/php/docs/reference/cloud-trace/latest
[opencensus]: http://opencensus.io
[opencensus-php]: https://github.com/census-instrumentation/opencensus-php
[opencensus-migration]: http://opencensus.io/opencensus-php/migrating-stackdriver-trace
[official-documentation]: https://cloud.google.com/trace/docs/
[usage-samples]: https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/trace/
