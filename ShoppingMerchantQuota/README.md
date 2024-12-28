# Google Shopping Merchant Quota for PHP

> Idiomatic PHP client for [Google Shopping Merchant Quota](https://developers.google.com/merchant/api).

[![Latest Stable Version](https://poser.pugx.org/google/shopping-merchant-quota/v/stable)](https://packagist.org/packages/google/shopping-merchant-quota) [![Packagist](https://img.shields.io/packagist/dm/google/shopping-merchant-quota.svg)](https://packagist.org/packages/google/shopping-merchant-quota)

* [API documentation](https://developers.google.com/merchant/api/reference/rpc/google.shopping.merchant.quota.v1beta)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/shopping-merchant-quota
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
Google\ApiCore\PagedListResponse;
Google\Shopping\Merchant\Quota\V1beta\Client\QuotaServiceClient;
Google\Shopping\Merchant\Quota\V1beta\ListQuotaGroupsRequest;
Google\Shopping\Merchant\Quota\V1beta\QuotaGroup;

// Create a client.
$quotaServiceClient = new QuotaServiceClient();

// Prepare the request message.
$request = (new ListQuotaGroupsRequest())
    ->setParent($formattedParent);

// Call the API and handle any network failures.
try {
    /** @var PagedListResponse $response */
    $response = $quotaServiceClient->listQuotaGroups($request);

    /** @var QuotaGroup $element */
    foreach ($response as $element) {
        printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
    }
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

See the [samples directory](https://github.com/googleapis/php-shopping-merchant-quota/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://developers.google.com/merchant/api).
