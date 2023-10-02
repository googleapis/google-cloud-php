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

// [START aiplatform_v1_generated_MatchService_ReadIndexDatapoints_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\MatchServiceClient;
use Google\Cloud\AIPlatform\V1\ReadIndexDatapointsRequest;
use Google\Cloud\AIPlatform\V1\ReadIndexDatapointsResponse;

/**
 * Reads the datapoints/vectors of the given IDs.
 * A maximum of 1000 datapoints can be retrieved in a batch.
 *
 * @param string $formattedIndexEndpoint The name of the index endpoint.
 *                                       Format:
 *                                       `projects/{project}/locations/{location}/indexEndpoints/{index_endpoint}`
 *                                       Please see {@see MatchServiceClient::indexEndpointName()} for help formatting this field.
 */
function read_index_datapoints_sample(string $formattedIndexEndpoint): void
{
    // Create a client.
    $matchServiceClient = new MatchServiceClient();

    // Prepare the request message.
    $request = (new ReadIndexDatapointsRequest())
        ->setIndexEndpoint($formattedIndexEndpoint);

    // Call the API and handle any network failures.
    try {
        /** @var ReadIndexDatapointsResponse $response */
        $response = $matchServiceClient->readIndexDatapoints($request);
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
    $formattedIndexEndpoint = MatchServiceClient::indexEndpointName(
        '[PROJECT]',
        '[LOCATION]',
        '[INDEX_ENDPOINT]'
    );

    read_index_datapoints_sample($formattedIndexEndpoint);
}
// [END aiplatform_v1_generated_MatchService_ReadIndexDatapoints_sync]
