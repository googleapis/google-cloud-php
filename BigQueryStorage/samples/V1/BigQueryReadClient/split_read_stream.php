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

// [START bigquerystorage_v1_generated_BigQueryRead_SplitReadStream_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Storage\V1\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\SplitReadStreamResponse;

/**
 * Splits a given `ReadStream` into two `ReadStream` objects. These
 * `ReadStream` objects are referred to as the primary and the residual
 * streams of the split. The original `ReadStream` can still be read from in
 * the same manner as before. Both of the returned `ReadStream` objects can
 * also be read from, and the rows returned by both child streams will be
 * the same as the rows read from the original stream.
 *
 * Moreover, the two child streams will be allocated back-to-back in the
 * original `ReadStream`. Concretely, it is guaranteed that for streams
 * original, primary, and residual, that original[0-j] = primary[0-j] and
 * original[j-n] = residual[0-m] once the streams have been read to
 * completion.
 *
 * @param string $formattedName Name of the stream to split. Please see
 *                              {@see BigQueryReadClient::readStreamName()} for help formatting this field.
 */
function split_read_stream_sample(string $formattedName): void
{
    // Create a client.
    $bigQueryReadClient = new BigQueryReadClient();

    // Call the API and handle any network failures.
    try {
        /** @var SplitReadStreamResponse $response */
        $response = $bigQueryReadClient->splitReadStream($formattedName);
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
    $formattedName = BigQueryReadClient::readStreamName(
        '[PROJECT]',
        '[LOCATION]',
        '[SESSION]',
        '[STREAM]'
    );

    split_read_stream_sample($formattedName);
}
// [END bigquerystorage_v1_generated_BigQueryRead_SplitReadStream_sync]
