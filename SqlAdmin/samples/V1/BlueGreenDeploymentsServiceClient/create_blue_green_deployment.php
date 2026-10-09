<?php
/*
 * Copyright 2026 Google LLC
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

// [START sqladmin_v1_generated_BlueGreenDeploymentsService_CreateBlueGreenDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\BlueGreenDeployment;
use Google\Cloud\Sql\V1\Client\BlueGreenDeploymentsServiceClient;
use Google\Cloud\Sql\V1\CreateBlueGreenDeploymentRequest;
use Google\Cloud\Sql\V1\Operation;

/**
 * Creates a blue-green deployment under a given project and location.
 *
 * @param string $formattedParent                            The parent resource where this blue-green deployment will be
 *                                                           created. Format: projects/{project}/locations/{location}
 *                                                           Please see {@see BlueGreenDeploymentsServiceClient::locationName()} for help formatting this field.
 * @param string $blueGreenDeploymentId                      The ID to use for the blue-green deployment, which will become
 *                                                           the final component of the deployment's resource name. The ID must be
 *                                                           unique within the given project and location and between 2-63 characters.
 * @param string $formattedBlueGreenDeploymentSourceInstance Immutable. Required on create, and immutable. The full resource
 *                                                           name of the source instance (the "blue" instance). Format:
 *                                                           projects/{project}/instances/{instance}
 *                                                           Please see {@see BlueGreenDeploymentsServiceClient::instanceName()} for help formatting this field.
 */
function create_blue_green_deployment_sample(
    string $formattedParent,
    string $blueGreenDeploymentId,
    string $formattedBlueGreenDeploymentSourceInstance
): void {
    // Create a client.
    $blueGreenDeploymentsServiceClient = new BlueGreenDeploymentsServiceClient();

    // Prepare the request message.
    $blueGreenDeployment = (new BlueGreenDeployment())
        ->setSourceInstance($formattedBlueGreenDeploymentSourceInstance);
    $request = (new CreateBlueGreenDeploymentRequest())
        ->setParent($formattedParent)
        ->setBlueGreenDeploymentId($blueGreenDeploymentId)
        ->setBlueGreenDeployment($blueGreenDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $blueGreenDeploymentsServiceClient->createBlueGreenDeployment($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedParent = BlueGreenDeploymentsServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $blueGreenDeploymentId = '[BLUE_GREEN_DEPLOYMENT_ID]';
    $formattedBlueGreenDeploymentSourceInstance = BlueGreenDeploymentsServiceClient::instanceName(
        '[PROJECT]',
        '[INSTANCE]'
    );

    create_blue_green_deployment_sample(
        $formattedParent,
        $blueGreenDeploymentId,
        $formattedBlueGreenDeploymentSourceInstance
    );
}
// [END sqladmin_v1_generated_BlueGreenDeploymentsService_CreateBlueGreenDeployment_sync]
