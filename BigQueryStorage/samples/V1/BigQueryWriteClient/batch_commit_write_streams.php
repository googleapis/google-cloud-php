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

// [START bigquerystorage_v1_generated_BigQueryWrite_BatchCommitWriteStreams_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Storage\V1\BatchCommitWriteStreamsResponse;
use Google\Cloud\BigQuery\Storage\V1\BigQueryWriteClient;

/**
 * Atomically commits a group of `PENDING` streams that belong to the same
 * `parent` table.
 *
 * Streams must be finalized before commit and cannot be committed multiple
 * times. Once a stream is committed, data in the stream becomes available
 * for read operations.
 *
 * @param string $formattedParent     Parent table that all the streams should belong to, in the form
 *                                    of `projects/{project}/datasets/{dataset}/tables/{table}`. Please see
 *                                    {@see BigQueryWriteClient::tableName()} for help formatting this field.
 * @param string $writeStreamsElement The group of streams that will be committed atomically.
 */
function batch_commit_write_streams_sample(
    string $formattedParent,
    string $writeStreamsElement
): void {
    // Create a client.
    $bigQueryWriteClient = new BigQueryWriteClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $writeStreams = [$writeStreamsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchCommitWriteStreamsResponse $response */
        $response = $bigQueryWriteClient->batchCommitWriteStreams($formattedParent, $writeStreams);
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
    $formattedParent = BigQueryWriteClient::tableName('[PROJECT]', '[DATASET]', '[TABLE]');
    $writeStreamsElement = '[WRITE_STREAMS]';

    batch_commit_write_streams_sample($formattedParent, $writeStreamsElement);
}
// [END bigquerystorage_v1_generated_BigQueryWrite_BatchCommitWriteStreams_sync]
