<?php
/*
 * Copyright 2022 Google LLC
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

// [START cloudbilling_v1_generated_CloudBilling_CreateBillingAccount_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Billing\V1\BillingAccount;
use Google\Cloud\Billing\V1\CloudBillingClient;

/**
 * This method creates [billing
 * subaccounts](https://cloud.google.com/billing/docs/concepts#subaccounts).
 *
 * Google Cloud resellers should use the
 * Channel Services APIs,
 * [accounts.customers.create](https://cloud.google.com/channel/docs/reference/rest/v1/accounts.customers/create)
 * and
 * [accounts.customers.entitlements.create](https://cloud.google.com/channel/docs/reference/rest/v1/accounts.customers.entitlements/create).
 *
 * When creating a subaccount, the current authenticated user must have the
 * `billing.accounts.update` IAM permission on the parent account, which is
 * typically given to billing account
 * [administrators](https://cloud.google.com/billing/docs/how-to/billing-access).
 * This method will return an error if the parent account has not been
 * provisioned as a reseller account.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_billing_account_sample(): void
{
    // Create a client.
    $cloudBillingClient = new CloudBillingClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $billingAccount = new BillingAccount();

    // Call the API and handle any network failures.
    try {
        /** @var BillingAccount $response */
        $response = $cloudBillingClient->createBillingAccount($billingAccount);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudbilling_v1_generated_CloudBilling_CreateBillingAccount_sync]
