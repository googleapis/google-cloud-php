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

// [START vectorsearch_v1_generated_DataObjectService_BatchCreateDataObjects_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VectorSearch\V1\BatchCreateDataObjectsRequest;
use Google\Cloud\VectorSearch\V1\BatchCreateDataObjectsResponse;
use Google\Cloud\VectorSearch\V1\Client\DataObjectServiceClient;
use Google\Cloud\VectorSearch\V1\CreateDataObjectRequest;
use Google\Cloud\VectorSearch\V1\DataObject;

/**
 * Creates a batch of dataObjects.
 *
 * @param string $formattedParent         The resource name of the Collection to create the DataObjects in.
 *                                        Format: `projects/{project}/locations/{location}/collections/{collection}`.
 *                                        The parent field in the CreateDataObjectRequest messages must match this
 *                                        field. Please see
 *                                        {@see DataObjectServiceClient::collectionName()} for help formatting this field.
 * @param string $formattedRequestsParent The resource name of the Collection to create the DataObject in.
 *                                        Format: `projects/{project}/locations/{location}/collections/{collection}`
 *                                        Please see {@see DataObjectServiceClient::collectionName()} for help formatting this field.
 * @param string $requestsDataObjectId    The id of the dataObject to create.
 *                                        The id must be 1-63 characters long, and comply with
 *                                        [RFC1035](https://www.ietf.org/rfc/rfc1035.txt).
 *                                        Specifically, it must be 1-63 characters long and match the regular
 *                                        expression `[a-z](?:[-a-z0-9]{0,61}[a-z0-9])?`.
 */
function batch_create_data_objects_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsDataObjectId
): void {
    // Create a client.
    $dataObjectServiceClient = new DataObjectServiceClient();

    // Prepare the request message.
    $requestsDataObject = new DataObject();
    $createDataObjectRequest = (new CreateDataObjectRequest())
        ->setParent($formattedRequestsParent)
        ->setDataObjectId($requestsDataObjectId)
        ->setDataObject($requestsDataObject);
    $requests = [$createDataObjectRequest,];
    $request = (new BatchCreateDataObjectsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateDataObjectsResponse $response */
        $response = $dataObjectServiceClient->batchCreateDataObjects($request);
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
    $formattedParent = DataObjectServiceClient::collectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]'
    );
    $formattedRequestsParent = DataObjectServiceClient::collectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]'
    );
    $requestsDataObjectId = '[DATA_OBJECT_ID]';

    batch_create_data_objects_sample($formattedParent, $formattedRequestsParent, $requestsDataObjectId);
}
// [END vectorsearch_v1_generated_DataObjectService_BatchCreateDataObjects_sync]
