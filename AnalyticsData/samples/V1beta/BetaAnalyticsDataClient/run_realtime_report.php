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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_RunRealtimeReport_sync]
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;
use Google\Analytics\Data\V1beta\RunRealtimeReportResponse;
use Google\ApiCore\ApiException;

/**
 * Returns a customized report of realtime event data for your property.
 * Events appear in realtime reports seconds after they have been sent to
 * the Google Analytics. Realtime reports show events and usage data for the
 * periods of time ranging from the present moment to 30 minutes ago (up to
 * 60 minutes for Google Analytics 360 properties).
 *
 * For a guide to constructing realtime requests & understanding responses,
 * see [Creating a Realtime
 * Report](https://developers.google.com/analytics/devguides/reporting/data/v1/realtime-basics).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_realtime_report_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $request = new RunRealtimeReportRequest();

    // Call the API and handle any network failures.
    try {
        /** @var RunRealtimeReportResponse $response */
        $response = $betaAnalyticsDataClient->runRealtimeReport($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_RunRealtimeReport_sync]
