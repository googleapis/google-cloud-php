# Google PHP Stackdriver Trace

> Idiomatic PHP client for [Stackdriver Trace][stackdriver-trace].

[![Latest Stable Version](https://poser.pugx.org/google/cloud-trace/v/stable)](https://packagist.org/packages/google/cloud-trace) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-trace.svg)](https://packagist.org/packages/google/cloud-trace)

* [Homepage][homepage]
* [API documentation][api-docs]

**NOTE:** This repository is part of [Google Cloud PHP][github-home]. Any
support requests, bug reports, or development contributions should be directed to
that project.

Use of the included generated clients requires installation of the gRPC PHP extension. For instructions, [see here](https://cloud.google.com/php/grpc).

NOTE: In addition to the gRPC extension, we recommend installing the protobuf extension for improved performance. For installation instructions, [see here](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library).

## Installation

Install with `composer` or add to your `composer.json`.

```
$ composer require google/cloud-trace
```

Use of the included generated clients requires installation of the gRPC PHP
extension. For instructions, [see here](https://cloud.google.com/php/grpc).

NOTE: In addition to the gRPC extension, we recommend installing the protobuf
extension for improved performance. For installation instructions,
[see here](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library).

## Usage

This library contains code to interact with the Stackdriver Trace V2 API.

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

```
$ composer require opencensus/opencensus
```

Use the provided `StackdriverExporter` when configuring your tracer.

```php
use OpenCensus\Trace\Exporter\StackdriverExporter;
use OpenCensus\Trace\Tracer;

Tracer::start(new StackdriverExporter());
```

See the [OpenCensus documentation][opencensus-php] for more configuration
options and features.

[stackdriver-trace]: https://cloud.google.com/trace/
[homepage]: http://googlecloudplatform.github.io/google-cloud-php
[api-docs]: http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-trace/latest/trace/traceclient
[github-home]: https://github.com/googlecloudplatform/google-cloud-php
[opencensus]: http://opencensus.io
[opencensus-php]: https://github.com/census-instrumentation/opencensus-php
[opencensus-migration]: http://opencensus.io/opencensus-php/migrating-stackdriver-trace
