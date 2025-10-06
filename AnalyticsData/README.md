# Google Analytics Data for PHP

> Idiomatic PHP client for [Google Analytics Data](https://analytics.google.com/analytics/web/provision/#/provision).

[![Latest Stable Version](https://poser.pugx.org/google/analytics-data/v/stable)](https://packagist.org/packages/google/analytics-data) [![Packagist](https://img.shields.io/packagist/dm/google/analytics-data.svg)](https://packagist.org/packages/google/analytics-data)

* [API documentation](https://cloud.google.com/php/docs/reference/analytics-data/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/analytics-data
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\Analytics\Data\V1beta\AudienceExport;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\GetAudienceExportRequest;
use Google\ApiCore\ApiException;

// Create a client.
$betaAnalyticsDataClient = new BetaAnalyticsDataClient();

// Prepare the request message.
$request = (new GetAudienceExportRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var AudienceExport $response */
    $response = $betaAnalyticsDataClient->getAudienceExport($request);
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

1. Understand the [official documentation](https://developers.google.com/analytics/devguides/reporting/data/v1).
