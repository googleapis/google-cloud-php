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

// [START cloudcommerceconsumerprocurement_v1_generated_ConsumerProcurementService_GetOrder_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Commerce\Consumer\Procurement\V1\Client\ConsumerProcurementServiceClient;
use Google\Cloud\Commerce\Consumer\Procurement\V1\GetOrderRequest;
use Google\Cloud\Commerce\Consumer\Procurement\V1\Order;

/**
 * Returns the requested
 * [Order][google.cloud.commerce.consumer.procurement.v1.Order] resource.
 *
 * @param string $name The name of the order to retrieve.
 */
function get_order_sample(string $name): void
{
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
    $name = '[NAME]';

    get_order_sample($name);
}
// [END cloudcommerceconsumerprocurement_v1_generated_ConsumerProcurementService_GetOrder_sync]
