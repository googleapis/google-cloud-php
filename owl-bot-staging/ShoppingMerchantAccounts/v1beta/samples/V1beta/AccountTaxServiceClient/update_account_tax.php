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

// [START merchantapi_v1beta_generated_AccountTaxService_UpdateAccountTax_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\AccountTax;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AccountTaxServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateAccountTaxRequest;

/**
 * Updates the tax settings of the account.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_account_tax_sample(): void
{
    // Create a client.
    $accountTaxServiceClient = new AccountTaxServiceClient();

    // Prepare the request message.
    $accountTax = new AccountTax();
    $request = (new UpdateAccountTaxRequest())
        ->setAccountTax($accountTax);

    // Call the API and handle any network failures.
    try {
        /** @var AccountTax $response */
        $response = $accountTaxServiceClient->updateAccountTax($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END merchantapi_v1beta_generated_AccountTaxService_UpdateAccountTax_sync]
