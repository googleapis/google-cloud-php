# Google Cloud Bigtable for PHP

> Idiomatic PHP client for [Google Cloud Bigtable](https://cloud.google.com/bigtable/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigtable/v/stable)](https://packagist.org/packages/google/cloud-bigtable) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigtable.svg)](https://packagist.org/packages/google/cloud-bigtable)

* [API Documentation](https://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-bigtable/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A high performance NoSQL database service for large analytical and operational workloads.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigtable
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\V2\BigtableClient;

$bigtableClient = new BigtableClient();
$formattedTableName = $bigtableClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');

try {
    $stream = $bigtableClient->readRows($formattedTableName);
    foreach ($stream->readAll() as $element) {
        // doSomethingWith($element);
    }
} finally {
    $bigtableClient->close();
}
```

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/bigtable/docs).
