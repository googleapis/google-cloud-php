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

// [START bigquerystorage_v1_generated_BigQueryRead_ReadRows_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\BigQuery\Storage\V1\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsResponse;

/**
 * Reads rows from the stream in the format prescribed by the ReadSession.
 * Each response contains one or more table rows, up to a maximum of 100 MiB
 * per response; read requests which attempt to read individual rows larger
 * than 100 MiB will fail.
 *
 * Each request also returns a set of stream statistics reflecting the current
 * state of the stream.
 *
 * @param string $formattedReadStream Stream to read rows from. Please see
 *                                    {@see BigQueryReadClient::readStreamName()} for help formatting this field.
 */
function read_rows_sample(string $formattedReadStream): void
{
    // Create a client.
    $bigQueryReadClient = new BigQueryReadClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $bigQueryReadClient->readRows($formattedReadStream);

        /** @var ReadRowsResponse $element */
        foreach ($stream->readAll() as $element) {
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
    $formattedReadStream = BigQueryReadClient::readStreamName(
        '[PROJECT]',
        '[LOCATION]',
        '[SESSION]',
        '[STREAM]'
    );

    read_rows_sample($formattedReadStream);
}
// [END bigquerystorage_v1_generated_BigQueryRead_ReadRows_sync]
