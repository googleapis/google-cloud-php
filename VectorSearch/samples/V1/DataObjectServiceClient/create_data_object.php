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

// [START vectorsearch_v1_generated_DataObjectService_CreateDataObject_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VectorSearch\V1\Client\DataObjectServiceClient;
use Google\Cloud\VectorSearch\V1\CreateDataObjectRequest;
use Google\Cloud\VectorSearch\V1\DataObject;

/**
 * Creates a dataObject.
 *
 * @param string $formattedParent The resource name of the Collection to create the DataObject in.
 *                                Format: `projects/{project}/locations/{location}/collections/{collection}`
 *                                Please see {@see DataObjectServiceClient::collectionName()} for help formatting this field.
 * @param string $dataObjectId    The id of the dataObject to create.
 *                                The id must be 1-63 characters long, and comply with
 *                                [RFC1035](https://www.ietf.org/rfc/rfc1035.txt).
 *                                Specifically, it must be 1-63 characters long and match the regular
 *                                expression `[a-z](?:[-a-z0-9]{0,61}[a-z0-9])?`.
 */
function create_data_object_sample(string $formattedParent, string $dataObjectId): void
{
    // Create a client.
    $dataObjectServiceClient = new DataObjectServiceClient();

    // Prepare the request message.
    $dataObject = new DataObject();
    $request = (new CreateDataObjectRequest())
        ->setParent($formattedParent)
        ->setDataObjectId($dataObjectId)
        ->setDataObject($dataObject);

    // Call the API and handle any network failures.
    try {
        /** @var DataObject $response */
        $response = $dataObjectServiceClient->createDataObject($request);
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
    $dataObjectId = '[DATA_OBJECT_ID]';

    create_data_object_sample($formattedParent, $dataObjectId);
}
// [END vectorsearch_v1_generated_DataObjectService_CreateDataObject_sync]
