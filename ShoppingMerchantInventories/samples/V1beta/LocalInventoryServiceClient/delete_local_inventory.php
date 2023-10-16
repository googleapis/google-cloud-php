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

// [START merchantapi_v1beta_generated_LocalInventoryService_DeleteLocalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1beta\Client\LocalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1beta\DeleteLocalInventoryRequest;

/**
 * Deletes the specified `LocalInventory` from the given product in your
 * merchant account. It might take a up to an hour for the
 * `LocalInventory` to be deleted from the specific product.
 * Once you have received a successful delete response, wait for that
 * period before attempting a delete again.
 *
 * @param string $formattedName The name of the local inventory for the given product to delete.
 *                              Format:
 *                              `accounts/{account}/products/{product}/localInventories/{store_code}`
 *                              Please see {@see LocalInventoryServiceClient::localInventoryName()} for help formatting this field.
 */
function delete_local_inventory_sample(string $formattedName): void
{
    // Create a client.
    $localInventoryServiceClient = new LocalInventoryServiceClient();

    // Prepare the request message.
    $request = (new DeleteLocalInventoryRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $localInventoryServiceClient->deleteLocalInventory($request);
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
    $formattedName = LocalInventoryServiceClient::localInventoryName(
        '[ACCOUNT]',
        '[PRODUCT]',
        '[STORE_CODE]'
    );

    delete_local_inventory_sample($formattedName);
}
// [END merchantapi_v1beta_generated_LocalInventoryService_DeleteLocalInventory_sync]
