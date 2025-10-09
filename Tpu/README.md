# Google Cloud Tpu for PHP

> Idiomatic PHP client for [Google Cloud Tpu](https://cloud.google.com/tpu).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-tpu/v/stable)](https://packagist.org/packages/google/cloud-tpu) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-tpu.svg)](https://packagist.org/packages/google/cloud-tpu)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-tpu/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-tpu
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Tpu\V2\AcceleratorType;
use Google\Cloud\Tpu\V2\Client\TpuClient;
use Google\Cloud\Tpu\V2\GetAcceleratorTypeRequest;

// Create a client.
$tpuClient = new TpuClient();

// Prepare the request message.
$request = (new GetAcceleratorTypeRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var AcceleratorType $response */
    $response = $tpuClient->getAcceleratorType($request);
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

1. Understand the [official documentation](https://cloud.google.com/tpu/docs).
