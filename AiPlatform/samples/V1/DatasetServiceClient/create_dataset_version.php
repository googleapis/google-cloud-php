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

// [START aiplatform_v1_generated_DatasetService_CreateDatasetVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\DatasetServiceClient;
use Google\Cloud\AIPlatform\V1\CreateDatasetVersionRequest;
use Google\Cloud\AIPlatform\V1\DatasetVersion;
use Google\Protobuf\Value;
use Google\Rpc\Status;

/**
 * Create a version from a Dataset.
 *
 * @param string $formattedParent The name of the Dataset resource.
 *                                Format:
 *                                `projects/{project}/locations/{location}/datasets/{dataset}`
 *                                Please see {@see DatasetServiceClient::datasetName()} for help formatting this field.
 */
function create_dataset_version_sample(string $formattedParent): void
{
    // Create a client.
    $datasetServiceClient = new DatasetServiceClient();

    // Prepare the request message.
    $datasetVersionMetadata = new Value();
    $datasetVersion = (new DatasetVersion())
        ->setMetadata($datasetVersionMetadata);
    $request = (new CreateDatasetVersionRequest())
        ->setParent($formattedParent)
        ->setDatasetVersion($datasetVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datasetServiceClient->createDatasetVersion($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DatasetVersion $result */
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
    $formattedParent = DatasetServiceClient::datasetName('[PROJECT]', '[LOCATION]', '[DATASET]');

    create_dataset_version_sample($formattedParent);
}
// [END aiplatform_v1_generated_DatasetService_CreateDatasetVersion_sync]
