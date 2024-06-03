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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_RunFunnelReport_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\RunFunnelReportRequest;
use Google\Analytics\Data\V1alpha\RunFunnelReportResponse;
use Google\ApiCore\ApiException;

/**
 * Returns a customized funnel report of your Google Analytics event data. The
 * data returned from the API is as a table with columns for the requested
 * dimensions and metrics.
 *
 * Funnel exploration lets you visualize the steps your users take to complete
 * a task and quickly see how well they are succeeding or failing at each
 * step. For example, how do prospects become shoppers and then become buyers?
 * How do one time buyers become repeat buyers? With this information, you can
 * improve inefficient or abandoned customer journeys. To learn more, see [GA4
 * Funnel Explorations](https://support.google.com/analytics/answer/9327974).
 *
 * This method is introduced at alpha stability with the intention of
 * gathering feedback on syntax and capabilities before entering beta. To give
 * your feedback on this API, complete the [Google Analytics Data API Funnel
 * Reporting
 * Feedback](https://docs.google.com/forms/d/e/1FAIpQLSdwOlQDJAUoBiIgUZZ3S_Lwi8gr7Bb0k1jhvc-DEg7Rol3UjA/viewform).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function run_funnel_report_sample(): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = new RunFunnelReportRequest();

    // Call the API and handle any network failures.
    try {
        /** @var RunFunnelReportResponse $response */
        $response = $alphaAnalyticsDataClient->runFunnelReport($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_RunFunnelReport_sync]
