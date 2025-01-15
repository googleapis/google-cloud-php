# Google Cloud Commerce Consumer Procurement for PHP

> Idiomatic PHP client for [Google Cloud Commerce Consumer Procurement](https://cloud.google.com/marketplace).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-commerce-consumer-procurement/v/stable)](https://packagist.org/packages/google/cloud-commerce-consumer-procurement) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-commerce-consumer-procurement.svg)](https://packagist.org/packages/google/cloud-commerce-consumer-procurement)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-commerce-consumer-procurement/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/cloud-commerce-consumer-procurement
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
Google\Cloud\Commerce\Consumer\Procurement\V1\Client\ConsumerProcurementServiceClient;
Google\Cloud\Commerce\Consumer\Procurement\V1\GetOrderRequest;
Google\Cloud\Commerce\Consumer\Procurement\V1\Order;

// Create a client.
$consumerProcurementServiceClient = new ConsumerProcurementServiceClient();

// Prepare the request message.
$request = (new GetOrderRequest())
    ->setName($name);

// Call the API and handle any network failures.
try {
    /** @var Order $response */
    $response = $consumerProcurementServiceClient->getOrder($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/google-cloud-php-commerce-consumer-procurement/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/marketplace/docs/).
