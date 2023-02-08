<?php
/*
 * Copyright 2022 Google LLC
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

// [START aiplatform_v1_generated_IndexEndpointService_MutateDeployedIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\DeployedIndex;
use Google\Cloud\AIPlatform\V1\IndexEndpointServiceClient;
use Google\Cloud\AIPlatform\V1\MutateDeployedIndexResponse;
use Google\Rpc\Status;

/**
 * Update an existing DeployedIndex under an IndexEndpoint.
 *
 * @param string $formattedIndexEndpoint      The name of the IndexEndpoint resource into which to deploy an Index.
 *                                            Format:
 *                                            `projects/{project}/locations/{location}/indexEndpoints/{index_endpoint}`
 *                                            Please see {@see IndexEndpointServiceClient::indexEndpointName()} for help formatting this field.
 * @param string $deployedIndexId             The user specified ID of the DeployedIndex.
 *                                            The ID can be up to 128 characters long and must start with a letter and
 *                                            only contain letters, numbers, and underscores.
 *                                            The ID must be unique within the project it is created in.
 * @param string $formattedDeployedIndexIndex The name of the Index this is the deployment of.
 *                                            We may refer to this Index as the DeployedIndex's "original" Index. Please see
 *                                            {@see IndexEndpointServiceClient::indexName()} for help formatting this field.
 */
function mutate_deployed_index_sample(
    string $formattedIndexEndpoint,
    string $deployedIndexId,
    string $formattedDeployedIndexIndex
): void {
    // Create a client.
    $indexEndpointServiceClient = new IndexEndpointServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $deployedIndex = (new DeployedIndex())
        ->setId($deployedIndexId)
        ->setIndex($formattedDeployedIndexIndex);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $indexEndpointServiceClient->mutateDeployedIndex(
            $formattedIndexEndpoint,
            $deployedIndex
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MutateDeployedIndexResponse $result */
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
    $formattedIndexEndpoint = IndexEndpointServiceClient::indexEndpointName(
        '[PROJECT]',
        '[LOCATION]',
        '[INDEX_ENDPOINT]'
    );
    $deployedIndexId = '[ID]';
    $formattedDeployedIndexIndex = IndexEndpointServiceClient::indexName(
        '[PROJECT]',
        '[LOCATION]',
        '[INDEX]'
    );

    mutate_deployed_index_sample(
        $formattedIndexEndpoint,
        $deployedIndexId,
        $formattedDeployedIndexIndex
    );
}
// [END aiplatform_v1_generated_IndexEndpointService_MutateDeployedIndex_sync]
