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

// [START aiplatform_v1_generated_DeploymentResourcePoolService_UpdateDeploymentResourcePool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\DeploymentResourcePoolServiceClient;
use Google\Cloud\AIPlatform\V1\DedicatedResources;
use Google\Cloud\AIPlatform\V1\DeploymentResourcePool;
use Google\Cloud\AIPlatform\V1\MachineSpec;
use Google\Cloud\AIPlatform\V1\UpdateDeploymentResourcePoolRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update a DeploymentResourcePool.
 *
 * @param int $deploymentResourcePoolDedicatedResourcesMinReplicaCount Immutable. The minimum number of machine replicas this
 *                                                                     DeployedModel will be always deployed on. This value must be greater than
 *                                                                     or equal to 1.
 *
 *                                                                     If traffic against the DeployedModel increases, it may dynamically be
 *                                                                     deployed onto more replicas, and as traffic decreases, some of these extra
 *                                                                     replicas may be freed.
 */
function update_deployment_resource_pool_sample(
    int $deploymentResourcePoolDedicatedResourcesMinReplicaCount
): void {
    // Create a client.
    $deploymentResourcePoolServiceClient = new DeploymentResourcePoolServiceClient();

    // Prepare the request message.
    $deploymentResourcePoolDedicatedResourcesMachineSpec = new MachineSpec();
    $deploymentResourcePoolDedicatedResources = (new DedicatedResources())
        ->setMachineSpec($deploymentResourcePoolDedicatedResourcesMachineSpec)
        ->setMinReplicaCount($deploymentResourcePoolDedicatedResourcesMinReplicaCount);
    $deploymentResourcePool = (new DeploymentResourcePool())
        ->setDedicatedResources($deploymentResourcePoolDedicatedResources);
    $updateMask = new FieldMask();
    $request = (new UpdateDeploymentResourcePoolRequest())
        ->setDeploymentResourcePool($deploymentResourcePool)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $deploymentResourcePoolServiceClient->updateDeploymentResourcePool($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DeploymentResourcePool $result */
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
    $deploymentResourcePoolDedicatedResourcesMinReplicaCount = 0;

    update_deployment_resource_pool_sample($deploymentResourcePoolDedicatedResourcesMinReplicaCount);
}
// [END aiplatform_v1_generated_DeploymentResourcePoolService_UpdateDeploymentResourcePool_sync]
