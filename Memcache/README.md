# Memorystore for Memcached for PHP

> Idiomatic PHP client for [Memorystore for Memcached](https://cloud.google.com/memorystore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-memcache/v/stable)](https://packagist.org/packages/google/cloud-memcache) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-memcache.svg)](https://packagist.org/packages/google/cloud-memcache)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-memcache/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-memcache
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

use Google\Cloud\Memcache\V1\CloudMemcacheClient;

$client = new CloudMemcacheClient();
$location = CloudMemcacheClient::locationName('[MY_PROJECT_ID]', '-');

foreach ($client->listInstances($location) as $response) {
    foreach ($response->getResources() as $instance) {
        printf('Discovered instance: %s', $instance->getDisplayName());
    }
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/memorystore/docs/memcached/).
