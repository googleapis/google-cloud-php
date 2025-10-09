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

// [START admanager_v1_generated_ReportService_UpdateReport_sync]
use Google\Ads\AdManager\V1\Client\ReportServiceClient;
use Google\Ads\AdManager\V1\Report;
use Google\Ads\AdManager\V1\ReportDefinition;
use Google\Ads\AdManager\V1\Report\DateRange;
use Google\Ads\AdManager\V1\Report\Dimension;
use Google\Ads\AdManager\V1\Report\Metric;
use Google\Ads\AdManager\V1\Report\ReportType;
use Google\Ads\AdManager\V1\UpdateReportRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to update a `Report` object.
 *
 * @param int $reportReportDefinitionDimensionsElement The list of dimensions to report on. If empty, the report will
 *                                                     have no dimensions, and any metrics will be totals.
 * @param int $reportReportDefinitionMetricsElement    The list of metrics to report on. If empty, the report will have
 *                                                     no metrics.
 * @param int $reportReportDefinitionReportType        The type of this report.
 */
function update_report_sample(
    int $reportReportDefinitionDimensionsElement,
    int $reportReportDefinitionMetricsElement,
    int $reportReportDefinitionReportType
): void {
    // Create a client.
    $reportServiceClient = new ReportServiceClient();

    // Prepare the request message.
    $reportReportDefinitionDimensions = [$reportReportDefinitionDimensionsElement,];
    $reportReportDefinitionMetrics = [$reportReportDefinitionMetricsElement,];
    $reportReportDefinitionDateRange = new DateRange();
    $reportReportDefinition = (new ReportDefinition())
        ->setDimensions($reportReportDefinitionDimensions)
        ->setMetrics($reportReportDefinitionMetrics)
        ->setDateRange($reportReportDefinitionDateRange)
        ->setReportType($reportReportDefinitionReportType);
    $report = (new Report())
        ->setReportDefinition($reportReportDefinition);
    $updateMask = new FieldMask();
    $request = (new UpdateReportRequest())
        ->setReport($report)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Report $response */
        $response = $reportServiceClient->updateReport($request);
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
    $reportReportDefinitionDimensionsElement = Dimension::DIMENSION_UNSPECIFIED;
    $reportReportDefinitionMetricsElement = Metric::METRIC_UNSPECIFIED;
    $reportReportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;

    update_report_sample(
        $reportReportDefinitionDimensionsElement,
        $reportReportDefinitionMetricsElement,
        $reportReportDefinitionReportType
    );
}
// [END admanager_v1_generated_ReportService_UpdateReport_sync]
