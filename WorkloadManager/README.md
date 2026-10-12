# Google Cloud Workload Manager for PHP

> Idiomatic PHP client for [Google Cloud Workload Manager](https://docs.cloud.google.com/workload-manager).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-workloadmanager/v/stable)](https://packagist.org/packages/google/cloud-workloadmanager) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-workloadmanager.svg)](https://packagist.org/packages/google/cloud-workloadmanager)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-workloadmanager/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-workloadmanager
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
use Google\ApiCore\ApiException;
use Google\Cloud\WorkloadManager\V1\Client\WorkloadManagerClient;
use Google\Cloud\WorkloadManager\V1\Evaluation;
use Google\Cloud\WorkloadManager\V1\GetEvaluationRequest;

// Create a client.
$workloadManagerClient = new WorkloadManagerClient();

// Prepare the request message.
$request = (new GetEvaluationRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Evaluation $response */
    $response = $workloadManagerClient->getEvaluation($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-workloadmanager/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://docs.cloud.google.com/workload-manager/docs).
