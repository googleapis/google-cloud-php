<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelReportsService_RunReportJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\CloudChannelReportsServiceClient;
use Google\Cloud\Channel\V1\RunReportJobResponse;
use Google\Rpc\Status;

/**
 * Begins generation of data for a given report. The report
 * identifier is a UID (for example, `613bf59q`).
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The user doesn't have access to this report.
 * * INVALID_ARGUMENT: Required request parameters are missing
 * or invalid.
 * * NOT_FOUND: The report identifier was not found.
 * * INTERNAL: Any non-user error related to a technical issue
 * in the backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue
 * in the backend. Contact Cloud Channel support.
 *
 * Return value:
 * The ID of a long-running operation.
 *
 * To get the results of the operation, call the GetOperation method of
 * CloudChannelOperationsService. The Operation metadata contains an
 * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
 *
 * To get the results of report generation, call
 * [CloudChannelReportsService.FetchReportResults][google.cloud.channel.v1.CloudChannelReportsService.FetchReportResults]
 * with the
 * [RunReportJobResponse.report_job][google.cloud.channel.v1.RunReportJobResponse.report_job].
 *
 * @param string $formattedName The report's resource name. Specifies the account and report used
 *                              to generate report data. The report_id identifier is a UID (for example,
 *                              `613bf59q`).
 *                              Name uses the format:
 *                              accounts/{account_id}/reports/{report_id}
 *                              Please see {@see CloudChannelReportsServiceClient::reportName()} for help formatting this field.
 */
function run_report_job_sample(string $formattedName): void
{
    // Create a client.
    $cloudChannelReportsServiceClient = new CloudChannelReportsServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelReportsServiceClient->runReportJob($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RunReportJobResponse $result */
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
    $formattedName = CloudChannelReportsServiceClient::reportName('[ACCOUNT]', '[REPORT]');

    run_report_job_sample($formattedName);
}
// [END cloudchannel_v1_generated_CloudChannelReportsService_RunReportJob_sync]
