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

// [START cloudchannel_v1_generated_CloudChannelService_QueryEligibleBillingAccounts_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\QueryEligibleBillingAccountsRequest;
use Google\Cloud\Channel\V1\QueryEligibleBillingAccountsResponse;

/**
 * Lists the billing accounts that are eligible to purchase particular SKUs
 * for a given customer.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 *
 * Return value:
 * Based on the provided list of SKUs, returns a list of SKU groups that must
 * be purchased using the same billing account and the billing accounts
 * eligible to purchase each SKU group.
 *
 * @param string $formattedCustomer The resource name of the customer to list eligible billing
 *                                  accounts for. Format: accounts/{account_id}/customers/{customer_id}. Please see
 *                                  {@see CloudChannelServiceClient::customerName()} for help formatting this field.
 * @param string $skusElement       List of SKUs to list eligible billing accounts for. At least one
 *                                  SKU is required. Format: products/{product_id}/skus/{sku_id}.
 */
function query_eligible_billing_accounts_sample(
    string $formattedCustomer,
    string $skusElement
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $skus = [$skusElement,];
    $request = (new QueryEligibleBillingAccountsRequest())
        ->setCustomer($formattedCustomer)
        ->setSkus($skus);

    // Call the API and handle any network failures.
    try {
        /** @var QueryEligibleBillingAccountsResponse $response */
        $response = $cloudChannelServiceClient->queryEligibleBillingAccounts($request);
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
    $formattedCustomer = CloudChannelServiceClient::customerName('[ACCOUNT]', '[CUSTOMER]');
    $skusElement = '[SKUS]';

    query_eligible_billing_accounts_sample($formattedCustomer, $skusElement);
}
// [END cloudchannel_v1_generated_CloudChannelService_QueryEligibleBillingAccounts_sync]
