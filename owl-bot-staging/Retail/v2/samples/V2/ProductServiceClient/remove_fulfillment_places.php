<?php
/*
 * Copyright 2022 Google LLC
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

// [START retail_v2_generated_ProductService_RemoveFulfillmentPlaces_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\ProductServiceClient;
use Google\Cloud\Retail\V2\RemoveFulfillmentPlacesResponse;
use Google\Rpc\Status;

/**
 * Incrementally removes place IDs from a
 * [Product.fulfillment_info.place_ids][google.cloud.retail.v2.FulfillmentInfo.place_ids].
 *
 * This process is asynchronous and does not require the
 * [Product][google.cloud.retail.v2.Product] to exist before updating
 * fulfillment information. If the request is valid, the update will be
 * enqueued and processed downstream. As a consequence, when a response is
 * returned, the removed place IDs are not immediately manifested in the
 * [Product][google.cloud.retail.v2.Product] queried by
 * [ProductService.GetProduct][google.cloud.retail.v2.ProductService.GetProduct]
 * or
 * [ProductService.ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
 *
 * The returned [Operation][]s will be obsolete after 1 day, and
 * [GetOperation][] API will return NOT_FOUND afterwards.
 *
 * If conflicting updates are issued, the [Operation][]s associated with the
 * stale updates will not be marked as [done][Operation.done] until being
 * obsolete.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 *
 * @param string $formattedProduct Full resource name of [Product][google.cloud.retail.v2.Product],
 *                                 such as
 *                                 `projects/&#42;/locations/global/catalogs/default_catalog/branches/default_branch/products/some_product_id`.
 *
 *                                 If the caller does not have permission to access the
 *                                 [Product][google.cloud.retail.v2.Product], regardless of whether or not it
 *                                 exists, a PERMISSION_DENIED error is returned. Please see
 *                                 {@see ProductServiceClient::productName()} for help formatting this field.
 * @param string $type             The fulfillment type, including commonly used types (such as
 *                                 pickup in store and same day delivery), and custom types.
 *
 *                                 Supported values:
 *
 *                                 * "pickup-in-store"
 *                                 * "ship-to-store"
 *                                 * "same-day-delivery"
 *                                 * "next-day-delivery"
 *                                 * "custom-type-1"
 *                                 * "custom-type-2"
 *                                 * "custom-type-3"
 *                                 * "custom-type-4"
 *                                 * "custom-type-5"
 *
 *                                 If this field is set to an invalid value other than these, an
 *                                 INVALID_ARGUMENT error is returned.
 *
 *                                 This field directly corresponds to
 *                                 [Product.fulfillment_info.type][google.cloud.retail.v2.FulfillmentInfo.type].
 * @param string $placeIdsElement  The IDs for this
 *                                 [type][google.cloud.retail.v2.RemoveFulfillmentPlacesRequest.type], such as
 *                                 the store IDs for "pickup-in-store" or the region IDs for
 *                                 "same-day-delivery", to be removed for this
 *                                 [type][google.cloud.retail.v2.RemoveFulfillmentPlacesRequest.type].
 *
 *                                 At least 1 value is required, and a maximum of 2000 values are allowed.
 *                                 Each value must be a string with a length limit of 10 characters, matching
 *                                 the pattern `[a-zA-Z0-9_-]+`, such as "store1" or "REGION-2". Otherwise, an
 *                                 INVALID_ARGUMENT error is returned.
 */
function remove_fulfillment_places_sample(
    string $formattedProduct,
    string $type,
    string $placeIdsElement
): void {
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $placeIds = [$placeIdsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productServiceClient->removeFulfillmentPlaces($formattedProduct, $type, $placeIds);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RemoveFulfillmentPlacesResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedProduct = ProductServiceClient::productName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]',
        '[PRODUCT]'
    );
    $type = '[TYPE]';
    $placeIdsElement = '[PLACE_IDS]';

    remove_fulfillment_places_sample($formattedProduct, $type, $placeIdsElement);
}
// [END retail_v2_generated_ProductService_RemoveFulfillmentPlaces_sync]
