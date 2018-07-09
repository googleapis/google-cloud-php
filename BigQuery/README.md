# Google BigQuery for PHP

> Idiomatic PHP client for [Google BigQuery](https://cloud.google.com/bigquery/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigquery/v/stable)](https://packagist.org/packages/google/cloud-bigquery) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigquery.svg)](https://packagist.org/packages/google/cloud-bigquery)

* [API Documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-bigquery/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows you to create, manage, share and query data.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigquery
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\BigQuery\BigQueryClient;

$bigQuery = new BigQueryClient();

// Get an instance of a previously created table.
$dataset = $bigQuery->dataset('my_dataset');
$table = $dataset->table('my_table');

// Begin a job to import data from a CSV file into the table.
$loadJobConfig = $table->load(
    fopen('/data/my_data.csv', 'r')
);
$job = $table->runJob($loadJobConfig);

// Run a query and inspect the results.
$queryJobConfig = 'SELECT * FROM [my_project:my_dataset.my_table]';
$queryResults = $bigQuery->runQuery($queryConfig);

foreach ($queryResults as $row) {
    print_r($row);
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/bigquery/docs).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigquery).
