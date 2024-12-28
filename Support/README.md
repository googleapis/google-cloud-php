# Google Cloud Support for PHP

> Idiomatic PHP client for [Google Cloud Support](https://cloud.google.com/support).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-support/v/stable)](https://packagist.org/packages/google/cloud-support) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-support.svg)](https://packagist.org/packages/google/cloud-support)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-support/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-support
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
Google\Cloud\Support\V2\Client\CaseServiceClient;
Google\Cloud\Support\V2\GetCaseRequest;
Google\Cloud\Support\V2\PBCase;

// Create a client.
$caseServiceClient = new CaseServiceClient();

// Prepare the request message.
$request = (new GetCaseRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var PBCase $response */
    $response = $caseServiceClient->getCase($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](samples/) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/support/docs/reference/support-api).
