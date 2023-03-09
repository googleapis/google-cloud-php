# Google Cloud Billing for PHP

> Idiomatic PHP client for [Google Cloud Billing](https://cloud.google.com/billing).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-billing/v/stable)](https://packagist.org/packages/google/cloud-billing) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-billing.svg)](https://packagist.org/packages/google/cloud-billing)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-billing/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-billing
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Billing\V1\CloudBillingClient;

$client = new CloudBillingClient();
$accounts = $client->listBillingAccounts();

foreach ($accounts as $account) {
    print('Billing account: ' . $account->getName() . PHP_EOL);
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/billing/docs).
