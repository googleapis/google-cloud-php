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

// [START spanner_v1_generated_Spanner_PartitionRead_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\KeySet;
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Creates a set of partition tokens that can be used to execute a read
 * operation in parallel.  Each of the returned partition tokens can be used
 * by [StreamingRead][google.spanner.v1.Spanner.StreamingRead] to specify a subset of the read
 * result to read.  The same session and read-only transaction must be used by
 * the PartitionReadRequest used to create the partition tokens and the
 * ReadRequests that use the partition tokens.  There are no ordering
 * guarantees on rows returned among the returned partition tokens, or even
 * within each individual StreamingRead call issued with a partition_token.
 *
 * Partition tokens become invalid when the session used to create them
 * is deleted, is idle for too long, begins a new transaction, or becomes too
 * old.  When any of these happen, it is not possible to resume the read, and
 * the whole operation must be restarted from the beginning.
 *
 * @param string $formattedSession The session used to create the partitions. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 * @param string $table            The name of the table in the database to be read.
 */
function partition_read_sample(string $formattedSession, string $table): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $keySet = new KeySet();

    // Call the API and handle any network failures.
    try {
        /** @var PartitionResponse $response */
        $response = $spannerClient->partitionRead($formattedSession, $table, $keySet);
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
    $table = '[TABLE]';

    partition_read_sample($formattedSession, $table);
}
// [END spanner_v1_generated_Spanner_PartitionRead_sync]
