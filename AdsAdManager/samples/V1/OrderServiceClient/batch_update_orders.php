<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_OrderService_BatchUpdateOrders_sync]
use Google\Ads\AdManager\V1\BatchUpdateOrdersRequest;
use Google\Ads\AdManager\V1\BatchUpdateOrdersResponse;
use Google\Ads\AdManager\V1\Client\OrderServiceClient;
use Google\Ads\AdManager\V1\Order;
use Google\Ads\AdManager\V1\UpdateOrderRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `Order` objects.
 *
 * @param string $formattedParent                  The parent resource where `Orders` will be updated.
 *                                                 Format: `networks/{network_code}`
 *                                                 The parent field in the UpdateOrderRequest must match this
 *                                                 field. Please see
 *                                                 {@see OrderServiceClient::networkName()} for help formatting this field.
 * @param string $requestsOrderDisplayName         The display name of the Order.  This value has a maximum length
 *                                                 of 255 characters.
 * @param string $formattedRequestsOrderTrafficker The resource name of the User responsible for trafficking the
 *                                                 Order. Format: "networks/{network_code}/users/{user_id}"
 *                                                 Please see {@see OrderServiceClient::userName()} for help formatting this field.
 * @param string $formattedRequestsOrderAdvertiser The resource name of the Company, which is of type
 *                                                 Company.Type.ADVERTISER, to which this order belongs. Format:
 *                                                 "networks/{network_code}/companies/{company_id}"
 *                                                 Please see {@see OrderServiceClient::companyName()} for help formatting this field.
 */
function batch_update_orders_sample(
    string $formattedParent,
    string $requestsOrderDisplayName,
    string $formattedRequestsOrderTrafficker,
    string $formattedRequestsOrderAdvertiser
): void {
    // Create a client.
    $orderServiceClient = new OrderServiceClient();

    // Prepare the request message.
    $requestsOrder = (new Order())
        ->setDisplayName($requestsOrderDisplayName)
        ->setTrafficker($formattedRequestsOrderTrafficker)
        ->setAdvertiser($formattedRequestsOrderAdvertiser);
    $updateOrderRequest = (new UpdateOrderRequest())
        ->setOrder($requestsOrder);
    $requests = [$updateOrderRequest,];
    $request = (new BatchUpdateOrdersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateOrdersResponse $response */
        $response = $orderServiceClient->batchUpdateOrders($request);
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
    $formattedParent = OrderServiceClient::networkName('[NETWORK_CODE]');
    $requestsOrderDisplayName = '[DISPLAY_NAME]';
    $formattedRequestsOrderTrafficker = OrderServiceClient::userName('[NETWORK_CODE]', '[USER]');
    $formattedRequestsOrderAdvertiser = OrderServiceClient::companyName('[NETWORK_CODE]', '[COMPANY]');

    batch_update_orders_sample(
        $formattedParent,
        $requestsOrderDisplayName,
        $formattedRequestsOrderTrafficker,
        $formattedRequestsOrderAdvertiser
    );
}
// [END admanager_v1_generated_OrderService_BatchUpdateOrders_sync]
