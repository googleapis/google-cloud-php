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

// [START datastore_v1_generated_DatastoreAdmin_ImportEntities_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Datastore\Admin\V1\DatastoreAdminClient;
use Google\Rpc\Status;

/**
 * Imports entities into Google Cloud Datastore. Existing entities with the
 * same key are overwritten. The import occurs in the background and its
 * progress can be monitored and managed via the Operation resource that is
 * created. If an ImportEntities operation is cancelled, it is possible
 * that a subset of the data has already been imported to Cloud Datastore.
 *
 * @param string $projectId Project ID against which to make the request.
 * @param string $inputUrl  The full resource URL of the external storage location. Currently, only
 *                          Google Cloud Storage is supported. So input_url should be of the form:
 *                          `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
 *                          `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
 *                          an optional Cloud Storage namespace path (this is not a Cloud Datastore
 *                          namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
 *                          by the ExportEntities operation. For more information about Cloud Storage
 *                          namespace paths, see
 *                          [Object name
 *                          considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
 *
 *                          For more information, see
 *                          [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
 */
function import_entities_sample(string $projectId, string $inputUrl): void
{
    // Create a client.
    $datastoreAdminClient = new DatastoreAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datastoreAdminClient->importEntities($projectId, $inputUrl);
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
    $projectId = '[PROJECT_ID]';
    $inputUrl = '[INPUT_URL]';

    import_entities_sample($projectId, $inputUrl);
}
// [END datastore_v1_generated_DatastoreAdmin_ImportEntities_sync]
