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

// [START spanner_v1_generated_Spanner_BatchCreateSessions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\BatchCreateSessionsResponse;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Creates multiple new sessions.
 *
 * This API can be used to initialize a session cache on the clients.
 * See https://goo.gl/TgSFN2 for best practices on session cache management.
 *
 * @param string $formattedDatabase The database in which the new sessions are created. Please see
 *                                  {@see SpannerClient::databaseName()} for help formatting this field.
 * @param int    $sessionCount      The number of sessions to be created in this batch call.
 *                                  The API may return fewer than the requested number of sessions. If a
 *                                  specific number of sessions are desired, the client can make additional
 *                                  calls to BatchCreateSessions (adjusting
 *                                  [session_count][google.spanner.v1.BatchCreateSessionsRequest.session_count] as necessary).
 */
function batch_create_sessions_sample(string $formattedDatabase, int $sessionCount): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateSessionsResponse $response */
        $response = $spannerClient->batchCreateSessions($formattedDatabase, $sessionCount);
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
    $sessionCount = 0;

    batch_create_sessions_sample($formattedDatabase, $sessionCount);
}
// [END spanner_v1_generated_Spanner_BatchCreateSessions_sync]
