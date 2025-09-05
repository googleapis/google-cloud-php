# Google Cloud BigQuery Migration for PHP

> Idiomatic PHP client for [Google Cloud BigQuery Migration for PHP](https://cloud.google.com/bigquery/docs/migration-intro).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigquery-migration/v/stable)](https://packagist.org/packages/google/cloud-bigquery-migration) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigquery-migration.svg)](https://packagist.org/packages/google/cloud-bigquery-migration)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-bigquery-migration/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigquery-migration
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Migration\V2\Client\MigrationServiceClient;
use Google\Cloud\BigQuery\Migration\V2\GetMigrationSubtaskRequest;
use Google\Cloud\BigQuery\Migration\V2\MigrationSubtask;

// Create a client.
$migrationServiceClient = new MigrationServiceClient();

// Prepare the request message.
$request = (new GetMigrationSubtaskRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var MigrationSubtask $response */
    $response = $migrationServiceClient->getMigrationSubtask($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/bigquery/docs/migration-intro/docs).
