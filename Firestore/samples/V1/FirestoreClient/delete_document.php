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

// [START firestore_v1_generated_Firestore_DeleteDocument_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\V1\FirestoreClient;

/**
 * Deletes a document.
 *
 * @param string $name The resource name of the Document to delete. In the format:
 *                     `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
 */
function delete_document_sample(string $name): void
{
    // Create a client.
    $firestoreClient = new FirestoreClient();

    // Call the API and handle any network failures.
    try {
        $firestoreClient->deleteDocument($name);
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
    $name = '[NAME]';

    delete_document_sample($name);
}
// [END firestore_v1_generated_Firestore_DeleteDocument_sync]
