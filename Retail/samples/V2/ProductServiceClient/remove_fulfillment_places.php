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
use Google\Cloud\Retail\V2\Client\ProductServiceClient;
use Google\Cloud\Retail\V2\RemoveFulfillmentPlacesRequest;
use Google\Cloud\Retail\V2\RemoveFulfillmentPlacesResponse;
use Google\Rpc\Status;

/**
 * It is recommended to use the
 * [ProductService.RemoveLocalInventories][google.cloud.retail.v2.ProductService.RemoveLocalInventories]
 * method instead of
 * [ProductService.RemoveFulfillmentPlaces][google.cloud.retail.v2.ProductService.RemoveFulfillmentPlaces].
 * [ProductService.RemoveLocalInventories][google.cloud.retail.v2.ProductService.RemoveLocalInventories]
 * achieves the same results but provides more fine-grained control over
 * ingesting local inventory data.
 *
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
 * The returned [Operation][google.longrunning.Operation]s will be obsolete
 * after 1 day, and [GetOperation][google.longrunning.Operations.GetOperation]
 * API will return NOT_FOUND afterwards.
 *
 * If conflicting updates are issued, the
 * [Operation][google.longrunning.Operation]s associated with the stale
 * updates will not be marked as [done][google.longrunning.Operation.done]
 * until being obsolete.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function remove_fulfillment_places_sample(): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare the request message.
    $request = new RemoveFulfillmentPlacesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productServiceClient->removeFulfillmentPlaces($request);
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
// [END retail_v2_generated_ProductService_RemoveFulfillmentPlaces_sync]
