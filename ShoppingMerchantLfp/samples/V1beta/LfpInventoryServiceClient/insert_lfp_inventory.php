<?php
/*
 * Copyright 2024 Google LLC
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

// [START merchantapi_v1beta_generated_LfpInventoryService_InsertLfpInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Lfp\V1beta\Client\LfpInventoryServiceClient;
use Google\Shopping\Merchant\Lfp\V1beta\InsertLfpInventoryRequest;
use Google\Shopping\Merchant\Lfp\V1beta\LfpInventory;

/**
 * Inserts a `LfpInventory` resource for the given target merchant account. If
 * the resource already exists, it will be replaced. The inventory
 * automatically expires after 30 days.
 *
 * @param string $formattedParent             The LFP provider account.
 *                                            Format: `accounts/{account}`
 *                                            Please see {@see LfpInventoryServiceClient::accountName()} for help formatting this field.
 * @param int    $lfpInventoryTargetAccount   The Merchant Center ID of the merchant to submit the inventory
 *                                            for.
 * @param string $lfpInventoryStoreCode       The identifier of the merchant's store. Either the store code
 *                                            inserted through `InsertLfpStore` or the store code in the Business
 *                                            Profile.
 * @param string $lfpInventoryOfferId         Immutable. A unique identifier for the product. If both
 *                                            inventories and sales are submitted for a merchant, this id should match
 *                                            for the same product.
 *
 *                                            **Note**: if the merchant sells the same product new and used, they should
 *                                            have different IDs.
 * @param string $lfpInventoryRegionCode      The [CLDR territory
 *                                            code](https://github.com/unicode-org/cldr/blob/latest/common/main/en.xml)
 *                                            for the country where the product is sold.
 * @param string $lfpInventoryContentLanguage The two-letter ISO 639-1 language code for the item.
 * @param string $lfpInventoryAvailability    Availability of the product at this store.
 *                                            For accepted attribute values, see the [local product inventory data
 *                                            specification](https://support.google.com/merchants/answer/3061342)
 */
function insert_lfp_inventory_sample(
    string $formattedParent,
    int $lfpInventoryTargetAccount,
    string $lfpInventoryStoreCode,
    string $lfpInventoryOfferId,
    string $lfpInventoryRegionCode,
    string $lfpInventoryContentLanguage,
    string $lfpInventoryAvailability
): void {
    // Create a client.
    $lfpInventoryServiceClient = new LfpInventoryServiceClient();

    // Prepare the request message.
    $lfpInventory = (new LfpInventory())
        ->setTargetAccount($lfpInventoryTargetAccount)
        ->setStoreCode($lfpInventoryStoreCode)
        ->setOfferId($lfpInventoryOfferId)
        ->setRegionCode($lfpInventoryRegionCode)
        ->setContentLanguage($lfpInventoryContentLanguage)
        ->setAvailability($lfpInventoryAvailability);
    $request = (new InsertLfpInventoryRequest())
        ->setParent($formattedParent)
        ->setLfpInventory($lfpInventory);

    // Call the API and handle any network failures.
    try {
        /** @var LfpInventory $response */
        $response = $lfpInventoryServiceClient->insertLfpInventory($request);
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
    $formattedParent = LfpInventoryServiceClient::accountName('[ACCOUNT]');
    $lfpInventoryTargetAccount = 0;
    $lfpInventoryStoreCode = '[STORE_CODE]';
    $lfpInventoryOfferId = '[OFFER_ID]';
    $lfpInventoryRegionCode = '[REGION_CODE]';
    $lfpInventoryContentLanguage = '[CONTENT_LANGUAGE]';
    $lfpInventoryAvailability = '[AVAILABILITY]';

    insert_lfp_inventory_sample(
        $formattedParent,
        $lfpInventoryTargetAccount,
        $lfpInventoryStoreCode,
        $lfpInventoryOfferId,
        $lfpInventoryRegionCode,
        $lfpInventoryContentLanguage,
        $lfpInventoryAvailability
    );
}
// [END merchantapi_v1beta_generated_LfpInventoryService_InsertLfpInventory_sync]
