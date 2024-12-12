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

// [START merchantapi_v1beta_generated_AccountsService_ListAccounts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Shopping\Merchant\Accounts\V1beta\Account;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\ListAccountsRequest;

/**
 * Lists accounts accessible to the calling user and matching the
 * constraints of the request such as page size or filters.
 * This is not just listing the sub-accounts of an MCA, but all accounts the
 * calling user has access to including other MCAs, linked accounts,
 * standalone accounts and so on. If no filter is provided, then it returns
 * accounts the user is directly added to.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_accounts_sample(): void
{
    // Create a client.
    $accountsServiceClient = new AccountsServiceClient();

    // Prepare the request message.
    $request = new ListAccountsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $accountsServiceClient->listAccounts($request);

        /** @var Account $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END merchantapi_v1beta_generated_AccountsService_ListAccounts_sync]
