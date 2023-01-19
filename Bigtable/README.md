# Google Cloud Bigtable for PHP

> Idiomatic PHP client for [Google Cloud Bigtable](https://cloud.google.com/bigtable/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigtable/v/stable)](https://packagist.org/packages/google/cloud-bigtable) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigtable.svg)](https://packagist.org/packages/google/cloud-bigtable)

* [API Documentation](https://cloud.google.com/php/docs/reference/cloud-bigtable/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
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

### Notable Client Differences

The handwritten client offered by this package differs from the others in `google-cloud-php` in that it more directly wraps our generated clients.
This means some of the idioms and configuration options you are used to may differ slightly. The most notable differences are outlined below:

- A key file is now provided through the `credentials` configuration option as opposed to either `keyFile` or `keyFilePath`.
- There is now more granular control over retry logic. Please see [the `bigtable_client_config.json` file](https://github.com/googleapis/google-cloud-php/blob/main/Bigtable/src/V2/resources/bigtable_client_config.json)
  for an example of the configuration which can be passed into the client at construction time.
- Exceptions triggered at the network level utilize the base class `Google\ApiCore\ApiException` as opposed to `Google\Cloud\Core\ServiceException`.
- The `authHttpHandler` and `httpHandler` client configuration options are now provided through `$credentialsConfig['authHttpHandler']`
  and `$transportConfig['httpHandler']`, respectively. Additionally, please note the `httpHandler` should now return an implementation of [Guzzle's `PromiseInterface`](https://github.com/guzzle/promises/blob/master/src/PromiseInterface.php).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

When going through the authentication guide, please take note that the handwritten client for this package will more closely follow the conventions
outlined for the generated clients.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\BigtableClient;

$bigtable = new BigtableClient();
$table = $bigtable->table('my-instance', 'my-table');
$rows = $table->readRows();

foreach ($rows as $row) {
    print_r($row) . PHP_EOL;
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/bigtable/docs).
