# Cloud Scheduler for PHP

> Idiomatic PHP client for [Cloud Scheduler](https://cloud.google.com/scheduler).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-scheduler/v/stable)](https://packagist.org/packages/google/cloud-scheduler) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-scheduler.svg)](https://packagist.org/packages/google/cloud-scheduler)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-scheduler/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-scheduler
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Scheduler\V1\Client\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1\GetJobRequest;
use Google\Cloud\Scheduler\V1\Job;

// Create a client.
$cloudSchedulerClient = new CloudSchedulerClient();

// Prepare the request message.
$request = (new GetJobRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Job $response */
    $response = $cloudSchedulerClient->getJob($request);
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

1. Understand the [official documentation](https://cloud.google.com/scheduler/docs).
