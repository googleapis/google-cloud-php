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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_RunAccessReport_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\RunAccessReportResponse;
use Google\ApiCore\ApiException;

/**
 * Returns a customized report of data access records. The report provides
 * records of each time a user reads Google Analytics reporting data. Access
 * records are retained for up to 2 years.
 *
 * Data Access Reports can be requested for a property. The property must be
 * in Google Analytics 360. This method is only available to Administrators.
 *
 * These data access records include GA4 UI Reporting, GA4 UI Explorations,
 * GA4 Data API, and other products like Firebase & Admob that can retrieve
 * data from Google Analytics through a linkage. These records don't include
 * property configuration changes like adding a stream or changing a
 * property's time zone. For configuration change history, see
 * [searchChangeHistoryEvents](https://developers.google.com/analytics/devguides/config/admin/v1/rest/v1alpha/accounts/searchChangeHistoryEvents).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_access_report_sample(): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var RunAccessReportResponse $response */
        $response = $analyticsAdminServiceClient->runAccessReport();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_RunAccessReport_sync]
