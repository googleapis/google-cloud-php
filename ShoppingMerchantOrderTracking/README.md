# Google Shopping Merchant Order Tracking for PHP

> Idiomatic PHP client for [Google Shopping Merchant Order Tracking](https://developers.google.com/merchant/api).

[![Latest Stable Version](https://poser.pugx.org/google/shopping-merchant-ordertracking/v/stable)](https://packagist.org/packages/google/shopping-merchant-ordertracking) [![Packagist](https://img.shields.io/packagist/dm/google/shopping-merchant-ordertracking.svg)](https://packagist.org/packages/google/shopping-merchant-ordertracking)

* [API documentation](https://cloud.google.com/php/docs/reference/shopping-merchant-ordertracking/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now, install this component:

```sh
$ composer require google/shopping-merchant-ordertracking
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
Google\Shopping\Merchant\OrderTracking\V1\Client\OrderTrackingSignalsServiceClient;
Google\Shopping\Merchant\OrderTracking\V1\CreateOrderTrackingSignalRequest;
Google\Shopping\Merchant\OrderTracking\V1\OrderTrackingSignal;
Google\Shopping\Merchant\OrderTracking\V1\OrderTrackingSignal\LineItemDetails;
Google\Shopping\Merchant\OrderTracking\V1\OrderTrackingSignal\ShippingInfo;
Google\Shopping\Merchant\OrderTracking\V1\OrderTrackingSignal\ShippingInfo\ShippingState;
Google\Type\DateTime;

$formattedParent = OrderTrackingSignalsServiceClient::accountName('[ACCOUNT]');
$orderTrackingSignalOrderId = '[ORDER_ID]';
$orderTrackingSignalShippingInfoShipmentId = '[SHIPMENT_ID]';
$orderTrackingSignalShippingInfoShippingStatus = ShippingState::SHIPPING_STATE_UNSPECIFIED;
$orderTrackingSignalShippingInfoOriginPostalCode = '[ORIGIN_POSTAL_CODE]';
$orderTrackingSignalShippingInfoOriginRegionCode = '[ORIGIN_REGION_CODE]';
$orderTrackingSignalLineItemsLineItemId = '[LINE_ITEM_ID]';
$orderTrackingSignalLineItemsProductId = '[PRODUCT_ID]';
$orderTrackingSignalLineItemsQuantity = 0;

create_order_tracking_signal_sample(
    $formattedParent,
    $orderTrackingSignalOrderId,
    $orderTrackingSignalShippingInfoShipmentId,
    $orderTrackingSignalShippingInfoShippingStatus,
    $orderTrackingSignalShippingInfoOriginPostalCode,
    $orderTrackingSignalShippingInfoOriginRegionCode,
    $orderTrackingSignalLineItemsLineItemId,
    $orderTrackingSignalLineItemsProductId,
    $orderTrackingSignalLineItemsQuantity
);
```

See the [samples directory](https://github.com/googleapis/php-shopping-merchant-ordertracking/tree/main/samples) for a canonical list of samples.

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://developers.google.com/merchant/api).
