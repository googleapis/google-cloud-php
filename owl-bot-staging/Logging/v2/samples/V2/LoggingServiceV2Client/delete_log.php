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

// [START logging_v2_generated_LoggingServiceV2_DeleteLog_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\LoggingServiceV2Client;

/**
 * Deletes all the log entries in a log for the _Default Log Bucket. The log
 * reappears if it receives new entries. Log entries written shortly before
 * the delete operation might not be deleted. Entries received after the
 * delete operation with a timestamp before the operation will be deleted.
 *
 * @param string $formattedLogName The resource name of the log to delete:
 *
 *                                 * `projects/[PROJECT_ID]/logs/[LOG_ID]`
 *                                 * `organizations/[ORGANIZATION_ID]/logs/[LOG_ID]`
 *                                 * `billingAccounts/[BILLING_ACCOUNT_ID]/logs/[LOG_ID]`
 *                                 * `folders/[FOLDER_ID]/logs/[LOG_ID]`
 *
 *                                 `[LOG_ID]` must be URL-encoded. For example,
 *                                 `"projects/my-project-id/logs/syslog"`,
 *                                 `"organizations/123/logs/cloudaudit.googleapis.com%2Factivity"`.
 *
 *                                 For more information about log names, see
 *                                 [LogEntry][google.logging.v2.LogEntry]. Please see
 *                                 {@see LoggingServiceV2Client::logName()} for help formatting this field.
 */
function delete_log_sample(string $formattedLogName): void
{
    // Create a client.
    $loggingServiceV2Client = new LoggingServiceV2Client();

    // Call the API and handle any network failures.
    try {
        $loggingServiceV2Client->deleteLog($formattedLogName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedLogName = LoggingServiceV2Client::logName('[PROJECT]', '[LOG]');

    delete_log_sample($formattedLogName);
}
// [END logging_v2_generated_LoggingServiceV2_DeleteLog_sync]
