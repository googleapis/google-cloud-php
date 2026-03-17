<?php
/*
 * Copyright 2026 Google LLC
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

// [START merchantapi_v1_generated_AccountsService_CreateTestAccount_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Account;
use Google\Shopping\Merchant\Accounts\V1\Client\AccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\CreateTestAccountRequest;
use Google\Type\TimeZone;

/**
 * Creates a Merchant Center test account.
 *
 * Test accounts are intended for development and testing purposes, such as
 * validating API integrations or new feature behavior.
 *
 * Key characteristics and limitations of test accounts:
 * - Immutable Type: A test account cannot be converted into a regular
 * (live) Merchant Center account. Likewise, a regular account cannot be
 * converted into a test account.
 * - Non-Serving Products: Any products, offers, or data created within a
 * test account will not be published or made visible to end-users on any
 * Google surfaces. They are strictly for testing environments.
 * - Separate Environment: Test accounts operate in a sandbox-like manner,
 * isolated from live serving and real user traffic.
 *
 * @param string $formattedParent     The account resource name to create the test account under.
 *                                    Format: accounts/{account}
 *                                    Please see {@see AccountsServiceClient::accountName()} for help formatting this field.
 * @param string $accountAccountName  A human-readable name of the account. Don't use punctuation,
 *                                    capitalization, or non-alphanumeric symbols such as the "/" or "_" symbols.
 *                                    See
 *                                    [Adding a business
 *                                    name](https://support.google.com/merchants/answer/12159159) for more
 *                                    information.
 * @param string $accountLanguageCode The account's [BCP-47 language
 *                                    code](https://tools.ietf.org/html/bcp47), such as `en-US` or `sr-Latn`.
 */
function create_test_account_sample(
    string $formattedParent,
    string $accountAccountName,
    string $accountLanguageCode
): void {
    // Create a client.
    $accountsServiceClient = new AccountsServiceClient();

    // Prepare the request message.
    $accountTimeZone = new TimeZone();
    $account = (new Account())
        ->setAccountName($accountAccountName)
        ->setTimeZone($accountTimeZone)
        ->setLanguageCode($accountLanguageCode);
    $request = (new CreateTestAccountRequest())
        ->setParent($formattedParent)
        ->setAccount($account);

    // Call the API and handle any network failures.
    try {
        /** @var Account $response */
        $response = $accountsServiceClient->createTestAccount($request);
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
    $formattedParent = AccountsServiceClient::accountName('[ACCOUNT]');
    $accountAccountName = '[ACCOUNT_NAME]';
    $accountLanguageCode = '[LANGUAGE_CODE]';

    create_test_account_sample($formattedParent, $accountAccountName, $accountLanguageCode);
}
// [END merchantapi_v1_generated_AccountsService_CreateTestAccount_sync]
