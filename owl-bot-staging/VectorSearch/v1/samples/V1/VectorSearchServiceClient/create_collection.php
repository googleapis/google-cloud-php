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

// [START vectorsearch_v1_generated_VectorSearchService_CreateCollection_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VectorSearch\V1\Client\VectorSearchServiceClient;
use Google\Cloud\VectorSearch\V1\Collection;
use Google\Cloud\VectorSearch\V1\CreateCollectionRequest;
use Google\Rpc\Status;

/**
 * Creates a new Collection in a given project and location.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see VectorSearchServiceClient::locationName()} for help formatting this field.
 * @param string $collectionId    ID of the Collection to create.
 *                                The id must be 1-63 characters long, and comply with
 *                                [RFC1035](https://www.ietf.org/rfc/rfc1035.txt).
 *                                Specifically, it must be 1-63 characters long and match the regular
 *                                expression `[a-z](?:[-a-z0-9]{0,61}[a-z0-9])?`.
 */
function create_collection_sample(string $formattedParent, string $collectionId): void
{
    // Create a client.
    $vectorSearchServiceClient = new VectorSearchServiceClient();

    // Prepare the request message.
    $collection = new Collection();
    $request = (new CreateCollectionRequest())
        ->setParent($formattedParent)
        ->setCollectionId($collectionId)
        ->setCollection($collection);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vectorSearchServiceClient->createCollection($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Collection $result */
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
    $formattedParent = VectorSearchServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $collectionId = '[COLLECTION_ID]';

    create_collection_sample($formattedParent, $collectionId);
}
// [END vectorsearch_v1_generated_VectorSearchService_CreateCollection_sync]
