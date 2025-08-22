# Google Cloud Redis for PHP

> Idiomatic PHP client for [Google Cloud Redis](https://cloud.google.com/memorystore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-redis/v/stable)](https://packagist.org/packages/google/cloud-redis) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-redis.svg)](https://packagist.org/packages/google/cloud-redis)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-redis/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully managed Redis service for the Google Cloud Platform. Applications running on Google Cloud Platform can achieve
extreme performance by leveraging the highly scalable, available, secure Redis service without the burden of managing complex Redis deployments.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-redis
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Redis\V1\Client\CloudRedisClient;
use Google\Cloud\Redis\V1\GetInstanceRequest;
use Google\Cloud\Redis\V1\Instance;

// Create a client.
$cloudRedisClient = new CloudRedisClient();

// Prepare the request message.
$request = (new GetInstanceRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Instance $response */
    $response = $cloudRedisClient->getInstance($request);
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

Take a look at and understand the [official documentation](https://cloud.google.com/memorystore/docs/).
