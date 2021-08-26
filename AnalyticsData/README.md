# Google Analytics Data for PHP

> Idiomatic PHP client for [Google Analytics Data](https://analytics.google.com/analytics/web/provision/#/provision).

[![Latest Stable Version](https://poser.pugx.org/google/analytics-data/v/stable)](https://packagist.org/packages/google/analytics-data) [![Packagist](https://img.shields.io/packagist/dm/google/analytics-data.svg)](https://packagist.org/packages/google/analytics-data)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/analytics-data/latest/analyticsdata/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/analytics-data
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

$client = new BetaAnalyticsDataClient();

$response = $client->runReport([
    'property' => 'properties/[YOUR_PROPERTY_ID]'
]);

foreach ($response->getRows() as $row) {
    foreach ($row->getDimensionValues() as $dimensionValue) {
        print 'Dimension Value: ' . $dimensionValue->getValue() . PHP_EOL;
    }
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://developers.google.com/analytics/devguides/reporting/data/v1).
