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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_RunPivotReport_sync]
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunPivotReportResponse;
use Google\ApiCore\ApiException;

/**
 * Returns a customized pivot report of your Google Analytics event data.
 * Pivot reports are more advanced and expressive formats than regular
 * reports. In a pivot report, dimensions are only visible if they are
 * included in a pivot. Multiple pivots can be specified to further dissect
 * your data.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_pivot_report_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Call the API and handle any network failures.
    try {
        /** @var RunPivotReportResponse $response */
        $response = $betaAnalyticsDataClient->runPivotReport();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_RunPivotReport_sync]
