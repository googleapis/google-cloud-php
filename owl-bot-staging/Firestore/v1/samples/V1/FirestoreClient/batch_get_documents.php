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

// [START firestore_v1_generated_Firestore_BatchGetDocuments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\FirestoreClient;

/**
 * Gets multiple documents.
 *
 * Documents returned by this method are not guaranteed to be returned in the
 * same order that they were requested.
 *
 * @param string $database         The database name. In the format:
 *                                 `projects/{project_id}/databases/{database_id}`.
 * @param string $documentsElement The names of the documents to retrieve. In the format:
 *                                 `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
 *                                 The request will fail if any of the document is not a child resource of the
 *                                 given `database`. Duplicate names will be elided.
 */
function batch_get_documents_sample(string $database, string $documentsElement): void
{
    // Create a client.
    $firestoreClient = new FirestoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $documents = [$documentsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $firestoreClient->batchGetDocuments($database, $documents);

        /** @var BatchGetDocumentsResponse $element */
        foreach ($stream->readAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $documentsElement = '[DOCUMENTS]';

    batch_get_documents_sample($database, $documentsElement);
}
// [END firestore_v1_generated_Firestore_BatchGetDocuments_sync]
