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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetReportTask_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\GetReportTaskRequest;
use Google\Analytics\Data\V1alpha\ReportTask;
use Google\ApiCore\ApiException;

/**
 * Gets report metadata about a specific report task. After creating a report
 * task, use this method to check its processing state or inspect its
 * report definition.
 *
 * @param string $formattedName The report task resource name.
 *                              Format: `properties/{property}/reportTasks/{report_task}`
 *                              Please see {@see AlphaAnalyticsDataClient::reportTaskName()} for help formatting this field.
 */
function get_report_task_sample(string $formattedName): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new GetReportTaskRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ReportTask $response */
        $response = $alphaAnalyticsDataClient->getReportTask($request);
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
    $formattedName = AlphaAnalyticsDataClient::reportTaskName('[PROPERTY]', '[REPORT_TASK]');

    get_report_task_sample($formattedName);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetReportTask_sync]
