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

// [START datastore_v1_generated_DatastoreAdmin_DeleteIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Datastore\Admin\V1\DatastoreAdminClient;
use Google\Cloud\Datastore\Admin\V1\Index;
use Google\Rpc\Status;

/**
 * Deletes an existing index.
 * An index can only be deleted if it is in a `READY` or `ERROR` state. On
 * successful execution of the request, the index will be in a `DELETING`
 * [state][google.datastore.admin.v1.Index.State]. And on completion of the
 * returned [google.longrunning.Operation][google.longrunning.Operation], the index will be removed.
 *
 * During index deletion, the process could result in an error, in which
 * case the index will move to the `ERROR` state. The process can be recovered
 * by fixing the data that caused the error, followed by calling
 * [delete][google.datastore.admin.v1.DatastoreAdmin.DeleteIndex] again.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function delete_index_sample(): void
{
    // Create a client.
    $datastoreAdminClient = new DatastoreAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datastoreAdminClient->deleteIndex();
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
// [END datastore_v1_generated_DatastoreAdmin_DeleteIndex_sync]
