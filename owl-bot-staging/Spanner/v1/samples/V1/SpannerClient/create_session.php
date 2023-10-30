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

// [START spanner_v1_generated_Spanner_CreateSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\Session;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Creates a new session. A session can be used to perform
 * transactions that read and/or modify data in a Cloud Spanner database.
 * Sessions are meant to be reused for many consecutive
 * transactions.
 *
 * Sessions can only execute one transaction at a time. To execute
 * multiple concurrent read-write/write-only transactions, create
 * multiple sessions. Note that standalone reads and queries use a
 * transaction internally, and count toward the one transaction
 * limit.
 *
 * Active sessions use additional server resources, so it is a good idea to
 * delete idle and unneeded sessions.
 * Aside from explicit deletes, Cloud Spanner may delete sessions for which no
 * operations are sent for more than an hour. If a session is deleted,
 * requests to it return `NOT_FOUND`.
 *
 * Idle sessions can be kept alive by sending a trivial SQL query
 * periodically, e.g., `"SELECT 1"`.
 *
 * @param string $formattedDatabase The database in which the new session is created. Please see
 *                                  {@see SpannerClient::databaseName()} for help formatting this field.
 */
function create_session_sample(string $formattedDatabase): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Call the API and handle any network failures.
    try {
        /** @var Session $response */
        $response = $spannerClient->createSession($formattedDatabase);
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
    $formattedDatabase = SpannerClient::databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');

    create_session_sample($formattedDatabase);
}
// [END spanner_v1_generated_Spanner_CreateSession_sync]
