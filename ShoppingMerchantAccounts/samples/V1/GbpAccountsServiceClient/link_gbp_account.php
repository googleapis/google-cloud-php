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

// [START merchantapi_v1_generated_GbpAccountsService_LinkGbpAccount_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\GbpAccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\LinkGbpAccountRequest;
use Google\Shopping\Merchant\Accounts\V1\LinkGbpAccountResponse;

/**
 * Link the specified merchant to a GBP account for all countries.
 *
 * To run this method, you must have admin access to the Merchant Center
 * account. If you don't have admin access, the request fails with the error
 * message `User is not an administrator of account {ACCOUNT_ID}`.
 *
 * @param string $formattedParent The name of the parent resource to which the GBP account is
 *                                linked. Format: `accounts/{account}`. Please see
 *                                {@see GbpAccountsServiceClient::accountName()} for help formatting this field.
 * @param string $gbpEmail        The email address of the Business Profile account.
 */
function link_gbp_account_sample(string $formattedParent, string $gbpEmail): void
{
    // Create a client.
    $gbpAccountsServiceClient = new GbpAccountsServiceClient();

    // Prepare the request message.
    $request = (new LinkGbpAccountRequest())
        ->setParent($formattedParent)
        ->setGbpEmail($gbpEmail);

    // Call the API and handle any network failures.
    try {
        /** @var LinkGbpAccountResponse $response */
        $response = $gbpAccountsServiceClient->linkGbpAccount($request);
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
    $formattedParent = GbpAccountsServiceClient::accountName('[ACCOUNT]');
    $gbpEmail = '[GBP_EMAIL]';

    link_gbp_account_sample($formattedParent, $gbpEmail);
}
// [END merchantapi_v1_generated_GbpAccountsService_LinkGbpAccount_sync]
