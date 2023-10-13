<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudcommerceconsumerprocurement_v1_generated_ConsumerProcurementService_PlaceOrder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Commerce\Consumer\Procurement\V1\Client\ConsumerProcurementServiceClient;
use Google\Cloud\Commerce\Consumer\Procurement\V1\Order;
use Google\Cloud\Commerce\Consumer\Procurement\V1\PlaceOrderRequest;
use Google\Rpc\Status;

/**
 * Creates a new [Order][google.cloud.commerce.consumer.procurement.v1.Order].
 *
 * This API only supports GCP spend-based committed use
 * discounts specified by GCP documentation.
 *
 * The returned long-running operation is in-progress until the backend
 * completes the creation of the resource. Once completed, the order is
 * in
 * [OrderState.ORDER_STATE_ACTIVE][google.cloud.commerce.consumer.procurement.v1.OrderState.ORDER_STATE_ACTIVE].
 * In case of failure, the order resource will be removed.
 *
 * @param string $formattedParent The resource name of the parent resource.
 *                                This field has the form  `billingAccounts/{billing-account-id}`. Please see
 *                                {@see ConsumerProcurementServiceClient::billingAccountName()} for help formatting this field.
 * @param string $displayName     The user-specified name of the order being placed.
 */
function place_order_sample(string $formattedParent, string $displayName): void
{
    // Create a client.
    $consumerProcurementServiceClient = new ConsumerProcurementServiceClient();

    // Prepare the request message.
    $request = (new PlaceOrderRequest())
        ->setParent($formattedParent)
        ->setDisplayName($displayName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $consumerProcurementServiceClient->placeOrder($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Order $result */
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
    $formattedParent = ConsumerProcurementServiceClient::billingAccountName('[BILLING_ACCOUNT]');
    $displayName = '[DISPLAY_NAME]';

    place_order_sample($formattedParent, $displayName);
}
// [END cloudcommerceconsumerprocurement_v1_generated_ConsumerProcurementService_PlaceOrder_sync]
