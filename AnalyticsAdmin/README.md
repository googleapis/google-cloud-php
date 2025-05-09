# Google Analytics Admin for PHP

> Idiomatic PHP client for [Google Analytics Admin](https://developers.google.com/analytics/).

[![Latest Stable Version](https://poser.pugx.org/google/analytics-admin/v/stable)](https://packagist.org/packages/google/analytics-admin) [![Packagist](https://img.shields.io/packagist/dm/google/analytics-admin.svg)](https://packagist.org/packages/google/analytics-admin)

* [API documentation](https://cloud.google.com/php/docs/reference/analytics-admin/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/analytics-admin
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Analytics\Admin\V1beta\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1beta\ListAccountsRequest;

$client = new AnalyticsAdminServiceClient();

$request = new ListAccountsRequest();
$accounts = $client->listAccounts($request);

foreach ($accounts as $account) {
    print 'Found account: ' . $account->getName() . PHP_EOL;
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

1. Understand the [official documentation](https://developers.google.com/analytics/).
