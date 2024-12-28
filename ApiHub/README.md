# Google Cloud Api Hub for PHP

> Idiomatic PHP client for [Google Cloud Api Hub](https://cloud.google.com/apigee).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-apihub/v/stable)](https://packagist.org/packages/google/cloud-apihub) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-apihub.svg)](https://packagist.org/packages/google/cloud-apihub)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-apihub/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-apihub
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
Google\Cloud\ApiHub\V1\Api;
Google\Cloud\ApiHub\V1\Client\ApiHubClient;
Google\Cloud\ApiHub\V1\GetApiRequest;

// Create a client.
$apiHubClient = new ApiHubClient();

// Prepare the request message.
$request = (new GetApiRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Api $response */
    $response = $apiHubClient->getApi($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-apihub/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/apigee/docs/apihub/what-is-api-hub).
