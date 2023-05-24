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

// [START firestore_v1_generated_FirestoreAdmin_CreateIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Firestore\Admin\V1\FirestoreAdminClient;
use Google\Cloud\Firestore\Admin\V1\Index;
use Google\Rpc\Status;

/**
 * Creates a composite index. This returns a [google.longrunning.Operation][google.longrunning.Operation]
 * which may be used to track the status of the creation. The metadata for
 * the operation will be the type [IndexOperationMetadata][google.firestore.admin.v1.IndexOperationMetadata].
 *
 * @param string $formattedParent A parent name of the form
 *                                `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}`
 *                                Please see {@see FirestoreAdminClient::collectionGroupName()} for help formatting this field.
 */
function create_index_sample(string $formattedParent): void
{
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $index = new Index();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firestoreAdminClient->createIndex($formattedParent, $index);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Index $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $formattedParent = FirestoreAdminClient::collectionGroupName(
        '[PROJECT]',
        '[DATABASE]',
        '[COLLECTION]'
    );

    create_index_sample($formattedParent);
}
// [END firestore_v1_generated_FirestoreAdmin_CreateIndex_sync]
