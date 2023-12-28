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

// [START logging_v2_generated_LoggingServiceV2_TailLogEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Logging\V2\LoggingServiceV2Client;
use Google\Cloud\Logging\V2\TailLogEntriesRequest;
use Google\Cloud\Logging\V2\TailLogEntriesResponse;

/**
 * Streaming read of log entries as they are ingested. Until the stream is
 * terminated, it will continue reading logs.
 *
 * @param string $resourceNamesElement Name of a parent resource from which to retrieve log entries:
 *
 *                                     *  `projects/[PROJECT_ID]`
 *                                     *  `organizations/[ORGANIZATION_ID]`
 *                                     *  `billingAccounts/[BILLING_ACCOUNT_ID]`
 *                                     *  `folders/[FOLDER_ID]`
 *
 *                                     May alternatively be one or more views:
 *
 *                                     * `projects/[PROJECT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                     * `organizations/[ORGANIZATION_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                     * `billingAccounts/[BILLING_ACCOUNT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 *                                     * `folders/[FOLDER_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]/views/[VIEW_ID]`
 */
function tail_log_entries_sample(string $resourceNamesElement): void
{
    // Create a client.
    $loggingServiceV2Client = new LoggingServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $resourceNames = [$resourceNamesElement,];
    $request = (new TailLogEntriesRequest())
        ->setResourceNames($resourceNames);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $loggingServiceV2Client->tailLogEntries();
        $stream->writeAll([$request,]);

        /** @var TailLogEntriesResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
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
    $resourceNamesElement = '[RESOURCE_NAMES]';

    tail_log_entries_sample($resourceNamesElement);
}
// [END logging_v2_generated_LoggingServiceV2_TailLogEntries_sync]
