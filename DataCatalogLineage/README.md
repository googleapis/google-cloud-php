# Google Cloud Data Catalog Lineage for PHP

> Idiomatic PHP client for [Google Cloud Data Catalog Lineage](https://cloud.google.com/data-catalog/docs/concepts/about-data-lineage).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-datacatalog-lineage/v/stable)](https://packagist.org/packages/google/cloud-datacatalog-lineage) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-datacatalog-lineage.svg)](https://packagist.org/packages/google/cloud-datacatalog-lineage)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-datacatalog-lineage/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-datacatalog-lineage
```

> Browse the complete list of [Google Cloud APIs](https://cloud.google.com/php/docs/reference)
> for PHP

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
Google\ApiCore\ApiException;
Google\Cloud\DataCatalog\Lineage\V1\Client\LineageClient;
Google\Cloud\DataCatalog\Lineage\V1\GetLineageEventRequest;
Google\Cloud\DataCatalog\Lineage\V1\LineageEvent;

// Create a client.
$lineageClient = new LineageClient();

// Prepare the request message.
$request = (new GetLineageEventRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var LineageEvent $response */
    $response = $lineageClient->getLineageEvent($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```s

See the [samples directory](samples/) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/data-catalog/docs/reference/data-lineage/rest).
