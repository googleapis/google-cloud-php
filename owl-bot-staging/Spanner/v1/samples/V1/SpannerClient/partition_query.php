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

// [START spanner_v1_generated_Spanner_PartitionQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Creates a set of partition tokens that can be used to execute a query
 * operation in parallel.  Each of the returned partition tokens can be used
 * by [ExecuteStreamingSql][google.spanner.v1.Spanner.ExecuteStreamingSql] to specify a subset
 * of the query result to read.  The same session and read-only transaction
 * must be used by the PartitionQueryRequest used to create the
 * partition tokens and the ExecuteSqlRequests that use the partition tokens.
 *
 * Partition tokens become invalid when the session used to create them
 * is deleted, is idle for too long, begins a new transaction, or becomes too
 * old.  When any of these happen, it is not possible to resume the query, and
 * the whole operation must be restarted from the beginning.
 *
 * @param string $formattedSession The session used to create the partitions. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 * @param string $sql              The query request to generate partitions for. The request will fail if
 *                                 the query is not root partitionable. The query plan of a root
 *                                 partitionable query has a single distributed union operator. A distributed
 *                                 union operator conceptually divides one or more tables into multiple
 *                                 splits, remotely evaluates a subquery independently on each split, and
 *                                 then unions all results.
 *
 *                                 This must not contain DML commands, such as INSERT, UPDATE, or
 *                                 DELETE. Use [ExecuteStreamingSql][google.spanner.v1.Spanner.ExecuteStreamingSql] with a
 *                                 PartitionedDml transaction for large, partition-friendly DML operations.
 */
function partition_query_sample(string $formattedSession, string $sql): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Call the API and handle any network failures.
    try {
        /** @var PartitionResponse $response */
        $response = $spannerClient->partitionQuery($formattedSession, $sql);
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
    $formattedSession = SpannerClient::sessionName(
        '[PROJECT]',
        '[INSTANCE]',
        '[DATABASE]',
        '[SESSION]'
    );
    $sql = '[SQL]';

    partition_query_sample($formattedSession, $sql);
}
// [END spanner_v1_generated_Spanner_PartitionQuery_sync]
