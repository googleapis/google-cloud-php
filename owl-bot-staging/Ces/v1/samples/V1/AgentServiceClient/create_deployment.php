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

// [START ces_v1_generated_AgentService_CreateDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Ces\V1\ChannelProfile;
use Google\Cloud\Ces\V1\Client\AgentServiceClient;
use Google\Cloud\Ces\V1\CreateDeploymentRequest;
use Google\Cloud\Ces\V1\Deployment;

/**
 * Creates a new deployment in the given app.
 *
 * @param string $formattedParent               The parent app.
 *                                              Format:
 *                                              `projects/{project}/locations/{location}/apps/{app}`
 *                                              Please see {@see AgentServiceClient::appName()} for help formatting this field.
 * @param string $deploymentDisplayName         Display name of the deployment.
 * @param string $formattedDeploymentAppVersion The resource name of the app version to deploy.
 *                                              Format:
 *                                              projects/{project}/locations/{location}/apps/{app}/versions/{version}
 *                                              Please see {@see AgentServiceClient::appVersionName()} for help formatting this field.
 */
function create_deployment_sample(
    string $formattedParent,
    string $deploymentDisplayName,
    string $formattedDeploymentAppVersion
): void {
    // Create a client.
    $agentServiceClient = new AgentServiceClient();

    // Prepare the request message.
    $deploymentChannelProfile = new ChannelProfile();
    $deployment = (new Deployment())
        ->setDisplayName($deploymentDisplayName)
        ->setAppVersion($formattedDeploymentAppVersion)
        ->setChannelProfile($deploymentChannelProfile);
    $request = (new CreateDeploymentRequest())
        ->setParent($formattedParent)
        ->setDeployment($deployment);

    // Call the API and handle any network failures.
    try {
        /** @var Deployment $response */
        $response = $agentServiceClient->createDeployment($request);
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
    $formattedParent = AgentServiceClient::appName('[PROJECT]', '[LOCATION]', '[APP]');
    $deploymentDisplayName = '[DISPLAY_NAME]';
    $formattedDeploymentAppVersion = AgentServiceClient::appVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP]',
        '[VERSION]'
    );

    create_deployment_sample($formattedParent, $deploymentDisplayName, $formattedDeploymentAppVersion);
}
// [END ces_v1_generated_AgentService_CreateDeployment_sync]
