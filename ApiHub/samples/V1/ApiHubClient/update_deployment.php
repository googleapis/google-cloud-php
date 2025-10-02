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

// [START apihub_v1_generated_ApiHub_UpdateDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\AttributeValues;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\Deployment;
use Google\Cloud\ApiHub\V1\UpdateDeploymentRequest;
use Google\Protobuf\FieldMask;

/**
 * Update a deployment resource in the API hub. The following fields in the
 * [deployment resource][google.cloud.apihub.v1.Deployment] can be
 * updated:
 *
 * * [display_name][google.cloud.apihub.v1.Deployment.display_name]
 * * [description][google.cloud.apihub.v1.Deployment.description]
 * * [documentation][google.cloud.apihub.v1.Deployment.documentation]
 * * [deployment_type][google.cloud.apihub.v1.Deployment.deployment_type]
 * * [resource_uri][google.cloud.apihub.v1.Deployment.resource_uri]
 * * [endpoints][google.cloud.apihub.v1.Deployment.endpoints]
 * * [slo][google.cloud.apihub.v1.Deployment.slo]
 * * [environment][google.cloud.apihub.v1.Deployment.environment]
 * * [attributes][google.cloud.apihub.v1.Deployment.attributes]
 * * [source_project] [google.cloud.apihub.v1.Deployment.source_project]
 * * [source_environment]
 * [google.cloud.apihub.v1.Deployment.source_environment]
 * * [management_url][google.cloud.apihub.v1.Deployment.management_url]
 * * [source_uri][google.cloud.apihub.v1.Deployment.source_uri]
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateDeploymentRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $deploymentDisplayName      The display name of the deployment.
 * @param string $deploymentResourceUri      The resource URI identifies the deployment within its gateway.
 *                                           For Apigee gateways, its recommended to use the format:
 *                                           organizations/{org}/environments/{env}/apis/{api}.
 *                                           For ex: if a proxy with name `orders` is deployed in `staging`
 *                                           environment of `cymbal` organization, the resource URI would be:
 *                                           `organizations/cymbal/environments/staging/apis/orders`.
 * @param string $deploymentEndpointsElement The endpoints at which this deployment resource is listening for
 *                                           API requests. This could be a list of complete URIs, hostnames or an IP
 *                                           addresses.
 */
function update_deployment_sample(
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
    $updateMask = new FieldMask();
    $request = (new UpdateDeploymentRequest())
        ->setDeployment($deployment)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Deployment $response */
        $response = $apiHubClient->updateDeployment($request);
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
    $deploymentDisplayName = '[DISPLAY_NAME]';
    $deploymentResourceUri = '[RESOURCE_URI]';
    $deploymentEndpointsElement = '[ENDPOINTS]';

    update_deployment_sample(
        $deploymentDisplayName,
        $deploymentResourceUri,
        $deploymentEndpointsElement
    );
}
// [END apihub_v1_generated_ApiHub_UpdateDeployment_sync]
