<?php
/*
 * Copyright 2025 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START merchantapi_v1beta_generated_OrderTrackingSignalsService_CreateOrderTrackingSignal_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\OrderTracking\V1beta\Client\OrderTrackingSignalsServiceClient;
use Google\Shopping\Merchant\OrderTracking\V1beta\CreateOrderTrackingSignalRequest;
use Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal;
use Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal\LineItemDetails;
use Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal\ShippingInfo;
use Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal\ShippingInfo\ShippingState;
use Google\Type\DateTime;

/**
 * Creates new order tracking signal.
 *
 * @param string $formattedParent                                 The account of the business for which the order signal is
 *                                                                created. Format: accounts/{account}
 *                                                                Please see {@see OrderTrackingSignalsServiceClient::accountName()} for help formatting this field.
 * @param string $orderTrackingSignalOrderId                      The ID of the order on the businesses side. This field will be
 *                                                                hashed in returned OrderTrackingSignal creation response.
 * @param string $orderTrackingSignalShippingInfoShipmentId       The shipment ID. This field will be hashed in returned
 *                                                                OrderTrackingSignal creation response.
 * @param int    $orderTrackingSignalShippingInfoShippingStatus   The status of the shipment.
 * @param string $orderTrackingSignalShippingInfoOriginPostalCode The origin postal code, as a continuous string without spaces
 *                                                                or dashes, for example "95016". This field will be anonymized in returned
 *                                                                OrderTrackingSignal creation response.
 * @param string $orderTrackingSignalShippingInfoOriginRegionCode The [CLDR territory code]
 *                                                                (http://www.unicode.org/repos/cldr/tags/latest/common/main/en.xml) for
 *                                                                the shipping origin.
 * @param string $orderTrackingSignalLineItemsLineItemId          The ID for this line item.
 * @param string $orderTrackingSignalLineItemsProductId           The Content API REST ID of the product, in the
 *                                                                form channel:contentLanguage:targetCountry:offerId.
 * @param int    $orderTrackingSignalLineItemsQuantity            The quantity of the line item in the order.
 */
function create_order_tracking_signal_sample(
    string $formattedParent,
    string $orderTrackingSignalOrderId,
    string $orderTrackingSignalShippingInfoShipmentId,
    int $orderTrackingSignalShippingInfoShippingStatus,
    string $orderTrackingSignalShippingInfoOriginPostalCode,
    string $orderTrackingSignalShippingInfoOriginRegionCode,
    string $orderTrackingSignalLineItemsLineItemId,
    string $orderTrackingSignalLineItemsProductId,
    int $orderTrackingSignalLineItemsQuantity
): void {
    // Create a client.
    $orderTrackingSignalsServiceClient = new OrderTrackingSignalsServiceClient();

    // Prepare the request message.
    $orderTrackingSignalOrderCreatedTime = new DateTime();
    $shippingInfo = (new ShippingInfo())
        ->setShipmentId($orderTrackingSignalShippingInfoShipmentId)
        ->setShippingStatus($orderTrackingSignalShippingInfoShippingStatus)
        ->setOriginPostalCode($orderTrackingSignalShippingInfoOriginPostalCode)
        ->setOriginRegionCode($orderTrackingSignalShippingInfoOriginRegionCode);
    $orderTrackingSignalShippingInfo = [$shippingInfo,];
    $lineItemDetails = (new LineItemDetails())
        ->setLineItemId($orderTrackingSignalLineItemsLineItemId)
        ->setProductId($orderTrackingSignalLineItemsProductId)
        ->setQuantity($orderTrackingSignalLineItemsQuantity);
    $orderTrackingSignalLineItems = [$lineItemDetails,];
    $orderTrackingSignal = (new OrderTrackingSignal())
        ->setOrderCreatedTime($orderTrackingSignalOrderCreatedTime)
        ->setOrderId($orderTrackingSignalOrderId)
        ->setShippingInfo($orderTrackingSignalShippingInfo)
        ->setLineItems($orderTrackingSignalLineItems);
    $request = (new CreateOrderTrackingSignalRequest())
        ->setParent($formattedParent)
        ->setOrderTrackingSignal($orderTrackingSignal);

    // Call the API and handle any network failures.
    try {
        /** @var OrderTrackingSignal $response */
        $response = $orderTrackingSignalsServiceClient->createOrderTrackingSignal($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
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
}
// [END merchantapi_v1beta_generated_OrderTrackingSignalsService_CreateOrderTrackingSignal_sync]
