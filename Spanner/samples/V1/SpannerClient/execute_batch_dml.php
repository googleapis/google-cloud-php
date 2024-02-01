<?php
/*
 * Copyright 2022 Google LLC
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
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;

/**
 * Executes a batch of SQL DML statements. This method allows many statements
 * to be run with lower latency than submitting them sequentially with
 * [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql].
 *
 * Statements are executed in sequential order. A request can succeed even if
 * a statement fails. The
 * [ExecuteBatchDmlResponse.status][google.spanner.v1.ExecuteBatchDmlResponse.status]
 * field in the response provides information about the statement that failed.
 * Clients must inspect this field to determine whether an error occurred.
 *
 * Execution stops after the first failed statement; the remaining statements
 * are not executed.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function execute_batch_dml_sample(): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare the request message.
    $request = new ExecuteBatchDmlRequest();

    // Call the API and handle any network failures.
    try {
        /** @var ExecuteBatchDmlResponse $response */
        $response = $spannerClient->executeBatchDml($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END spanner_v1_generated_Spanner_ExecuteBatchDml_sync]
