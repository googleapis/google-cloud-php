# Google Cloud Security Command Center for PHP

> Idiomatic PHP client for [Google Cloud Security Command Center](https://cloud.google.com/security-command-center).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-security-center/v/stable)](https://packagist.org/packages/google/cloud-security-center) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-security-center.svg)](https://packagist.org/packages/google/cloud-security-center)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-security-center/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-security-center
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V2\BigQueryExport;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\GetBigQueryExportRequest;

// Create a client.
$securityCenterClient = new SecurityCenterClient();

// Prepare the request message.
$request = (new GetBigQueryExportRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var BigQueryExport $response */
    $response = $securityCenterClient->getBigQueryExport($request);
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

1. Understand the [official documentation](https://cloud.google.com/security-command-center/docs).
