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

// [START merchantapi_v1_generated_AccountsService_DeleteAccount_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\AccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\DeleteAccountRequest;

/**
 * Deletes the specified account regardless of its type: standalone, advanced
 * account or sub-account. Deleting an advanced account leads to the deletion
 * of all of its sub-accounts. This also deletes the account's [developer
 * registration
 * entity](/merchant/api/reference/rest/accounts_v1/accounts.developerRegistration)
 * and any associated GCP project to the account. Executing this method
 * requires admin access. The deletion succeeds only if the account does not
 * provide services to any other account and has no processed offers. You can
 * use the `force` parameter to override this.
 *
 * @param string $formattedName The name of the account to delete.
 *                              Format: `accounts/{account}`
 *                              Please see {@see AccountsServiceClient::accountName()} for help formatting this field.
 */
function delete_account_sample(string $formattedName): void
{
    // Create a client.
    $accountsServiceClient = new AccountsServiceClient();

    // Prepare the request message.
    $request = (new DeleteAccountRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $accountsServiceClient->deleteAccount($request);
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
    $formattedName = AccountsServiceClient::accountName('[ACCOUNT]');

    delete_account_sample($formattedName);
}
// [END merchantapi_v1_generated_AccountsService_DeleteAccount_sync]
