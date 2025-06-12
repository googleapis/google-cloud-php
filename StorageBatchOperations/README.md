# Google Cloud Storage Batch Operations for PHP

> Idiomatic PHP client for [Google Cloud Storage Batch Operations](https://cloud.google.com/storage).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-storagebatchoperations/v/stable)](https://packagist.org/packages/google/cloud-storagebatchoperations) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-storagebatchoperations.svg)](https://packagist.org/packages/google/cloud-storagebatchoperations)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-storagebatchoperations/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-storagebatchoperations
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
Google\Cloud\StorageBatchOperations\V1\Client\StorageBatchOperationsClient;
Google\Cloud\StorageBatchOperations\V1\GetJobRequest;
Google\Cloud\StorageBatchOperations\V1\Job;

// Create a client.
$storageBatchOperationsClient = new StorageBatchOperationsClient();

// Prepare the request message.
$request = (new GetJobRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Job $response */
    $response = $storageBatchOperationsClient->getJob($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-storagebatchoperations/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/storage/docs/batch-operations/overview).
