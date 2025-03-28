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

// [START apihub_v1_generated_ApiHub_CreateDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\AttributeValues;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\CreateDeploymentRequest;
use Google\Cloud\ApiHub\V1\Deployment;

/**
 * Create a deployment resource in the API hub.
 * Once a deployment resource is created, it can be associated with API
 * versions.
 *
 * @param string $formattedParent            The parent resource for the deployment resource.
 *                                           Format: `projects/{project}/locations/{location}`
 *                                           Please see {@see ApiHubClient::locationName()} for help formatting this field.
 * @param string $deploymentDisplayName      The display name of the deployment.
 * @param string $deploymentResourceUri      A URI to the runtime resource. This URI can be used to manage the
 *                                           resource. For example, if the runtime resource is of type APIGEE_PROXY,
 *                                           then this field will contain the URI to the management UI of the proxy.
 * @param string $deploymentEndpointsElement The endpoints at which this deployment resource is listening for
 *                                           API requests. This could be a list of complete URIs, hostnames or an IP
 *                                           addresses.
 */
function create_deployment_sample(
    string $formattedParent,
    string $deploymentDisplayName,
    string $deploymentResourceUri,
    string $deploymentEndpointsElement
): void {
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $deploymentDeploymentType = new AttributeValues();
    $deploymentEndpoints = [$deploymentEndpointsElement,];
    $deployment = (new Deployment())
        ->setDisplayName($deploymentDisplayName)
        ->setDeploymentType($deploymentDeploymentType)
        ->setResourceUri($deploymentResourceUri)
        ->setEndpoints($deploymentEndpoints);
    $request = (new CreateDeploymentRequest())
        ->setParent($formattedParent)
        ->setDeployment($deployment);

    // Call the API and handle any network failures.
    try {
        /** @var Deployment $response */
        $response = $apiHubClient->createDeployment($request);
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
    $formattedParent = ApiHubClient::locationName('[PROJECT]', '[LOCATION]');
    $deploymentDisplayName = '[DISPLAY_NAME]';
    $deploymentResourceUri = '[RESOURCE_URI]';
    $deploymentEndpointsElement = '[ENDPOINTS]';

    create_deployment_sample(
        $formattedParent,
        $deploymentDisplayName,
        $deploymentResourceUri,
        $deploymentEndpointsElement
    );
}
// [END apihub_v1_generated_ApiHub_CreateDeployment_sync]
