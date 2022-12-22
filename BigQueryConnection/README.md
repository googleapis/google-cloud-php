# Google BigQuery Connection for PHP

> Idiomatic PHP client for [Google BigQuery Connection](https://cloud.google.com/bigquery/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigquery-connection/v/stable)](https://packagist.org/packages/google/cloud-bigquery-connection) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigquery-connection.svg)](https://packagist.org/packages/google/cloud-bigquery-connection)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-bigquery-connection/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigquery-connection
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

use Google\Cloud\BigQuery\Connection\V1\ConnectionServiceClient;
use Google\Cloud\BigQuery\Connection\V1\Connection;

$projectId = '[PROJECT_ID]';
$locationId = '[LOCATION_ID]';
$connectionId = '[CONNECTION_ID]';

$client = new ConnectionServiceClient();

$parent = $client->locationName($projectId, $locationId);
$connection = new Connection([
    'name' => $client->connectionName($projectId, $locationId, $connectionId),
]);

$connection = $client->createConnection($parent, $connection);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/bigquery/docs).
