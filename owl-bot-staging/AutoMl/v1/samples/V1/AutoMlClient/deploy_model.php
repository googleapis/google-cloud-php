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

// [START automl_v1_generated_AutoMl_DeployModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1\AutoMlClient;
use Google\Rpc\Status;

/**
 * Deploys a model. If a model is already deployed, deploying it with the
 * same parameters has no effect. Deploying with different parametrs
 * (as e.g. changing
 * [node_number][google.cloud.automl.v1p1beta.ImageObjectDetectionModelDeploymentMetadata.node_number])
 * will reset the deployment state without pausing the model's availability.
 *
 * Only applicable for Text Classification, Image Object Detection , Tables, and Image Segmentation; all other domains manage
 * deployment automatically.
 *
 * Returns an empty response in the
 * [response][google.longrunning.Operation.response] field when it completes.
 *
 * @param string $formattedName Resource name of the model to deploy. Please see
 *                              {@see AutoMlClient::modelName()} for help formatting this field.
 */
function deploy_model_sample(string $formattedName): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autoMlClient->deployModel($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = AutoMlClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    deploy_model_sample($formattedName);
}
// [END automl_v1_generated_AutoMl_DeployModel_sync]
