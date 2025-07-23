<?php
/*
 * Copyright 2025 Google LLC
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

// [START spanner_v1_generated_DatabaseAdmin_InternalUpdateGraphOperation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\InternalUpdateGraphOperationRequest;
use Google\Cloud\Spanner\Admin\Database\V1\InternalUpdateGraphOperationResponse;

/**
 * This is an internal API called by Spanner Graph jobs. You should never need
 * to call this API directly.
 *
 * @param string $formattedDatabase Internal field, do not use directly. Please see
 *                                  {@see DatabaseAdminClient::databaseName()} for help formatting this field.
 * @param string $operationId       Internal field, do not use directly.
 * @param string $vmIdentityToken   Internal field, do not use directly.
 */
function internal_update_graph_operation_sample(
    string $formattedDatabase,
    string $operationId,
    string $vmIdentityToken
): void {
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare the request message.
    $request = (new InternalUpdateGraphOperationRequest())
        ->setDatabase($formattedDatabase)
        ->setOperationId($operationId)
        ->setVmIdentityToken($vmIdentityToken);

    // Call the API and handle any network failures.
    try {
        /** @var InternalUpdateGraphOperationResponse $response */
        $response = $databaseAdminClient->internalUpdateGraphOperation($request);
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
    $formattedDatabase = DatabaseAdminClient::databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
    $operationId = '[OPERATION_ID]';
    $vmIdentityToken = '[VM_IDENTITY_TOKEN]';

    internal_update_graph_operation_sample($formattedDatabase, $operationId, $vmIdentityToken);
}
// [END spanner_v1_generated_DatabaseAdmin_InternalUpdateGraphOperation_sync]
