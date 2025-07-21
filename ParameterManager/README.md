# Google Cloud Parameter Manager for PHP

> Idiomatic PHP client for [Google Cloud Parameter Manager](https://cloud.google.com/secret-manager/parameter-manager/docs/overview).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-parametermanager/v/stable)](https://packagist.org/packages/google/cloud-parametermanager) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-parametermanager.svg)](https://packagist.org/packages/google/cloud-parametermanager)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-parametermanager/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-parametermanager
```

> Browse the complete list of [Google Cloud APIs](https://cloud.google.com/php/docs/reference)
> for PHP

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits
offered by gRPC (such as streaming methods) please see our
[gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
Google\ApiCore\ApiException;
Google\Cloud\Location\GetLocationRequest;
Google\Cloud\Location\Location;
Google\Cloud\ParameterManager\V1\Client\ParameterManagerClient;

// Create a client.
$parameterManagerClient = new ParameterManagerClient();

// Prepare the request message.
$request = new GetLocationRequest();

// Call the API and handle any network failures.
try {
    /** @var Location $response */
    $response = $parameterManagerClient->getLocation($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-parametermanager/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/secret-manager/parameter-manager/docs/overview).
