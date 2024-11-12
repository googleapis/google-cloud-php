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

// [START admanager_v1_generated_ReportService_RunReport_sync]
use Google\Ads\AdManager\V1\Client\ReportServiceClient;
use Google\Ads\AdManager\V1\RunReportRequest;
use Google\Ads\AdManager\V1\RunReportResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Rpc\Status;

/**
 * Initiates the execution of an existing report asynchronously. Users can
 * get the report by polling this operation via
 * `OperationsService.GetOperation`.
 * Poll every 5 seconds initially, with an exponential
 * backoff. Once a report is complete, the operation will contain a
 * `RunReportResponse` in its response field containing a report_result that
 * can be passed to the `FetchReportResultRows` method to retrieve the report
 * data.
 *
 * @param string $formattedName The report to run.
 *                              Format: `networks/{network_code}/reports/{report_id}`
 *                              Please see {@see ReportServiceClient::reportName()} for help formatting this field.
 */
function run_report_sample(string $formattedName): void
{
    // Create a client.
    $reportServiceClient = new ReportServiceClient();

    // Prepare the request message.
    $request = (new RunReportRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $reportServiceClient->runReport($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RunReportResponse $result */
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
    $formattedName = ReportServiceClient::reportName('[NETWORK_CODE]', '[REPORT]');

    run_report_sample($formattedName);
}
// [END admanager_v1_generated_ReportService_RunReport_sync]
