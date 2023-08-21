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

// [START datalabeling_v1beta1_generated_DataLabelingService_GetExample_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataLabeling\V1beta1\Client\DataLabelingServiceClient;
use Google\Cloud\DataLabeling\V1beta1\Example;
use Google\Cloud\DataLabeling\V1beta1\GetExampleRequest;

/**
 * Gets an example by resource name, including both data and annotation.
 *
 * @param string $formattedName Name of example, format:
 *                              projects/{project_id}/datasets/{dataset_id}/annotatedDatasets/
 *                              {annotated_dataset_id}/examples/{example_id}
 *                              Please see {@see DataLabelingServiceClient::exampleName()} for help formatting this field.
 */
function get_example_sample(string $formattedName): void
{
    // Create a client.
    $dataLabelingServiceClient = new DataLabelingServiceClient();

    // Prepare the request message.
    $request = (new GetExampleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Example $response */
        $response = $dataLabelingServiceClient->getExample($request);
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
    $formattedName = DataLabelingServiceClient::exampleName(
        '[PROJECT]',
        '[DATASET]',
        '[ANNOTATED_DATASET]',
        '[EXAMPLE]'
    );

    get_example_sample($formattedName);
}
// [END datalabeling_v1beta1_generated_DataLabelingService_GetExample_sync]
