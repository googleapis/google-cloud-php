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

// [START appoptimize_v1beta_generated_AppOptimize_CreateReport_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Appoptimize\V1beta\Client\AppOptimizeClient;
use Google\Cloud\Appoptimize\V1beta\CreateReportRequest;
use Google\Cloud\Appoptimize\V1beta\Report;
use Google\Rpc\Status;

/**
 * Creates a new report.
 *
 * This initiates a long-running operation that, upon completion, results
 * in a report resource. Once the report is created, its results can be read
 * via `ReadReport`.
 *
 * @param string $formattedParent         The parent Google Cloud project that will own the report.
 *
 *                                        This value does not define the scope of the report data. See `Report.scope`
 *                                        for setting the data scope.
 *
 *                                        Format: `projects/{project}/locations/{location}`. Please see
 *                                        {@see AppOptimizeClient::locationName()} for help formatting this field.
 * @param string $reportId                The ID to use for this report. This ID must be unique within
 *                                        the parent project and should comply with RFC 1034 restrictions (letters,
 *                                        numbers, and hyphen, with the first character a letter, the last a letter
 *                                        or a number, and a 63 character maximum).
 * @param string $reportDimensionsElement A list of dimensions to include in the report. Supported values:
 *
 *                                        * `project`
 *                                        * `application`
 *                                        * `service_or_workload`
 *                                        * `resource`
 *                                        * `resource_type`
 *                                        * `location`
 *                                        * `product_display_name`
 *                                        * `sku`
 *                                        * `month`
 *                                        * `day`
 *                                        * `hour`
 *
 *                                        To aggregate results by time, specify at least one time dimension
 *                                        (`month`, `day`, or `hour`). All time dimensions use Pacific Time,
 *                                        respect Daylight Saving Time (DST), and follow these ISO 8601 formats:
 *
 *                                        * `month`: `YYYY-MM` (e.g., `2024-01`)
 *                                        * `day`: `YYYY-MM-DD` (e.g., `2024-01-10`)
 *                                        * `hour`: `YYYY-MM-DDTHH` (e.g., `2024-01-10T00`)
 *
 *                                        If the time range filter does not align with the selected time dimension,
 *                                        the range is expanded to encompass the full period of the finest-grained
 *                                        time dimension.
 *
 *                                        For example, if the filter is `2026-01-10` through `2026-01-12` and the
 *                                        `month` dimension is selected, the effective time range expands to include
 *                                        all of January (`2026-01-01` to `2026-02-01`).
 * @param string $reportMetricsElement    A list of metrics to include in the report. Supported values:
 *
 *                                        * `cost`
 *                                        * `cpu_mean_utilization`
 *                                        * `cpu_usage_core_seconds`
 *                                        * `cpu_allocation_core_seconds`
 *                                        * `cpu_p95_utilization`
 *                                        * `memory_mean_utilization`
 *                                        * `memory_usage_byte_seconds`
 *                                        * `memory_allocation_byte_seconds`
 *                                        * `memory_p95_utilization`
 */
function create_report_sample(
    string $formattedParent,
    string $reportId,
    string $reportDimensionsElement,
    string $reportMetricsElement
): void {
    // Create a client.
    $appOptimizeClient = new AppOptimizeClient();

    // Prepare the request message.
    $reportDimensions = [$reportDimensionsElement,];
    $reportMetrics = [$reportMetricsElement,];
    $report = (new Report())
        ->setDimensions($reportDimensions)
        ->setMetrics($reportMetrics);
    $request = (new CreateReportRequest())
        ->setParent($formattedParent)
        ->setReportId($reportId)
        ->setReport($report);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appOptimizeClient->createReport($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Report $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedParent = AppOptimizeClient::locationName('[PROJECT]', '[LOCATION]');
    $reportId = '[REPORT_ID]';
    $reportDimensionsElement = '[DIMENSIONS]';
    $reportMetricsElement = '[METRICS]';

    create_report_sample($formattedParent, $reportId, $reportDimensionsElement, $reportMetricsElement);
}
// [END appoptimize_v1beta_generated_AppOptimize_CreateReport_sync]
