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

// [START spanner_v1_generated_Spanner_ExecuteStreamingSql_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Like [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], except returns the result
 * set as a stream. Unlike [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], there
 * is no limit on the size of the returned result set. However, no
 * individual row in the result set can exceed 100 MiB, and no
 * column value can exceed 10 MiB.
 *
 * @param string $formattedSession The session in which the SQL query should be performed. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 * @param string $sql              The SQL string.
 */
function execute_streaming_sql_sample(string $formattedSession, string $sql): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $spannerClient->executeStreamingSql($formattedSession, $sql);

        /** @var PartialResultSet $element */
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
    $formattedSession = SpannerClient::sessionName(
        '[PROJECT]',
        '[INSTANCE]',
        '[DATABASE]',
        '[SESSION]'
    );
    $sql = '[SQL]';

    execute_streaming_sql_sample($formattedSession, $sql);
}
// [END spanner_v1_generated_Spanner_ExecuteStreamingSql_sync]
