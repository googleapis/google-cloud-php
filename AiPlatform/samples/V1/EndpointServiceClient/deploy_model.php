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

// [START aiplatform_v1_generated_EndpointService_DeployModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\DeployModelResponse;
use Google\Cloud\AIPlatform\V1\DeployedModel;
use Google\Cloud\AIPlatform\V1\EndpointServiceClient;
use Google\Rpc\Status;

/**
 * Deploys a Model into this Endpoint, creating a DeployedModel within it.
 *
 * @param string $formattedEndpoint           The name of the Endpoint resource into which to deploy a Model.
 *                                            Format:
 *                                            `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                            Please see {@see EndpointServiceClient::endpointName()} for help formatting this field.
 * @param string $formattedDeployedModelModel The resource name of the Model that this is the deployment of. Note that
 *                                            the Model may be in a different location than the DeployedModel's Endpoint.
 *
 *                                            The resource name may contain version id or version alias to specify the
 *                                            version, if no version is specified, the default version will be deployed. Please see
 *                                            {@see EndpointServiceClient::modelName()} for help formatting this field.
 */
function deploy_model_sample(string $formattedEndpoint, string $formattedDeployedModelModel): void
{
    // Create a client.
    $endpointServiceClient = new EndpointServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $deployedModel = (new DeployedModel())
        ->setModel($formattedDeployedModelModel);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $endpointServiceClient->deployModel($formattedEndpoint, $deployedModel);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DeployModelResponse $result */
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
    $formattedDeployedModelModel = EndpointServiceClient::modelName(
        '[PROJECT]',
        '[LOCATION]',
        '[MODEL]'
    );

    deploy_model_sample($formattedEndpoint, $formattedDeployedModelModel);
}
// [END aiplatform_v1_generated_EndpointService_DeployModel_sync]
