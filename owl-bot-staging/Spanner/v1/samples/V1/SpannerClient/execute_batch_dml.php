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

// [START spanner_v1_generated_Spanner_ExecuteBatchDml_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest\Statement;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Spanner\V1\TransactionSelector;

/**
 * Executes a batch of SQL DML statements. This method allows many statements
 * to be run with lower latency than submitting them sequentially with
 * [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql].
 *
 * Statements are executed in sequential order. A request can succeed even if
 * a statement fails. The [ExecuteBatchDmlResponse.status][google.spanner.v1.ExecuteBatchDmlResponse.status] field in the
 * response provides information about the statement that failed. Clients must
 * inspect this field to determine whether an error occurred.
 *
 * Execution stops after the first failed statement; the remaining statements
 * are not executed.
 *
 * @param string $formattedSession The session in which the DML statements should be performed. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 * @param string $statementsSql    The DML string.
 * @param int    $seqno            A per-transaction sequence number used to identify this request. This field
 *                                 makes each request idempotent such that if the request is received multiple
 *                                 times, at most one will succeed.
 *
 *                                 The sequence number must be monotonically increasing within the
 *                                 transaction. If a request arrives for the first time with an out-of-order
 *                                 sequence number, the transaction may be aborted. Replays of previously
 *                                 handled requests will yield the same response as the first execution.
 */
function execute_batch_dml_sample(
    string $formattedSession,
    string $statementsSql,
    int $seqno
): void {
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $transaction = new TransactionSelector();
    $statement = (new Statement())
        ->setSql($statementsSql);
    $statements = [$statement,];

    // Call the API and handle any network failures.
    try {
        /** @var ExecuteBatchDmlResponse $response */
        $response = $spannerClient->executeBatchDml($formattedSession, $transaction, $statements, $seqno);
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
    $statementsSql = '[SQL]';
    $seqno = 0;

    execute_batch_dml_sample($formattedSession, $statementsSql, $seqno);
}
// [END spanner_v1_generated_Spanner_ExecuteBatchDml_sync]
