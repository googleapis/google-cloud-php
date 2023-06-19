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

// [START logging_v2_generated_LoggingServiceV2_WriteLogEntries_sync]
use Google\ApiCore\ApiException;
use Google\Api\MonitoredResource;
use Google\Cloud\Logging\V2\LogEntry;
use Google\Cloud\Logging\V2\LoggingServiceV2Client;
use Google\Cloud\Logging\V2\WriteLogEntriesResponse;

/**
 * Writes log entries to Logging. This API method is the
 * only way to send log entries to Logging. This method
 * is used, directly or indirectly, by the Logging agent
 * (fluentd) and all logging libraries configured to use Logging.
 * A single request may contain log entries for a maximum of 1000
 * different resources (projects, organizations, billing accounts or
 * folders)
 *
 * @param string $entriesLogName The resource name of the log to which this log entry belongs:
 *
 *                               "projects/[PROJECT_ID]/logs/[LOG_ID]"
 *                               "organizations/[ORGANIZATION_ID]/logs/[LOG_ID]"
 *                               "billingAccounts/[BILLING_ACCOUNT_ID]/logs/[LOG_ID]"
 *                               "folders/[FOLDER_ID]/logs/[LOG_ID]"
 *
 *                               A project number may be used in place of PROJECT_ID. The project number is
 *                               translated to its corresponding PROJECT_ID internally and the `log_name`
 *                               field will contain PROJECT_ID in queries and exports.
 *
 *                               `[LOG_ID]` must be URL-encoded within `log_name`. Example:
 *                               `"organizations/1234567890/logs/cloudresourcemanager.googleapis.com%2Factivity"`.
 *
 *                               `[LOG_ID]` must be less than 512 characters long and can only include the
 *                               following characters: upper and lower case alphanumeric characters,
 *                               forward-slash, underscore, hyphen, and period.
 *
 *                               For backward compatibility, if `log_name` begins with a forward-slash, such
 *                               as `/projects/...`, then the log entry is ingested as usual, but the
 *                               forward-slash is removed. Listing the log entry will not show the leading
 *                               slash and filtering for a log name with a leading slash will never return
 *                               any results.
 */
function write_log_entries_sample(string $entriesLogName): void
{
    // Create a client.
    $loggingServiceV2Client = new LoggingServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $entriesResource = new MonitoredResource();
    $logEntry = (new LogEntry())
        ->setLogName($entriesLogName)
        ->setResource($entriesResource);
    $entries = [$logEntry,];

    // Call the API and handle any network failures.
    try {
        /** @var WriteLogEntriesResponse $response */
        $response = $loggingServiceV2Client->writeLogEntries($entries);
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
    $entriesLogName = '[LOG_NAME]';

    write_log_entries_sample($entriesLogName);
}
// [END logging_v2_generated_LoggingServiceV2_WriteLogEntries_sync]
