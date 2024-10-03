<?php
/*
 * Copyright 2024 Google LLC
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

// [START aiplatform_v1_generated_ModelService_CopyModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\ModelServiceClient;
use Google\Cloud\AIPlatform\V1\CopyModelRequest;
use Google\Cloud\AIPlatform\V1\CopyModelResponse;
use Google\Rpc\Status;

/**
 * Copies an already existing Vertex AI Model into the specified Location.
 * The source Model must exist in the same Project.
 * When copying custom Models, the users themselves are responsible for
 * [Model.metadata][google.cloud.aiplatform.v1.Model.metadata] content to be
 * region-agnostic, as well as making sure that any resources (e.g. files) it
 * depends on remain accessible.
 *
 * @param string $formattedParent      The resource name of the Location into which to copy the Model.
 *                                     Format: `projects/{project}/locations/{location}`
 *                                     Please see {@see ModelServiceClient::locationName()} for help formatting this field.
 * @param string $formattedSourceModel The resource name of the Model to copy. That Model must be in the
 *                                     same Project. Format:
 *                                     `projects/{project}/locations/{location}/models/{model}`
 *                                     Please see {@see ModelServiceClient::modelName()} for help formatting this field.
 */
function copy_model_sample(string $formattedParent, string $formattedSourceModel): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Prepare the request message.
    $request = (new CopyModelRequest())
        ->setParent($formattedParent)
        ->setSourceModel($formattedSourceModel);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $modelServiceClient->copyModel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CopyModelResponse $result */
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
    $formattedParent = ModelServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $formattedSourceModel = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    copy_model_sample($formattedParent, $formattedSourceModel);
}
// [END aiplatform_v1_generated_ModelService_CopyModel_sync]
