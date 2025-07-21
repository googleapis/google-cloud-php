# Google Cloud KMS Inventory for PHP

> Idiomatic PHP client for [Google Cloud KMS Inventory](https://cloud.google.com/kms/docs).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-kms-inventory/v/stable)](https://packagist.org/packages/google/cloud-kms-inventory) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-kms-inventory.svg)](https://packagist.org/packages/google/cloud-kms-inventory)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-kms-inventory/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-kms-inventory
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
Google\Cloud\Kms\Inventory\V1\Client\KeyTrackingServiceClient;
Google\Cloud\Kms\Inventory\V1\GetProtectedResourcesSummaryRequest;
Google\Cloud\Kms\Inventory\V1\ProtectedResourcesSummary;

// Create a client.
$keyTrackingServiceClient = new KeyTrackingServiceClient();

// Prepare the request message.
$request = (new GetProtectedResourcesSummaryRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var ProtectedResourcesSummary $response */
    $response = $keyTrackingServiceClient->getProtectedResourcesSummary($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-kms-inventory/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/kms/docs/reference/inventory/rest).
