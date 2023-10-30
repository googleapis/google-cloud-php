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

// [START spanner_v1_generated_Spanner_Commit_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Commits a transaction. The request includes the mutations to be
 * applied to rows in the database.
 *
 * `Commit` might return an `ABORTED` error. This can occur at any time;
 * commonly, the cause is conflicts with concurrent
 * transactions. However, it can also happen for a variety of other
 * reasons. If `Commit` returns `ABORTED`, the caller should re-attempt
 * the transaction from the beginning, re-using the same session.
 *
 * On very rare occasions, `Commit` might return `UNKNOWN`. This can happen,
 * for example, if the client job experiences a 1+ hour networking failure.
 * At that point, Cloud Spanner has lost track of the transaction outcome and
 * we recommend that you perform another read from the database to see the
 * state of things as they are now.
 *
 * @param string $formattedSession The session in which the transaction to be committed is running. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 */
function commit_sample(string $formattedSession): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $mutations = [new Mutation()];

    // Call the API and handle any network failures.
    try {
        /** @var CommitResponse $response */
        $response = $spannerClient->commit($formattedSession, $mutations);
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

    commit_sample($formattedSession);
}
// [END spanner_v1_generated_Spanner_Commit_sync]
