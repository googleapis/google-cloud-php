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

// [START bigquerystorage_v1_generated_BigQueryWrite_AppendRows_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\BigQuery\Storage\V1\AppendRowsRequest;
use Google\Cloud\BigQuery\Storage\V1\AppendRowsResponse;
use Google\Cloud\BigQuery\Storage\V1\BigQueryWriteClient;

/**
 * Appends data to the given stream.
 *
 * If `offset` is specified, the `offset` is checked against the end of
 * stream. The server returns `OUT_OF_RANGE` in `AppendRowsResponse` if an
 * attempt is made to append to an offset beyond the current end of the stream
 * or `ALREADY_EXISTS` if user provides an `offset` that has already been
 * written to. User can retry with adjusted offset within the same RPC
 * connection. If `offset` is not specified, append happens at the end of the
 * stream.
 *
 * The response contains an optional offset at which the append
 * happened.  No offset information will be returned for appends to a
 * default stream.
 *
 * Responses are received in the same order in which requests are sent.
 * There will be one response for each successful inserted request.  Responses
 * may optionally embed error information if the originating AppendRequest was
 * not successfully processed.
 *
 * The specifics of when successfully appended data is made visible to the
 * table are governed by the type of stream:
 *
 * * For COMMITTED streams (which includes the default stream), data is
 * visible immediately upon successful append.
 *
 * * For BUFFERED streams, data is made visible via a subsequent `FlushRows`
 * rpc which advances a cursor to a newer offset in the stream.
 *
 * * For PENDING streams, data is not made visible until the stream itself is
 * finalized (via the `FinalizeWriteStream` rpc), and the stream is explicitly
 * committed via the `BatchCommitWriteStreams` rpc.
 *
 * @param string $formattedWriteStream The write_stream identifies the target of the append operation,
 *                                     and only needs to be specified as part of the first request on the gRPC
 *                                     connection. If provided for subsequent requests, it must match the value of
 *                                     the first request.
 *
 *                                     For explicitly created write streams, the format is:
 *
 *                                     * `projects/{project}/datasets/{dataset}/tables/{table}/streams/{id}`
 *
 *                                     For the special default stream, the format is:
 *
 *                                     * `projects/{project}/datasets/{dataset}/tables/{table}/streams/_default`. Please see
 *                                     {@see BigQueryWriteClient::writeStreamName()} for help formatting this field.
 */
function append_rows_sample(string $formattedWriteStream): void
{
    // Create a client.
    $bigQueryWriteClient = new BigQueryWriteClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $request = (new AppendRowsRequest())
        ->setWriteStream($formattedWriteStream);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $bigQueryWriteClient->appendRows();
        $stream->writeAll([$request,]);

        /** @var AppendRowsResponse $element */
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
    $formattedWriteStream = BigQueryWriteClient::writeStreamName(
        '[PROJECT]',
        '[DATASET]',
        '[TABLE]',
        '[STREAM]'
    );

    append_rows_sample($formattedWriteStream);
}
// [END bigquerystorage_v1_generated_BigQueryWrite_AppendRows_sync]
