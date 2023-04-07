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

// [START logging_v2_generated_LoggingServiceV2_ListLogEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Logging\V2\LogEntry;
use Google\Cloud\Logging\V2\LoggingServiceV2Client;

/**
 * Lists log entries.  Use this method to retrieve log entries that originated
 * from a project/folder/organization/billing account.  For ways to export log
 * entries, see [Exporting
 * Logs](https://cloud.google.com/logging/docs/export).
 *
 * @param string $formattedResourceNamesElement Names of one or more parent resources from which to
 *                                              retrieve log entries:
 *
 *                                              *  `projects/[PROJECT_ID]`
 *                                              *  `organizations/[ORGANIZATION_ID]`
 *                                              *  `billingAccounts/[BILLING_ACCOUNT_ID]`
 *                                              *  `folders/[FOLDER_ID]`
 *
 *                                              May alternatively be one or more views:
 *
 *                                              * `projects/[PROJECT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                              * `organizations/[ORGANIZATION_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                              * `billingAccounts/[BILLING_ACCOUNT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                              * `folders/[FOLDER_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *
 *                                              Projects listed in the `project_ids` field are added to this list. Please see
 *                                              {@see LoggingServiceV2Client::projectName()} for help formatting this field.
 */
function list_log_entries_sample(string $formattedResourceNamesElement): void
{
    // Create a client.
    $loggingServiceV2Client = new LoggingServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedResourceNames = [$formattedResourceNamesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $loggingServiceV2Client->listLogEntries($formattedResourceNames);

        /** @var LogEntry $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedResourceNamesElement = LoggingServiceV2Client::projectName('[PROJECT]');

    list_log_entries_sample($formattedResourceNamesElement);
}
// [END logging_v2_generated_LoggingServiceV2_ListLogEntries_sync]
