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

// [START networksecurity_v1_generated_Intercept_CreateInterceptDeploymentGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\InterceptClient;
use Google\Cloud\NetworkSecurity\V1\CreateInterceptDeploymentGroupRequest;
use Google\Cloud\NetworkSecurity\V1\InterceptDeploymentGroup;
use Google\Rpc\Status;

/**
 * Creates a deployment group in a given project and location.
 * See https://google.aip.dev/133.
 *
 * @param string $formattedParent                          The parent resource where this deployment group will be created.
 *                                                         Format: projects/{project}/locations/{location}
 *                                                         Please see {@see InterceptClient::locationName()} for help formatting this field.
 * @param string $interceptDeploymentGroupId               The ID to use for the new deployment group, which will become the
 *                                                         final component of the deployment group's resource name.
 * @param string $formattedInterceptDeploymentGroupNetwork Immutable. The network that will be used for all child
 *                                                         deployments, for example: `projects/{project}/global/networks/{network}`.
 *                                                         See https://google.aip.dev/124. Please see
 *                                                         {@see InterceptClient::networkName()} for help formatting this field.
 */
function create_intercept_deployment_group_sample(
    string $formattedParent,
    string $interceptDeploymentGroupId,
    string $formattedInterceptDeploymentGroupNetwork
): void {
    // Create a client.
    $interceptClient = new InterceptClient();

    // Prepare the request message.
    $interceptDeploymentGroup = (new InterceptDeploymentGroup())
        ->setNetwork($formattedInterceptDeploymentGroupNetwork);
    $request = (new CreateInterceptDeploymentGroupRequest())
        ->setParent($formattedParent)
        ->setInterceptDeploymentGroupId($interceptDeploymentGroupId)
        ->setInterceptDeploymentGroup($interceptDeploymentGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $interceptClient->createInterceptDeploymentGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InterceptDeploymentGroup $result */
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
    $formattedParent = InterceptClient::locationName('[PROJECT]', '[LOCATION]');
    $interceptDeploymentGroupId = '[INTERCEPT_DEPLOYMENT_GROUP_ID]';
    $formattedInterceptDeploymentGroupNetwork = InterceptClient::networkName('[PROJECT]', '[NETWORK]');

    create_intercept_deployment_group_sample(
        $formattedParent,
        $interceptDeploymentGroupId,
        $formattedInterceptDeploymentGroupNetwork
    );
}
// [END networksecurity_v1_generated_Intercept_CreateInterceptDeploymentGroup_sync]
