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

// [START datastore_v1_generated_Datastore_Rollback_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Datastore\V1\DatastoreClient;
use Google\Cloud\Datastore\V1\RollbackResponse;

/**
 * Rolls back a transaction.
 *
 * @param string $projectId   The ID of the project against which to make the request.
 * @param string $transaction The transaction identifier, returned by a call to
 *                            [Datastore.BeginTransaction][google.datastore.v1.Datastore.BeginTransaction].
 */
function rollback_sample(string $projectId, string $transaction): void
{
    // Create a client.
    $datastoreClient = new DatastoreClient();

    // Call the API and handle any network failures.
    try {
        /** @var RollbackResponse $response */
        $response = $datastoreClient->rollback($projectId, $transaction);
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
    $projectId = '[PROJECT_ID]';
    $transaction = '...';

    rollback_sample($projectId, $transaction);
}
// [END datastore_v1_generated_Datastore_Rollback_sync]
