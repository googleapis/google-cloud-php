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

// [START spanner_v1_generated_Spanner_BeginTransaction_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Spanner\V1\Transaction;
use Google\Cloud\Spanner\V1\TransactionOptions;

/**
 * Begins a new transaction. This step can often be skipped:
 * [Read][google.spanner.v1.Spanner.Read], [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] and
 * [Commit][google.spanner.v1.Spanner.Commit] can begin a new transaction as a
 * side-effect.
 *
 * @param string $formattedSession The session in which the transaction runs. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 */
function begin_transaction_sample(string $formattedSession): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $options = new TransactionOptions();

    // Call the API and handle any network failures.
    try {
        /** @var Transaction $response */
        $response = $spannerClient->beginTransaction($formattedSession, $options);
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

    begin_transaction_sample($formattedSession);
}
// [END spanner_v1_generated_Spanner_BeginTransaction_sync]
