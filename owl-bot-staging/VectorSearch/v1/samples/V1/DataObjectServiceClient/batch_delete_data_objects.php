<?php
/*
 * Copyright 2026 Google LLC
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

// [START vectorsearch_v1_generated_DataObjectService_BatchDeleteDataObjects_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VectorSearch\V1\BatchDeleteDataObjectsRequest;
use Google\Cloud\VectorSearch\V1\Client\DataObjectServiceClient;
use Google\Cloud\VectorSearch\V1\DeleteDataObjectRequest;

/**
 * Deletes dataObjects in a batch.
 *
 * @param string $formattedParent       The resource name of the Collection to delete the DataObjects in.
 *                                      Format: `projects/{project}/locations/{location}/collections/{collection}`. Please see
 *                                      {@see DataObjectServiceClient::collectionName()} for help formatting this field.
 * @param string $formattedRequestsName The name of the DataObject resource to be deleted.
 *                                      Format:
 *                                      `projects/{project}/locations/{location}/collections/{collection}/dataObjects/{dataObject}`
 *                                      Please see {@see DataObjectServiceClient::dataObjectName()} for help formatting this field.
 */
function batch_delete_data_objects_sample(
    string $formattedParent,
    string $formattedRequestsName
): void {
    // Create a client.
    $dataObjectServiceClient = new DataObjectServiceClient();

    // Prepare the request message.
    $deleteDataObjectRequest = (new DeleteDataObjectRequest())
        ->setName($formattedRequestsName);
    $requests = [$deleteDataObjectRequest,];
    $request = (new BatchDeleteDataObjectsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        $dataObjectServiceClient->batchDeleteDataObjects($request);
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
    $formattedParent = DataObjectServiceClient::collectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]'
    );
    $formattedRequestsName = DataObjectServiceClient::dataObjectName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]',
        '[DATAOBJECT]'
    );

    batch_delete_data_objects_sample($formattedParent, $formattedRequestsName);
}
// [END vectorsearch_v1_generated_DataObjectService_BatchDeleteDataObjects_sync]
