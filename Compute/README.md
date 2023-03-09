# Google Compute for PHP

> Idiomatic PHP client for [Google Compute](https://cloud.google.com/compute/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-compute/v/stable)](https://packagist.org/packages/google/cloud-compute) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-compute.svg)](https://packagist.org/packages/google/cloud-compute)

* [API Documentation](https://cloud.google.com/php/docs/reference/cloud-compute/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows you to create, manage, share and query data.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-compute
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Compute\V1\InstancesClient;

$instances = new InstancesClient();
foreach ($instances->list_('[MY_PROJECT_ID]', 'us-west1') as $instance) {
    print($instance->getName() . PHP_EOL);
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/compute/docs).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/compute).
