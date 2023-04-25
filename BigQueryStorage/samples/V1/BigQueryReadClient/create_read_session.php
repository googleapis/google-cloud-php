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

// [START bigquerystorage_v1_generated_BigQueryRead_CreateReadSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Storage\V1\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\ReadSession;

/**
 * Creates a new read session. A read session divides the contents of a
 * BigQuery table into one or more streams, which can then be used to read
 * data from the table. The read session also specifies properties of the
 * data to be read, such as a list of columns or a push-down filter describing
 * the rows to be returned.
 *
 * A particular row can be read by at most one stream. When the caller has
 * reached the end of each stream in the session, then all the data in the
 * table has been read.
 *
 * Data is assigned to each stream such that roughly the same number of
 * rows can be read from each stream. Because the server-side unit for
 * assigning data is collections of rows, the API does not guarantee that
 * each stream will return the same number or rows. Additionally, the
 * limits are enforced based on the number of pre-filtered rows, so some
 * filters can lead to lopsided assignments.
 *
 * Read sessions automatically expire 6 hours after they are created and do
 * not require manual clean-up by the caller.
 *
 * @param string $formattedParent The request project that owns the session, in the form of
 *                                `projects/{project_id}`. Please see
 *                                {@see BigQueryReadClient::projectName()} for help formatting this field.
 */
function create_read_session_sample(string $formattedParent): void
{
    // Create a client.
    $bigQueryReadClient = new BigQueryReadClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $readSession = new ReadSession();

    // Call the API and handle any network failures.
    try {
        /** @var ReadSession $response */
        $response = $bigQueryReadClient->createReadSession($formattedParent, $readSession);
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
    $formattedParent = BigQueryReadClient::projectName('[PROJECT]');

    create_read_session_sample($formattedParent);
}
// [END bigquerystorage_v1_generated_BigQueryRead_CreateReadSession_sync]
