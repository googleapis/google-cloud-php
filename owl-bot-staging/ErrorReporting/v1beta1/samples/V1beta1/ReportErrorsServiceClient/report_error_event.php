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

// [START clouderrorreporting_v1beta1_generated_ReportErrorsService_ReportErrorEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ErrorReporting\V1beta1\Client\ReportErrorsServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventRequest;
use Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventResponse;

/**
 * Report an individual error event and record the event to a log.
 *
 * This endpoint accepts **either** an OAuth token,
 * **or** an [API key](https://support.google.com/cloud/answer/6158862)
 * for authentication. To use an API key, append it to the URL as the value of
 * a `key` parameter. For example:
 *
 * `POST
 * https://clouderrorreporting.googleapis.com/v1beta1/{projectName}/events:report?key=123ABC456`
 *
 * **Note:** [Error Reporting](/error-reporting) is a global service built
 * on Cloud Logging and doesn't analyze logs stored
 * in regional log buckets or logs routed to other Google Cloud projects.
 *
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function report_error_event_sample(): void
{
    // Create a client.
    $reportErrorsServiceClient = new ReportErrorsServiceClient();

    // Prepare the request message.
    $request = new ReportErrorEventRequest();

    // Call the API and handle any network failures.
    try {
        /** @var ReportErrorEventResponse $response */
        $response = $reportErrorsServiceClient->reportErrorEvent($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END clouderrorreporting_v1beta1_generated_ReportErrorsService_ReportErrorEvent_sync]
