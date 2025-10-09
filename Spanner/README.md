# Google Cloud Spanner for PHP

> Idiomatic PHP client for [Cloud Spanner](https://cloud.google.com/spanner/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-spanner/v/stable)](https://packagist.org/packages/google/cloud-spanner) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-spanner.svg)](https://packagist.org/packages/google/cloud-spanner)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-spanner/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully managed, mission-critical, relational database service that offers transactional consistency at global scale,
schemas, SQL (ANSI 2011 with extensions), and automatic, synchronous replication for high availability.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-spanner
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\GetSessionRequest;
use Google\Cloud\Spanner\V1\Session;

// Create a client.
$spannerClient = new SpannerClient();

// Prepare the request message.
$request = (new GetSessionRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Session $response */
    $response = $spannerClient->getSession($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

By using a cache implementation like `SysVCacheItemPool`, you can share the cached sessions among multiple processes, so that for example, you can warmup the session upon the server startup, then all the other PHP processes will benefit from the warmed up sessions.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/spanner/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/spanner/).
