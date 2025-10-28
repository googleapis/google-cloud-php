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

Now install this component:

```sh
$ composer require google/cloud-trace
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
use Google\ApiCore\ApiException;
use Google\Cloud\Trace\V2\Client\TraceServiceClient;
use Google\Cloud\Trace\V2\Span;
use Google\Cloud\Trace\V2\TruncatableString;
use Google\Protobuf\Timestamp;

// Create a client.
$traceServiceClient = new TraceServiceClient();

// Prepare the request message.
$displayName = new TruncatableString();
$startTime = new Timestamp();
$endTime = new Timestamp();
$request = (new Span())
    ->setName($name)
    ->setSpanId($spanId)
    ->setDisplayName($displayName)
    ->setStartTime($startTime)
    ->setEndTime($endTime);

// Call the API and handle any network failures.
try {
    /** @var Span $response */
    $response = $traceServiceClient->createSpan($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [OpenCensus documentation][opencensus-php] for more configuration
options and features.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

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
