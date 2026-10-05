<?php
/*
 * Copyright 2026 Google LLC
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

// [START longrunning_generated_Operations_WaitOperation_sync]
use Google\ApiCore\ApiException;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\Operation;
use Google\LongRunning\WaitOperationRequest;

/**
 * Waits until the specified long-running operation is done or reaches at most
 * a specified timeout, returning the latest state.  If the operation is
 * already done, the latest state is immediately returned.  If the timeout
 * specified is greater than the default HTTP/RPC timeout, the HTTP/RPC
 * timeout is used.  If the server does not support this method, it returns
 * `google.rpc.Code.UNIMPLEMENTED`.
 * Note that this method is on a best-effort basis.  It may return the latest
 * state before the specified timeout (including immediately), meaning even an
 * immediate response is no guarantee that the operation is done.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function wait_operation_sample(): void
{
    // Create a client.
    $operationsClient = new OperationsClient();

    // Prepare the request message.
    $request = new WaitOperationRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $operationsClient->waitOperation($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END longrunning_generated_Operations_WaitOperation_sync]
