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

// [START bigquerystorage_v1_generated_BigQueryWrite_CreateWriteStream_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Storage\V1\Client\BigQueryWriteClient;
use Google\Cloud\BigQuery\Storage\V1\CreateWriteStreamRequest;
use Google\Cloud\BigQuery\Storage\V1\WriteStream;

/**
 * Creates a write stream to the given table.
 * Additionally, every table has a special stream named '_default'
 * to which data can be written. This stream doesn't need to be created using
 * CreateWriteStream. It is a stream that can be used simultaneously by any
 * number of clients. Data written to this stream is considered committed as
 * soon as an acknowledgement is received.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_write_stream_sample(): void
{
    // Create a client.
    $bigQueryWriteClient = new BigQueryWriteClient();

    // Prepare the request message.
    $request = new CreateWriteStreamRequest();

    // Call the API and handle any network failures.
    try {
        /** @var WriteStream $response */
        $response = $bigQueryWriteClient->createWriteStream($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END bigquerystorage_v1_generated_BigQueryWrite_CreateWriteStream_sync]
