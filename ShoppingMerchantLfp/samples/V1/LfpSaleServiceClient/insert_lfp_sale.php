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

// [START merchantapi_v1_generated_LfpSaleService_InsertLfpSale_sync]
use Google\ApiCore\ApiException;
use Google\Protobuf\Timestamp;
use Google\Shopping\Merchant\Lfp\V1\Client\LfpSaleServiceClient;
use Google\Shopping\Merchant\Lfp\V1\InsertLfpSaleRequest;
use Google\Shopping\Merchant\Lfp\V1\LfpSale;
use Google\Shopping\Type\Price;

/**
 * Inserts a `LfpSale` for the given merchant.
 *
 * @param string $parent                 The LFP provider account.
 *                                       Format: `accounts/{lfp_partner}`
 * @param int    $lfpSaleTargetAccount   The Merchant Center ID of the merchant to submit the sale for.
 * @param string $lfpSaleStoreCode       The identifier of the merchant's store. Either a `storeCode`
 *                                       inserted through the API or the code of the store in the Business Profile.
 * @param string $lfpSaleOfferId         A unique identifier for the product. If both inventories and
 *                                       sales are submitted for a merchant, this id should match for the same
 *                                       product.
 *
 *                                       **Note**: if the merchant sells the same product new and used, they should
 *                                       have different IDs.
 * @param string $lfpSaleRegionCode      The [CLDR territory
 *                                       code](https://github.com/unicode-org/cldr/blob/latest/common/main/en.xml)
 *                                       for the country where the product is sold.
 * @param string $lfpSaleContentLanguage The two-letter ISO 639-1 language code for the item.
 * @param string $lfpSaleGtin            The Global Trade Item Number of the sold product.
 * @param int    $lfpSaleQuantity        The relative change of the available quantity. Negative for items
 *                                       returned.
 */
function insert_lfp_sale_sample(
    string $parent,
    int $lfpSaleTargetAccount,
    string $lfpSaleStoreCode,
    string $lfpSaleOfferId,
    string $lfpSaleRegionCode,
    string $lfpSaleContentLanguage,
    string $lfpSaleGtin,
    int $lfpSaleQuantity
): void {
    // Create a client.
    $lfpSaleServiceClient = new LfpSaleServiceClient();

    // Prepare the request message.
    $lfpSalePrice = new Price();
    $lfpSaleSaleTime = new Timestamp();
    $lfpSale = (new LfpSale())
        ->setTargetAccount($lfpSaleTargetAccount)
        ->setStoreCode($lfpSaleStoreCode)
        ->setOfferId($lfpSaleOfferId)
        ->setRegionCode($lfpSaleRegionCode)
        ->setContentLanguage($lfpSaleContentLanguage)
        ->setGtin($lfpSaleGtin)
        ->setPrice($lfpSalePrice)
        ->setQuantity($lfpSaleQuantity)
        ->setSaleTime($lfpSaleSaleTime);
    $request = (new InsertLfpSaleRequest())
        ->setParent($parent)
        ->setLfpSale($lfpSale);

    // Call the API and handle any network failures.
    try {
        /** @var LfpSale $response */
        $response = $lfpSaleServiceClient->insertLfpSale($request);
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
    $parent = '[PARENT]';
    $lfpSaleTargetAccount = 0;
    $lfpSaleStoreCode = '[STORE_CODE]';
    $lfpSaleOfferId = '[OFFER_ID]';
    $lfpSaleRegionCode = '[REGION_CODE]';
    $lfpSaleContentLanguage = '[CONTENT_LANGUAGE]';
    $lfpSaleGtin = '[GTIN]';
    $lfpSaleQuantity = 0;

    insert_lfp_sale_sample(
        $parent,
        $lfpSaleTargetAccount,
        $lfpSaleStoreCode,
        $lfpSaleOfferId,
        $lfpSaleRegionCode,
        $lfpSaleContentLanguage,
        $lfpSaleGtin,
        $lfpSaleQuantity
    );
}
// [END merchantapi_v1_generated_LfpSaleService_InsertLfpSale_sync]
