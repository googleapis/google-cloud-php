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

// [START firestore_v1_generated_Firestore_Commit_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\FirestoreClient;
use Google\Cloud\Firestore\V1\Write;

/**
 * Commits a transaction, while optionally updating documents.
 *
 * @param string $database The database name. In the format:
 *                         `projects/{project_id}/databases/{database_id}`.
 */
function commit_sample(string $database): void
{
    // Create a client.
    $firestoreClient = new FirestoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $writes = [new Write()];

    // Call the API and handle any network failures.
    try {
        /** @var CommitResponse $response */
        $response = $firestoreClient->commit($database, $writes);
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
    $database = '[DATABASE]';

    commit_sample($database);
}
// [END firestore_v1_generated_Firestore_Commit_sync]
