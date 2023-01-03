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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_RunReport_sync]
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportResponse;
use Google\ApiCore\ApiException;

/**
 * Returns a customized report of your Google Analytics event data. Reports
 * contain statistics derived from data collected by the Google Analytics
 * tracking code. The data returned from the API is as a table with columns
 * for the requested dimensions and metrics. Metrics are individual
 * measurements of user activity on your property, such as active users or
 * event count. Dimensions break down metrics across some common criteria,
 * such as country or event name.
 *
 * For a guide to constructing requests & understanding responses, see
 * [Creating a
 * Report](https://developers.google.com/analytics/devguides/reporting/data/v1/basics).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_report_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Call the API and handle any network failures.
    try {
        /** @var RunReportResponse $response */
        $response = $betaAnalyticsDataClient->runReport();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_RunReport_sync]
