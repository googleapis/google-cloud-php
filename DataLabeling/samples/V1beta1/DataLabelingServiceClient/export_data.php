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

// [START datalabeling_v1beta1_generated_DataLabelingService_ExportData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DataLabeling\V1beta1\DataLabelingServiceClient;
use Google\Cloud\DataLabeling\V1beta1\ExportDataOperationResponse;
use Google\Cloud\DataLabeling\V1beta1\OutputConfig;
use Google\Rpc\Status;

/**
 * Exports data and annotations from dataset.
 *
 * @param string $formattedName             Dataset resource name, format:
 *                                          projects/{project_id}/datasets/{dataset_id}
 *                                          Please see {@see DataLabelingServiceClient::datasetName()} for help formatting this field.
 * @param string $formattedAnnotatedDataset Annotated dataset resource name. DataItem in
 *                                          Dataset and their annotations in specified annotated dataset will be
 *                                          exported. It's in format of
 *                                          projects/{project_id}/datasets/{dataset_id}/annotatedDatasets/
 *                                          {annotated_dataset_id}
 *                                          Please see {@see DataLabelingServiceClient::annotatedDatasetName()} for help formatting this field.
 */
function export_data_sample(string $formattedName, string $formattedAnnotatedDataset): void
{
    // Create a client.
    $dataLabelingServiceClient = new DataLabelingServiceClient();

    // Prepare the request message.
    $outputConfig = new OutputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataLabelingServiceClient->exportData(
            $formattedName,
            $formattedAnnotatedDataset,
            $outputConfig
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportDataOperationResponse $result */
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
    $formattedName = DataLabelingServiceClient::datasetName('[PROJECT]', '[DATASET]');
    $formattedAnnotatedDataset = DataLabelingServiceClient::annotatedDatasetName(
        '[PROJECT]',
        '[DATASET]',
        '[ANNOTATED_DATASET]'
    );

    export_data_sample($formattedName, $formattedAnnotatedDataset);
}
// [END datalabeling_v1beta1_generated_DataLabelingService_ExportData_sync]
