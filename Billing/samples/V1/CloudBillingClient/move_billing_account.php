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

// [START cloudbilling_v1_generated_CloudBilling_MoveBillingAccount_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Billing\V1\BillingAccount;
use Google\Cloud\Billing\V1\CloudBillingClient;

/**
 * Changes which parent organization a billing account belongs to.
 *
 * @param string $formattedName              The resource name of the billing account to move.
 *                                           Must be of the form `billingAccounts/{billing_account_id}`.
 *                                           The specified billing account cannot be a subaccount, since a subaccount
 *                                           always belongs to the same organization as its parent account. Please see
 *                                           {@see CloudBillingClient::billingAccountName()} for help formatting this field.
 * @param string $formattedDestinationParent The resource name of the Organization to reparent
 *                                           the billing account under.
 *                                           Must be of the form `organizations/{organization_id}`. Please see
 *                                           {@see CloudBillingClient::organizationName()} for help formatting this field.
 */
function move_billing_account_sample(
    string $formattedName,
    string $formattedDestinationParent
): void {
    // Create a client.
    $cloudBillingClient = new CloudBillingClient();

    // Call the API and handle any network failures.
    try {
        /** @var BillingAccount $response */
        $response = $cloudBillingClient->moveBillingAccount($formattedName, $formattedDestinationParent);
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
    $formattedName = CloudBillingClient::billingAccountName('[BILLING_ACCOUNT]');
    $formattedDestinationParent = CloudBillingClient::organizationName('[ORGANIZATION]');

    move_billing_account_sample($formattedName, $formattedDestinationParent);
}
// [END cloudbilling_v1_generated_CloudBilling_MoveBillingAccount_sync]
