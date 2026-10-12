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

// [START chronicle_v1_generated_DashboardChartService_BatchGetDashboardCharts_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\BatchGetDashboardChartsRequest;
use Google\Cloud\Chronicle\V1\BatchGetDashboardChartsResponse;
use Google\Cloud\Chronicle\V1\Client\DashboardChartServiceClient;

/**
 * Get dashboard charts in batches.
 *
 * @param string $formattedParent       The parent resource shared by all dashboard charts being
 *                                      retrieved. Format:
 *                                      projects/{project}/locations/{location}/instances/{instance} If this is
 *                                      set, the parent of all of the dashboard charts specified in `names` must
 *                                      match this field. Please see
 *                                      {@see DashboardChartServiceClient::instanceName()} for help formatting this field.
 * @param string $formattedNamesElement The names of the dashboard charts to get. Please see
 *                                      {@see DashboardChartServiceClient::dashboardChartName()} for help formatting this field.
 */
function batch_get_dashboard_charts_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $dashboardChartServiceClient = new DashboardChartServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchGetDashboardChartsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchGetDashboardChartsResponse $response */
        $response = $dashboardChartServiceClient->batchGetDashboardCharts($request);
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
    $formattedParent = DashboardChartServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );
    $formattedNamesElement = DashboardChartServiceClient::dashboardChartName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[CHART]'
    );

    batch_get_dashboard_charts_sample($formattedParent, $formattedNamesElement);
}
// [END chronicle_v1_generated_DashboardChartService_BatchGetDashboardCharts_sync]
