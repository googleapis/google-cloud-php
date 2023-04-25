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

// [START bigquerystorage_v1_generated_BigQueryWrite_FinalizeWriteStream_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Storage\V1\BigQueryWriteClient;
use Google\Cloud\BigQuery\Storage\V1\FinalizeWriteStreamResponse;

/**
 * Finalize a write stream so that no new data can be appended to the
 * stream. Finalize is not supported on the '_default' stream.
 *
 * @param string $formattedName Name of the stream to finalize, in the form of
 *                              `projects/{project}/datasets/{dataset}/tables/{table}/streams/{stream}`. Please see
 *                              {@see BigQueryWriteClient::writeStreamName()} for help formatting this field.
 */
function finalize_write_stream_sample(string $formattedName): void
{
    // Create a client.
    $bigQueryWriteClient = new BigQueryWriteClient();

    // Call the API and handle any network failures.
    try {
        /** @var FinalizeWriteStreamResponse $response */
        $response = $bigQueryWriteClient->finalizeWriteStream($formattedName);
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
    $formattedName = BigQueryWriteClient::writeStreamName(
        '[PROJECT]',
        '[DATASET]',
        '[TABLE]',
        '[STREAM]'
    );

    finalize_write_stream_sample($formattedName);
}
// [END bigquerystorage_v1_generated_BigQueryWrite_FinalizeWriteStream_sync]
