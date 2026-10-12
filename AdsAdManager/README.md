# Google Ads Ad Manager for PHP

> Idiomatic PHP client for [Google Ads Ad Manager](https://developers.google.com/ad-manager).

[![Latest Stable Version](https://poser.pugx.org/googleads/ad-manager/v/stable)](https://packagist.org/packages/googleads/ad-manager) [![Packagist](https://img.shields.io/packagist/dm/googleads/ad-manager.svg)](https://packagist.org/packages/googleads/ad-manager)

* [API documentation](https://cloud.google.com/php/docs/reference/googleads/ad-manager/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require googleads/ad-manager
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
use Google\Ads\AdManager\V1\AdBreak;
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\GetAdBreakRequest;
use Google\ApiCore\ApiException;

// Create a client.
$adBreakServiceClient = new AdBreakServiceClient();

// Prepare the request message.
$request = (new GetAdBreakRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var AdBreak $response */
    $response = $adBreakServiceClient->getAdBreak($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/php-ads-ad-manager/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://developers.google.com/ad-manager/api/beta).
