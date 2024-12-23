# Google Cloud App Hub for PHP

> Idiomatic PHP client for [Google Cloud App Hub](https://cloud.google.com/app-hub).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-apphub/v/stable)](https://packagist.org/packages/google/cloud-apphub) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-apphub.svg)](https://packagist.org/packages/google/cloud-apphub)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-apphub/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-apphub
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
Google\Cloud\AppHub\V1\Application;
Google\Cloud\AppHub\V1\Client\AppHubClient;
Google\Cloud\AppHub\V1\GetApplicationRequest;

// Create a client.
$appHubClient = new AppHubClient();

// Prepare the request message.
$request = (new GetApplicationRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Application $response */
    $response = $appHubClient->getApplication($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-apphub/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/app-hub/docs/overview).
