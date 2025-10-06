# Google Cloud Life Sciences for PHP

> Idiomatic PHP client for [Google Cloud Life Sciences](https://cloud.google.com/life-sciences).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-life-sciences/v/stable)](https://packagist.org/packages/google/cloud-life-sciences) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-life-sciences.svg)](https://packagist.org/packages/google/cloud-life-sciences)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-life-sciences/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-life-sciences
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\LifeSciences\V2beta\Client\WorkflowsServiceV2BetaClient;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\Location;

// Create a client.
$workflowsServiceV2BetaClient = new WorkflowsServiceV2BetaClient();

// Prepare the request message.
$request = new GetLocationRequest();

// Call the API and handle any network failures.
try {
    /** @var Location $response */
    $response = $workflowsServiceV2BetaClient->getLocation($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/life-sciences/docs).
