# Google Cloud Tasks for PHP

> Idiomatic PHP client for Google Cloud Tasks.

[![Latest Stable Version](https://poser.pugx.org/google/cloud-tasks/v/stable)](https://packagist.org/packages/google/cloud-tasks) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-tasks.svg)](https://packagist.org/packages/google/cloud-tasks)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-tasks/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-tasks
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).


### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\Location;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;

// Create a client.
$cloudTasksClient = new CloudTasksClient();

// Prepare the request message.
$request = new GetLocationRequest();

// Call the API and handle any network failures.
try {
    /** @var Location $response */
    $response = $cloudTasksClient->getLocation($request);
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

### Removal of pull queue

The past version (V2beta2) supported pull queues, but we removed the
pull queue support from V2/V2beta3. For more details, read
[our documentation](https://cloud.google.com/tasks/docs/alpha-to-beta#pull)
about the removal.
