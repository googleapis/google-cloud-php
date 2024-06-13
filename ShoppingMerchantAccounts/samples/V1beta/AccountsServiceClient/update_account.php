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

// [START merchantapi_v1beta_generated_AccountsService_UpdateAccount_sync]
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;
use Google\Shopping\Merchant\Accounts\V1beta\Account;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateAccountRequest;
use Google\Type\TimeZone;

/**
 * Updates an account regardless of its type: standalone, MCA or sub-account.
 * Executing this method requires admin access.
 *
 * @param string $accountAccountName  A human-readable name of the account. See
 *                                    [store name](https://support.google.com/merchants/answer/160556) and
 *                                    [business name](https://support.google.com/merchants/answer/12159159) for
 *                                    more information.
 * @param string $accountLanguageCode The account's [BCP-47 language
 *                                    code](https://tools.ietf.org/html/bcp47), such as `en-US` or `sr-Latn`.
 */
function update_account_sample(string $accountAccountName, string $accountLanguageCode): void
{
    // Create a client.
    $accountsServiceClient = new AccountsServiceClient();

    // Prepare the request message.
    $accountTimeZone = new TimeZone();
    $account = (new Account())
        ->setAccountName($accountAccountName)
        ->setTimeZone($accountTimeZone)
        ->setLanguageCode($accountLanguageCode);
    $updateMask = new FieldMask();
    $request = (new UpdateAccountRequest())
        ->setAccount($account)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Account $response */
        $response = $accountsServiceClient->updateAccount($request);
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
    $accountAccountName = '[ACCOUNT_NAME]';
    $accountLanguageCode = '[LANGUAGE_CODE]';

    update_account_sample($accountAccountName, $accountLanguageCode);
}
// [END merchantapi_v1beta_generated_AccountsService_UpdateAccount_sync]
