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

// [START datastore_v1_generated_DatastoreAdmin_CreateIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Datastore\Admin\V1\DatastoreAdminClient;
use Google\Cloud\Datastore\Admin\V1\Index;
use Google\Rpc\Status;

/**
 * Creates the specified index.
 * A newly created index's initial state is `CREATING`. On completion of the
 * returned [google.longrunning.Operation][google.longrunning.Operation], the state will be `READY`.
 * If the index already exists, the call will return an `ALREADY_EXISTS`
 * status.
 *
 * During index creation, the process could result in an error, in which
 * case the index will move to the `ERROR` state. The process can be recovered
 * by fixing the data that caused the error, removing the index with
 * [delete][google.datastore.admin.v1.DatastoreAdmin.DeleteIndex], then
 * re-creating the index with [create]
 * [google.datastore.admin.v1.DatastoreAdmin.CreateIndex].
 *
 * Indexes with a single property cannot be created.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_index_sample(): void
{
    // Create a client.
    $datastoreAdminClient = new DatastoreAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datastoreAdminClient->createIndex();
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
// [END datastore_v1_generated_DatastoreAdmin_CreateIndex_sync]
