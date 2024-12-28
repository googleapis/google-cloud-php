# Google Cloud Storage Control for PHP

> Idiomatic PHP client for [Google Cloud Storage Control](https://cloud.google.com/storage).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-storage-control/v/stable)](https://packagist.org/packages/google/cloud-storage-control) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-storage-control.svg)](https://packagist.org/packages/google/cloud-storage-control)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-storage-control/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-storage-control
```

> Browse the complete list of [Google Cloud APIs](https://cloud.google.com/php/docs/reference)
> for PHP

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
Google\ApiCore\ApiException;
Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
Google\Cloud\Storage\Control\V2\Folder;
Google\Cloud\Storage\Control\V2\GetFolderRequest;

// Create a client.
$storageControlClient = new StorageControlClient();

// Prepare the request message.
$request = (new GetFolderRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Folder $response */
    $response = $storageControlClient->getFolder($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-storage-control/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/storage/docs/overview).
