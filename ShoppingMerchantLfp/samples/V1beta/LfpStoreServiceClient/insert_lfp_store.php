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

// [START merchantapi_v1beta_generated_LfpStoreService_InsertLfpStore_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Lfp\V1beta\Client\LfpStoreServiceClient;
use Google\Shopping\Merchant\Lfp\V1beta\InsertLfpStoreRequest;
use Google\Shopping\Merchant\Lfp\V1beta\LfpStore;

/**
 * Inserts a store for the target merchant. If the store with the same store
 * code already exists, it will be replaced.
 *
 * @param string $formattedParent       The LFP provider account
 *                                      Format: `accounts/{account}`
 *                                      Please see {@see LfpStoreServiceClient::accountName()} for help formatting this field.
 * @param int    $lfpStoreTargetAccount The Merchant Center id of the merchant to submit the store for.
 * @param string $lfpStoreStoreCode     Immutable. A store identifier that is unique for the target
 *                                      merchant.
 * @param string $lfpStoreStoreAddress  The street address of the store.
 *                                      Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA.
 */
function insert_lfp_store_sample(
    string $formattedParent,
    int $lfpStoreTargetAccount,
    string $lfpStoreStoreCode,
    string $lfpStoreStoreAddress
): void {
    // Create a client.
    $lfpStoreServiceClient = new LfpStoreServiceClient();

    // Prepare the request message.
    $lfpStore = (new LfpStore())
        ->setTargetAccount($lfpStoreTargetAccount)
        ->setStoreCode($lfpStoreStoreCode)
        ->setStoreAddress($lfpStoreStoreAddress);
    $request = (new InsertLfpStoreRequest())
        ->setParent($formattedParent)
        ->setLfpStore($lfpStore);

    // Call the API and handle any network failures.
    try {
        /** @var LfpStore $response */
        $response = $lfpStoreServiceClient->insertLfpStore($request);
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
    $formattedParent = LfpStoreServiceClient::accountName('[ACCOUNT]');
    $lfpStoreTargetAccount = 0;
    $lfpStoreStoreCode = '[STORE_CODE]';
    $lfpStoreStoreAddress = '[STORE_ADDRESS]';

    insert_lfp_store_sample(
        $formattedParent,
        $lfpStoreTargetAccount,
        $lfpStoreStoreCode,
        $lfpStoreStoreAddress
    );
}
// [END merchantapi_v1beta_generated_LfpStoreService_InsertLfpStore_sync]
