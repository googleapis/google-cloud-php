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

// [START spanner_v1_generated_Spanner_Rollback_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Rolls back a transaction, releasing any locks it holds. It is a good
 * idea to call this for any transaction that includes one or more
 * [Read][google.spanner.v1.Spanner.Read] or [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] requests and
 * ultimately decides not to commit.
 *
 * `Rollback` returns `OK` if it successfully aborts the transaction, the
 * transaction was already aborted, or the transaction is not
 * found. `Rollback` never returns `ABORTED`.
 *
 * @param string $formattedSession The session in which the transaction to roll back is running. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 * @param string $transactionId    The transaction to roll back.
 */
function rollback_sample(string $formattedSession, string $transactionId): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Call the API and handle any network failures.
    try {
        $spannerClient->rollback($formattedSession, $transactionId);
        printf('Call completed successfully.' . PHP_EOL);
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
    $transactionId = '...';

    rollback_sample($formattedSession, $transactionId);
}
// [END spanner_v1_generated_Spanner_Rollback_sync]
