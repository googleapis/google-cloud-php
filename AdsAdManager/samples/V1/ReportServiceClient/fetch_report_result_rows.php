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

// [START admanager_v1_generated_ReportService_FetchReportResultRows_sync]
use Google\Ads\AdManager\V1\Client\ReportServiceClient;
use Google\Ads\AdManager\V1\FetchReportResultRowsRequest;
use Google\Ads\AdManager\V1\FetchReportResultRowsResponse;
use Google\ApiCore\ApiException;

/**
 * Returns the result rows from a completed report.
 * The caller must have previously called `RunReport` and waited for that
 * operation to complete. The rows will be returned according to the order
 * specified by the `sorts` member of the report definition.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function fetch_report_result_rows_sample(): void
{
    // Create a client.
    $reportServiceClient = new ReportServiceClient();

    // Prepare the request message.
    $request = new FetchReportResultRowsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var FetchReportResultRowsResponse $response */
        $response = $reportServiceClient->fetchReportResultRows($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END admanager_v1_generated_ReportService_FetchReportResultRows_sync]
