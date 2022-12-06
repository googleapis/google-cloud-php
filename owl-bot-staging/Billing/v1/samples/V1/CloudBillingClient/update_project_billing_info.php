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

// [START cloudbilling_v1_generated_CloudBilling_UpdateProjectBillingInfo_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Billing\V1\CloudBillingClient;
use Google\Cloud\Billing\V1\ProjectBillingInfo;

/**
 * Sets or updates the billing account associated with a project. You specify
 * the new billing account by setting the `billing_account_name` in the
 * `ProjectBillingInfo` resource to the resource name of a billing account.
 * Associating a project with an open billing account enables billing on the
 * project and allows charges for resource usage. If the project already had a
 * billing account, this method changes the billing account used for resource
 * usage charges.
 *
 * *Note:* Incurred charges that have not yet been reported in the transaction
 * history of the Google Cloud Console might be billed to the new billing
 * account, even if the charge occurred before the new billing account was
 * assigned to the project.
 *
 * The current authenticated user must have ownership privileges for both the
 * [project](https://cloud.google.com/docs/permissions-overview#h.bgs0oxofvnoo
 * ) and the [billing
 * account](https://cloud.google.com/billing/docs/how-to/billing-access).
 *
 * You can disable billing on the project by setting the
 * `billing_account_name` field to empty. This action disassociates the
 * current billing account from the project. Any billable activity of your
 * in-use services will stop, and your application could stop functioning as
 * expected. Any unbilled charges to date will be billed to the previously
 * associated account. The current authenticated user must be either an owner
 * of the project or an owner of the billing account for the project.
 *
 * Note that associating a project with a *closed* billing account will have
 * much the same effect as disabling billing on the project: any paid
 * resources used by the project will be shut down. Thus, unless you wish to
 * disable billing, you should always call this method with the name of an
 * *open* billing account.
 *
 * @param string $name The resource name of the project associated with the billing information
 *                     that you want to update. For example, `projects/tokyo-rain-123`.
 */
function update_project_billing_info_sample(string $name): void
{
    // Create a client.
    $cloudBillingClient = new CloudBillingClient();

    // Call the API and handle any network failures.
    try {
        /** @var ProjectBillingInfo $response */
        $response = $cloudBillingClient->updateProjectBillingInfo($name);
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
    $name = '[NAME]';

    update_project_billing_info_sample($name);
}
// [END cloudbilling_v1_generated_CloudBilling_UpdateProjectBillingInfo_sync]
