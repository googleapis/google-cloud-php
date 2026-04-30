<?php
/*
 * Copyright 2026 Google LLC
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

// [START chronicle_v1_generated_NativeDashboardService_RemoveChart_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\NativeDashboardServiceClient;
use Google\Cloud\Chronicle\V1\NativeDashboard;
use Google\Cloud\Chronicle\V1\RemoveChartRequest;

/**
 * Remove chart from a dashboard.
 *
 * @param string $formattedName           The dashboard name to remove chart from.
 *                                        Format:
 *                                        projects/{project}/locations/{location}/instances/{instance}/nativeDashboards/{dashboard}
 *                                        Please see {@see NativeDashboardServiceClient::nativeDashboardName()} for help formatting this field.
 * @param string $formattedDashboardChart The dashboard chart name to remove. Please see
 *                                        {@see NativeDashboardServiceClient::dashboardChartName()} for help formatting this field.
 */
function remove_chart_sample(string $formattedName, string $formattedDashboardChart): void
{
    // Create a client.
    $nativeDashboardServiceClient = new NativeDashboardServiceClient();

    // Prepare the request message.
    $request = (new RemoveChartRequest())
        ->setName($formattedName)
        ->setDashboardChart($formattedDashboardChart);

    // Call the API and handle any network failures.
    try {
        /** @var NativeDashboard $response */
        $response = $nativeDashboardServiceClient->removeChart($request);
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
    $formattedName = NativeDashboardServiceClient::nativeDashboardName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DASHBOARD]'
    );
    $formattedDashboardChart = NativeDashboardServiceClient::dashboardChartName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[CHART]'
    );

    remove_chart_sample($formattedName, $formattedDashboardChart);
}
// [END chronicle_v1_generated_NativeDashboardService_RemoveChart_sync]
