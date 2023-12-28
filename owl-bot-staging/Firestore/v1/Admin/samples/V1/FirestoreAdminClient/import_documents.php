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

// [START firestore_v1_generated_FirestoreAdmin_ImportDocuments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Firestore\Admin\V1\FirestoreAdminClient;
use Google\Rpc\Status;

/**
 * Imports documents into Google Cloud Firestore. Existing documents with the
 * same name are overwritten. The import occurs in the background and its
 * progress can be monitored and managed via the Operation resource that is
 * created. If an ImportDocuments operation is cancelled, it is possible
 * that a subset of the data has already been imported to Cloud Firestore.
 *
 * @param string $formattedName Database to import into. Should be of the form:
 *                              `projects/{project_id}/databases/{database_id}`. Please see
 *                              {@see FirestoreAdminClient::databaseName()} for help formatting this field.
 */
function import_documents_sample(string $formattedName): void
{
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firestoreAdminClient->importDocuments($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedName = FirestoreAdminClient::databaseName('[PROJECT]', '[DATABASE]');

    import_documents_sample($formattedName);
}
// [END firestore_v1_generated_FirestoreAdmin_ImportDocuments_sync]
