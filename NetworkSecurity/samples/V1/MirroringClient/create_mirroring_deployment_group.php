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

// [START networksecurity_v1_generated_Mirroring_CreateMirroringDeploymentGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\MirroringClient;
use Google\Cloud\NetworkSecurity\V1\CreateMirroringDeploymentGroupRequest;
use Google\Cloud\NetworkSecurity\V1\MirroringDeploymentGroup;
use Google\Rpc\Status;

/**
 * Creates a deployment group in a given project and location.
 * See https://google.aip.dev/133.
 *
 * @param string $formattedParent                          The parent resource where this deployment group will be created.
 *                                                         Format: projects/{project}/locations/{location}
 *                                                         Please see {@see MirroringClient::locationName()} for help formatting this field.
 * @param string $mirroringDeploymentGroupId               The ID to use for the new deployment group, which will become the
 *                                                         final component of the deployment group's resource name.
 * @param string $formattedMirroringDeploymentGroupNetwork Immutable. The network that will be used for all child
 *                                                         deployments, for example: `projects/{project}/global/networks/{network}`.
 *                                                         See https://google.aip.dev/124. Please see
 *                                                         {@see MirroringClient::networkName()} for help formatting this field.
 */
function create_mirroring_deployment_group_sample(
    string $formattedParent,
    string $mirroringDeploymentGroupId,
    string $formattedMirroringDeploymentGroupNetwork
): void {
    // Create a client.
    $mirroringClient = new MirroringClient();

    // Prepare the request message.
    $mirroringDeploymentGroup = (new MirroringDeploymentGroup())
        ->setNetwork($formattedMirroringDeploymentGroupNetwork);
    $request = (new CreateMirroringDeploymentGroupRequest())
        ->setParent($formattedParent)
        ->setMirroringDeploymentGroupId($mirroringDeploymentGroupId)
        ->setMirroringDeploymentGroup($mirroringDeploymentGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $mirroringClient->createMirroringDeploymentGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MirroringDeploymentGroup $result */
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
    $formattedParent = MirroringClient::locationName('[PROJECT]', '[LOCATION]');
    $mirroringDeploymentGroupId = '[MIRRORING_DEPLOYMENT_GROUP_ID]';
    $formattedMirroringDeploymentGroupNetwork = MirroringClient::networkName('[PROJECT]', '[NETWORK]');

    create_mirroring_deployment_group_sample(
        $formattedParent,
        $mirroringDeploymentGroupId,
        $formattedMirroringDeploymentGroupNetwork
    );
}
// [END networksecurity_v1_generated_Mirroring_CreateMirroringDeploymentGroup_sync]
