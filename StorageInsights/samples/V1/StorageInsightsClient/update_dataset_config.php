<?php
/*
 * Copyright 2025 Google LLC
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

// [START storageinsights_v1_generated_StorageInsights_UpdateDatasetConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\StorageInsights\V1\Client\StorageInsightsClient;
use Google\Cloud\StorageInsights\V1\DatasetConfig;
use Google\Cloud\StorageInsights\V1\UpdateDatasetConfigRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a dataset configuration in a given project for a given location.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_dataset_config_sample(): void
{
    // Create a client.
    $storageInsightsClient = new StorageInsightsClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $datasetConfig = new DatasetConfig();
    $request = (new UpdateDatasetConfigRequest())
        ->setUpdateMask($updateMask)
        ->setDatasetConfig($datasetConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $storageInsightsClient->updateDatasetConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DatasetConfig $result */
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
// [END storageinsights_v1_generated_StorageInsights_UpdateDatasetConfig_sync]
