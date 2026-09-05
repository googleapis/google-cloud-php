# Google Shopping Merchant Loyaltycustomers for PHP

> Idiomatic PHP client for [Google Shopping Merchant Loyaltycustomers](https://developers.google.com/merchant/api).

[![Latest Stable Version](https://poser.pugx.org/google/shopping-merchant-loyaltycustomers/v/stable)](https://packagist.org/packages/google/shopping-merchant-loyaltycustomers) [![Packagist](https://img.shields.io/packagist/dm/google/shopping-merchant-loyaltycustomers.svg)](https://packagist.org/packages/google/shopping-merchant-loyaltycustomers)

* [API documentation](https://cloud.google.com/php/docs/reference/shopping-merchant-loyaltycustomers/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/shopping-merchant-loyaltycustomers
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
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Loyaltycustomers\V1\Client\LoyaltyCustomerMatchServiceClient;
use Google\Shopping\Merchant\Loyaltycustomers\V1\LoyaltyCustomer;
use Google\Shopping\Merchant\Loyaltycustomers\V1\LoyaltyCustomer\LoyaltyTier;
use Google\Shopping\Merchant\Loyaltycustomers\V1\ManageLoyaltyCustomerMatchRequest;
use Google\Shopping\Merchant\Loyaltycustomers\V1\ManageLoyaltyCustomerMatchResponse;
use Google\Shopping\Merchant\Loyaltycustomers\V1\UserIdentifier;

$formattedParent = LoyaltyCustomerMatchServiceClient::accountName('[ACCOUNT]');
$loyaltyCustomerLoyaltyTier = LoyaltyTier::LOYALTY_TIER_UNSPECIFIED;

manage_loyalty_customer_match_sample($formattedParent, $loyaltyCustomerLoyaltyTier);
```

See the [samples directory](https://github.com/googleapis/php-shopping-merchant-loyaltycustomers/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://developers.google.com/merchant/api).
