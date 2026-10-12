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

// [START vectorsearch_v1_generated_VectorSearchService_CreateIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VectorSearch\V1\Client\VectorSearchServiceClient;
use Google\Cloud\VectorSearch\V1\CreateIndexRequest;
use Google\Cloud\VectorSearch\V1\Index;
use Google\Rpc\Status;

/**
 * Creates a new Index in a given project and location.
 *
 * @param string $formattedParent The resource name of the Collection for which to create the
 *                                Index. Format:
 *                                `projects/{project}/locations/{location}/collections/{collection}`
 *                                Please see {@see VectorSearchServiceClient::collectionName()} for help formatting this field.
 * @param string $indexId         ID of the Index to create.
 *                                The id must be 1-63 characters long, and comply with
 *                                [RFC1035](https://www.ietf.org/rfc/rfc1035.txt).
 *                                Specifically, it must be 1-63 characters long and match the regular
 *                                expression `[a-z](?:[-a-z0-9]{0,61}[a-z0-9])?`.
 * @param string $indexIndexField The collection schema field to index.
 */
function create_index_sample(
    string $formattedParent,
    string $indexId,
    string $indexIndexField
): void {
    // Create a client.
    $vectorSearchServiceClient = new VectorSearchServiceClient();

    // Prepare the request message.
    $index = (new Index())
        ->setIndexField($indexIndexField);
    $request = (new CreateIndexRequest())
        ->setParent($formattedParent)
        ->setIndexId($indexId)
        ->setIndex($index);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vectorSearchServiceClient->createIndex($request);
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
    $formattedParent = VectorSearchServiceClient::collectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]'
    );
    $indexId = '[INDEX_ID]';
    $indexIndexField = '[INDEX_FIELD]';

    create_index_sample($formattedParent, $indexId, $indexIndexField);
}
// [END vectorsearch_v1_generated_VectorSearchService_CreateIndex_sync]
