# Google Cloud Financial Services for PHP

> Idiomatic PHP client for [Google Cloud Financial Services](https://cloud.google.com/financial-services/anti-money-laundering).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-financialservices/v/stable)](https://packagist.org/packages/google/cloud-financialservices) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-financialservices.svg)](https://packagist.org/packages/google/cloud-financialservices)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-financialservices/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-financialservices
```

> Browse the complete list of [Google Cloud APIs](https://cloud.google.com/php/docs/reference)
> for PHP

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits
offered by gRPC (such as streaming methods) please see our
[gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
Google\ApiCore\ApiException;
Google\Cloud\FinancialServices\V1\BacktestResult;
Google\Cloud\FinancialServices\V1\Client\AMLClient;
Google\Cloud\FinancialServices\V1\GetBacktestResultRequest;

// Create a client.
$aMLClient = new AMLClient();

// Prepare the request message.
$request = (new GetBacktestResultRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var BacktestResult $response */
    $response = $aMLClient->getBacktestResult($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-financialservices/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/financial-services/anti-money-laundering/docs/concepts/overview).
