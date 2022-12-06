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

// [START aiplatform_v1_generated_ModelService_DeleteModelVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\ModelServiceClient;
use Google\Rpc\Status;

/**
 * Deletes a Model version.
 *
 * Model version can only be deleted if there are no [DeployedModels][]
 * created from it. Deleting the only version in the Model is not allowed. Use
 * [DeleteModel][google.cloud.aiplatform.v1.ModelService.DeleteModel] for deleting the Model instead.
 *
 * @param string $formattedName The name of the model version to be deleted, with a version ID explicitly
 *                              included.
 *
 *                              Example: `projects/{project}/locations/{location}/models/{model}&#64;1234`
 *                              Please see {@see ModelServiceClient::modelName()} for help formatting this field.
 */
function delete_model_version_sample(string $formattedName): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $modelServiceClient->deleteModelVersion($formattedName);
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
    $formattedName = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    delete_model_version_sample($formattedName);
}
// [END aiplatform_v1_generated_ModelService_DeleteModelVersion_sync]
