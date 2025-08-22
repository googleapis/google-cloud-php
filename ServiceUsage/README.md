# Google Cloud Service Usage for PHP

> Idiomatic PHP client for [Google Cloud Service Usage](https://cloud.google.com/service-usage).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-service-usage/v/stable)](https://packagist.org/packages/google/cloud-service-usage) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-service-usage.svg)](https://packagist.org/packages/google/cloud-service-usage)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-service-usage/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-service-usage
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceUsage\V1\Client\ServiceUsageClient;
use Google\Cloud\ServiceUsage\V1\GetServiceRequest;
use Google\Cloud\ServiceUsage\V1\Service;

// Create a client.
$serviceUsageClient = new ServiceUsageClient();

// Prepare the request message.
$request = new GetServiceRequest();

// Call the API and handle any network failures.
try {
    /** @var Service $response */
    $response = $serviceUsageClient->getService($request);
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

1. Understand the [official documentation](https://cloud.google.com/service-usage/docs).
