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

// [START aiplatform_v1_generated_EndpointService_UndeployModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\EndpointServiceClient;
use Google\Cloud\AIPlatform\V1\UndeployModelResponse;
use Google\Rpc\Status;

/**
 * Undeploys a Model from an Endpoint, removing a DeployedModel from it, and
 * freeing all resources it's using.
 *
 * @param string $formattedEndpoint The name of the Endpoint resource from which to undeploy a Model.
 *                                  Format:
 *                                  `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                  Please see {@see EndpointServiceClient::endpointName()} for help formatting this field.
 * @param string $deployedModelId   The ID of the DeployedModel to be undeployed from the Endpoint.
 */
function undeploy_model_sample(string $formattedEndpoint, string $deployedModelId): void
{
    // Create a client.
    $endpointServiceClient = new EndpointServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $endpointServiceClient->undeployModel($formattedEndpoint, $deployedModelId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var UndeployModelResponse $result */
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
    $formattedEndpoint = EndpointServiceClient::endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
    $deployedModelId = '[DEPLOYED_MODEL_ID]';

    undeploy_model_sample($formattedEndpoint, $deployedModelId);
}
// [END aiplatform_v1_generated_EndpointService_UndeployModel_sync]
