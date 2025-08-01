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

// [START aiplatform_v1_generated_EndpointService_MutateDeployedModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\EndpointServiceClient;
use Google\Cloud\AIPlatform\V1\DeployedModel;
use Google\Cloud\AIPlatform\V1\MutateDeployedModelRequest;
use Google\Cloud\AIPlatform\V1\MutateDeployedModelResponse;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an existing deployed model. Updatable fields include
 * `min_replica_count`, `max_replica_count`, `required_replica_count`,
 * `autoscaling_metric_specs`, `disable_container_logging` (v1 only), and
 * `enable_container_logging` (v1beta1 only).
 *
 * @param string $formattedEndpoint The name of the Endpoint resource into which to mutate a
 *                                  DeployedModel. Format:
 *                                  `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                  Please see {@see EndpointServiceClient::endpointName()} for help formatting this field.
 */
function mutate_deployed_model_sample(string $formattedEndpoint): void
{
    // Create a client.
    $endpointServiceClient = new EndpointServiceClient();

    // Prepare the request message.
    $deployedModel = new DeployedModel();
    $updateMask = new FieldMask();
    $request = (new MutateDeployedModelRequest())
        ->setEndpoint($formattedEndpoint)
        ->setDeployedModel($deployedModel)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $endpointServiceClient->mutateDeployedModel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MutateDeployedModelResponse $result */
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

    mutate_deployed_model_sample($formattedEndpoint);
}
// [END aiplatform_v1_generated_EndpointService_MutateDeployedModel_sync]
