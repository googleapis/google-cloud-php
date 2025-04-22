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

// [START financialservices_v1_generated_AML_UpdateModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\FinancialServices\V1\Client\AMLClient;
use Google\Cloud\FinancialServices\V1\Model;
use Google\Cloud\FinancialServices\V1\UpdateModelRequest;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single Model.
 *
 * @param string $formattedModelEngineConfig   The resource name of the EngineConfig the model training will be
 *                                             based on. Format:
 *                                             `/projects/{project_num}/locations/{location}/instances/{instance}/engineConfigs/{engineConfig}`
 *                                             Please see {@see AMLClient::engineConfigName()} for help formatting this field.
 * @param string $formattedModelPrimaryDataset The resource name of the Primary Dataset used in this model
 *                                             training. For information about how primary and auxiliary datasets are
 *                                             used, refer to the engine version's documentation.  Format:
 *                                             `/projects/{project_num}/locations/{location}/instances/{instance}/datasets/{dataset}`
 *                                             Please see {@see AMLClient::datasetName()} for help formatting this field.
 */
function update_model_sample(
    string $formattedModelEngineConfig,
    string $formattedModelPrimaryDataset
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $modelEndTime = new Timestamp();
    $model = (new Model())
        ->setEngineConfig($formattedModelEngineConfig)
        ->setPrimaryDataset($formattedModelPrimaryDataset)
        ->setEndTime($modelEndTime);
    $request = (new UpdateModelRequest())
        ->setModel($model);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->updateModel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Model $result */
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
    $formattedModelEngineConfig = AMLClient::engineConfigName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[ENGINE_CONFIG]'
    );
    $formattedModelPrimaryDataset = AMLClient::datasetName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATASET]'
    );

    update_model_sample($formattedModelEngineConfig, $formattedModelPrimaryDataset);
}
// [END financialservices_v1_generated_AML_UpdateModel_sync]
