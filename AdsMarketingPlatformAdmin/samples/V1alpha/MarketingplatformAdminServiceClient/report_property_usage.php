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

// [START marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_ReportPropertyUsage_sync]
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ReportPropertyUsageRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ReportPropertyUsageResponse;
use Google\ApiCore\ApiException;

/**
 * Get the usage and billing data for properties within the organization for
 * the specified month.
 *
 * Per direct client org, user needs to be OrgAdmin/BillingAdmin on the
 * organization in order to view the billing and usage data.
 *
 * Per sales partner client org, user needs to be OrgAdmin/BillingAdmin on
 * the sales partner org in order to view the billing and usage data, or
 * OrgAdmin/BillingAdmin on the sales partner client org in order to view the
 * usage data only.
 *
 * @param string $organization Specifies the organization whose property usage will be listed.
 *
 *                             Format: organizations/{org_id}
 * @param string $month        The target month to list property usages.
 *
 *                             Format: YYYY-MM. For example, "2025-05"
 */
function report_property_usage_sample(string $organization, string $month): void
{
    // Create a client.
    $marketingplatformAdminServiceClient = new MarketingplatformAdminServiceClient();

    // Prepare the request message.
    $request = (new ReportPropertyUsageRequest())
        ->setOrganization($organization)
        ->setMonth($month);

    // Call the API and handle any network failures.
    try {
        /** @var ReportPropertyUsageResponse $response */
        $response = $marketingplatformAdminServiceClient->reportPropertyUsage($request);
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
    $organization = '[ORGANIZATION]';
    $month = '[MONTH]';

    report_property_usage_sample($organization, $month);
}
// [END marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_ReportPropertyUsage_sync]
