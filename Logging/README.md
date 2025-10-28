# Stackdriver Logging for PHP

> Idiomatic PHP client for [Stackdriver Logging](https://cloud.google.com/logging/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-logging/v/stable)](https://packagist.org/packages/google/cloud-logging) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-logging.svg)](https://packagist.org/packages/google/cloud-logging)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-logging/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows you to store, search, analyze, monitor, and alert on log data and events from Google Cloud Platform and Amazon
Web Services.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-logging
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\Client\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\GetBucketRequest;
use Google\Cloud\Logging\V2\LogBucket;

// Create a client.
$configServiceV2Client = new ConfigServiceV2Client();

// Prepare the request message.
$request = (new GetBucketRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var LogBucket $response */
    $response = $configServiceV2Client->getBucket($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/logging/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/logging/).
