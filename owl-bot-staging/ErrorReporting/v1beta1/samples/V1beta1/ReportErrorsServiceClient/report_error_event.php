<?php
/*
 * Copyright 2022 Google LLC
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
use Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventResponse;
use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ReportedErrorEvent;
use Google\Cloud\ErrorReporting\V1beta1\ServiceContext;

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
 * For more information, see
 * [Using Error Reporting with regionalized
 * logs](/error-reporting/docs/regionalization).
 *
 * @param string $formattedProjectName The resource name of the Google Cloud Platform project. Written
 *                                     as `projects/{projectId}`, where `{projectId}` is the
 *                                     [Google Cloud Platform project
 *                                     ID](https://support.google.com/cloud/answer/6158840).
 *
 *                                     Example: // `projects/my-project-123`. Please see
 *                                     {@see ReportErrorsServiceClient::projectName()} for help formatting this field.
 * @param string $eventMessage         The error message.
 *                                     If no `context.reportLocation` is provided, the message must contain a
 *                                     header (typically consisting of the exception type name and an error
 *                                     message) and an exception stack trace in one of the supported programming
 *                                     languages and formats.
 *                                     Supported languages are Java, Python, JavaScript, Ruby, C#, PHP, and Go.
 *                                     Supported stack trace formats are:
 *
 *                                     * **Java**: Must be the return value of
 *                                     [`Throwable.printStackTrace()`](https://docs.oracle.com/javase/7/docs/api/java/lang/Throwable.html#printStackTrace%28%29).
 *                                     * **Python**: Must be the return value of
 *                                     [`traceback.format_exc()`](https://docs.python.org/2/library/traceback.html#traceback.format_exc).
 *                                     * **JavaScript**: Must be the value of
 *                                     [`error.stack`](https://github.com/v8/v8/wiki/Stack-Trace-API) as returned
 *                                     by V8.
 *                                     * **Ruby**: Must contain frames returned by
 *                                     [`Exception.backtrace`](https://ruby-doc.org/core-2.2.0/Exception.html#method-i-backtrace).
 *                                     * **C#**: Must be the return value of
 *                                     [`Exception.ToString()`](https://msdn.microsoft.com/en-us/library/system.exception.tostring.aspx).
 *                                     * **PHP**: Must start with `PHP (Notice|Parse error|Fatal error|Warning)`
 *                                     and contain the result of
 *                                     [`(string)$exception`](http://php.net/manual/en/exception.tostring.php).
 *                                     * **Go**: Must be the return value of
 *                                     [`runtime.Stack()`](https://golang.org/pkg/runtime/debug/#Stack).
 */
function report_error_event_sample(string $formattedProjectName, string $eventMessage): void
{
    // Create a client.
    $reportErrorsServiceClient = new ReportErrorsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $eventServiceContext = new ServiceContext();
    $event = (new ReportedErrorEvent())
        ->setServiceContext($eventServiceContext)
        ->setMessage($eventMessage);

    // Call the API and handle any network failures.
    try {
        /** @var ReportErrorEventResponse $response */
        $response = $reportErrorsServiceClient->reportErrorEvent($formattedProjectName, $event);
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
    $formattedProjectName = ReportErrorsServiceClient::projectName('[PROJECT]');
    $eventMessage = '[MESSAGE]';

    report_error_event_sample($formattedProjectName, $eventMessage);
}
// [END clouderrorreporting_v1beta1_generated_ReportErrorsService_ReportErrorEvent_sync]
