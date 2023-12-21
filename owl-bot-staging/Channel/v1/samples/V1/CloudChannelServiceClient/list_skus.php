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

// [START cloudchannel_v1_generated_CloudChannelService_ListSkus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Sku;

/**
 * Lists the SKUs for a product the reseller is authorized to sell.
 *
 * Possible error codes:
 *
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 *
 * @param string $formattedParent The resource name of the Product to list SKUs for.
 *                                Parent uses the format: products/{product_id}.
 *                                Supports products/- to retrieve SKUs for all products. Please see
 *                                {@see CloudChannelServiceClient::productName()} for help formatting this field.
 * @param string $account         Resource name of the reseller.
 *                                Format: accounts/{account_id}.
 */
function list_skus_sample(string $formattedParent, string $account): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listSkus($formattedParent, $account);

        /** @var Sku $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = CloudChannelServiceClient::productName('[PRODUCT]');
    $account = '[ACCOUNT]';

    list_skus_sample($formattedParent, $account);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListSkus_sync]
