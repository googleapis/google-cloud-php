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

// [START aiplatform_v1_generated_DatasetService_CreateDataset_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Dataset;
use Google\Cloud\AIPlatform\V1\DatasetServiceClient;
use Google\Protobuf\Value;
use Google\Rpc\Status;

/**
 * Creates a Dataset.
 *
 * @param string $formattedParent          The resource name of the Location to create the Dataset in.
 *                                         Format: `projects/{project}/locations/{location}`
 *                                         Please see {@see DatasetServiceClient::locationName()} for help formatting this field.
 * @param string $datasetDisplayName       The user-defined name of the Dataset.
 *                                         The name can be up to 128 characters long and can consist of any UTF-8
 *                                         characters.
 * @param string $datasetMetadataSchemaUri Points to a YAML file stored on Google Cloud Storage describing additional
 *                                         information about the Dataset.
 *                                         The schema is defined as an OpenAPI 3.0.2 Schema Object.
 *                                         The schema files that can be used here are found in
 *                                         gs://google-cloud-aiplatform/schema/dataset/metadata/.
 */
function create_dataset_sample(
    string $formattedParent,
    string $datasetDisplayName,
    string $datasetMetadataSchemaUri
): void {
    // Create a client.
    $datasetServiceClient = new DatasetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $datasetMetadata = new Value();
    $dataset = (new Dataset())
        ->setDisplayName($datasetDisplayName)
        ->setMetadataSchemaUri($datasetMetadataSchemaUri)
        ->setMetadata($datasetMetadata);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datasetServiceClient->createDataset($formattedParent, $dataset);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Dataset $result */
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
    $formattedParent = DatasetServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $datasetDisplayName = '[DISPLAY_NAME]';
    $datasetMetadataSchemaUri = '[METADATA_SCHEMA_URI]';

    create_dataset_sample($formattedParent, $datasetDisplayName, $datasetMetadataSchemaUri);
}
// [END aiplatform_v1_generated_DatasetService_CreateDataset_sync]
