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

// [START merchantapi_v1_generated_RegionalInventoryService_DeleteRegionalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1\Client\RegionalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1\DeleteRegionalInventoryRequest;

/**
 * Deletes the specified `RegionalInventory` resource from the given product
 * in your merchant account.  It might take up to an hour for the
 * `RegionalInventory` to be deleted from the specific product.
 * Once you have received a successful delete response, wait for that
 * period before attempting a delete again.
 *
 * @param string $formattedName The name of the `RegionalInventory` resource to delete.
 *                              Format:
 *                              `accounts/{account}/products/{product}/regionalInventories/{region}`
 *                              Please see {@see RegionalInventoryServiceClient::regionalInventoryName()} for help formatting this field.
 */
function delete_regional_inventory_sample(string $formattedName): void
{
    // Create a client.
    $regionalInventoryServiceClient = new RegionalInventoryServiceClient();

    // Prepare the request message.
    $request = (new DeleteRegionalInventoryRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $regionalInventoryServiceClient->deleteRegionalInventory($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = RegionalInventoryServiceClient::regionalInventoryName(
        '[ACCOUNT]',
        '[PRODUCT]',
        '[REGION]'
    );

    delete_regional_inventory_sample($formattedName);
}
// [END merchantapi_v1_generated_RegionalInventoryService_DeleteRegionalInventory_sync]
