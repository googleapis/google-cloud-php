# Google BigQuery Storage for PHP

> Idiomatic PHP client for [Google BigQuery Storage](https://cloud.google.com/bigquery).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigquery-storage/v/stable)](https://packagist.org/packages/google/cloud-bigquery-storage) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigquerystorage.svg)](https://packagist.org/packages/google/cloud-bigquerystorage)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-bigquery-storage/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigquery-storage
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

use Google\Cloud\BigQuery\Storage\V1\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\DataFormat;
use Google\Cloud\BigQuery\Storage\V1\ReadSession;
use Google\Cloud\BigQuery\Storage\V1\ReadSession\TableReadOptions;

$client = new BigQueryReadClient();

$project = sprintf(
    'projects/%s',
    '[MY_PROJECT_ID]'
);
$table = sprintf(
    'projects/%s/datasets/%s/tables/%s',
    'bigquery-public-data',
    'usa_names',
    'usa_1910_current'
);
$readOptions = (new TableReadOptions())
    ->setRowRestriction('state = "WA"');
$readSession = (new ReadSession())
    ->setTable($table)
    ->setDataFormat(DataFormat::AVRO)
    ->setReadOptions($readOptions);
$session = $client->createReadSession([
    'parent' => $project,
    'readSession' => $readSession,
    'maxStreamCount' => 1
]);

$stream = $client->readRows([
    'readStream' => $session->getStreams()[0]->getName()
]);

foreach ($stream->readAll() as $response) {
    printf(
        'Discovered %s rows in response.' . PHP_EOL,
        $response->getRowCount()
    );
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/bigquery/docs/reference/storage).
