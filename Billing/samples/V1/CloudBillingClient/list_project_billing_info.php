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

// [START cloudbilling_v1_generated_CloudBilling_ListProjectBillingInfo_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Billing\V1\CloudBillingClient;
use Google\Cloud\Billing\V1\ProjectBillingInfo;

/**
 * Lists the projects associated with a billing account. The current
 * authenticated user must have the `billing.resourceAssociations.list` IAM
 * permission, which is often given to billing account
 * [viewers](https://cloud.google.com/billing/docs/how-to/billing-access).
 *
 * @param string $formattedName The resource name of the billing account associated with the projects that
 *                              you want to list. For example, `billingAccounts/012345-567890-ABCDEF`. Please see
 *                              {@see CloudBillingClient::billingAccountName()} for help formatting this field.
 */
function list_project_billing_info_sample(string $formattedName): void
{
    // Create a client.
    $cloudBillingClient = new CloudBillingClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudBillingClient->listProjectBillingInfo($formattedName);

        /** @var ProjectBillingInfo $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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

    list_project_billing_info_sample($formattedName);
}
// [END cloudbilling_v1_generated_CloudBilling_ListProjectBillingInfo_sync]
