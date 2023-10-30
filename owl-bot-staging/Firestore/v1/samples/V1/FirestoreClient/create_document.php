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

// [START firestore_v1_generated_Firestore_CreateDocument_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\FirestoreClient;

/**
 * Creates a new document.
 *
 * @param string $parent       The parent resource. For example:
 *                             `projects/{project_id}/databases/{database_id}/documents` or
 *                             `projects/{project_id}/databases/{database_id}/documents/chatrooms/{chatroom_id}`
 * @param string $collectionId The collection ID, relative to `parent`, to list. For example:
 *                             `chatrooms`.
 * @param string $documentId   The client-assigned document ID to use for this document.
 *
 *                             Optional. If not specified, an ID will be assigned by the service.
 */
function create_document_sample(string $parent, string $collectionId, string $documentId): void
{
    // Create a client.
    $firestoreClient = new FirestoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $document = new Document();

    // Call the API and handle any network failures.
    try {
        /** @var Document $response */
        $response = $firestoreClient->createDocument($parent, $collectionId, $documentId, $document);
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
    $parent = '[PARENT]';
    $collectionId = '[COLLECTION_ID]';
    $documentId = '[DOCUMENT_ID]';

    create_document_sample($parent, $collectionId, $documentId);
}
// [END firestore_v1_generated_Firestore_CreateDocument_sync]
