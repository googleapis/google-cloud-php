<?php
/*
 * Copyright 2025 Google LLC
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

// [START cloudsecuritycompliance_v1_generated_Deployment_CreateFrameworkDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CloudSecurityCompliance\V1\Client\DeploymentClient;
use Google\Cloud\CloudSecurityCompliance\V1\CloudControlDetails;
use Google\Cloud\CloudSecurityCompliance\V1\CloudControlMetadata;
use Google\Cloud\CloudSecurityCompliance\V1\CreateFrameworkDeploymentRequest;
use Google\Cloud\CloudSecurityCompliance\V1\EnforcementMode;
use Google\Cloud\CloudSecurityCompliance\V1\FrameworkDeployment;
use Google\Cloud\CloudSecurityCompliance\V1\FrameworkReference;
use Google\Cloud\CloudSecurityCompliance\V1\TargetResourceConfig;
use Google\Rpc\Status;

/**
 * Creates a new FrameworkDeployment in a given parent resource.
 *
 * @param string $formattedParent                                                           The parent resource of the FrameworkDeployment in the format:
 *                                                                                          organizations/{organization}/locations/{location}
 *                                                                                          Only global location is supported. Please see
 *                                                                                          {@see DeploymentClient::organizationLocationName()} for help formatting this field.
 * @param string $frameworkDeploymentFrameworkFramework                                     In the format:
 *                                                                                          organizations/{org}/locations/{location}/frameworks/{framework}
 * @param string $frameworkDeploymentCloudControlMetadataCloudControlDetailsName            The name of the CloudControl in the format:
 *                                                                                          “organizations/{organization}/locations/{location}/
 *                                                                                          cloudControls/{cloud-control}”
 * @param int    $frameworkDeploymentCloudControlMetadataCloudControlDetailsMajorRevisionId Major revision of cloudcontrol
 * @param int    $frameworkDeploymentCloudControlMetadataEnforcementMode                    Enforcement mode of the cloud control
 */
function create_framework_deployment_sample(
    string $formattedParent,
    string $frameworkDeploymentFrameworkFramework,
    string $frameworkDeploymentCloudControlMetadataCloudControlDetailsName,
    int $frameworkDeploymentCloudControlMetadataCloudControlDetailsMajorRevisionId,
    int $frameworkDeploymentCloudControlMetadataEnforcementMode
): void {
    // Create a client.
    $deploymentClient = new DeploymentClient();

    // Prepare the request message.
    $frameworkDeploymentTargetResourceConfig = new TargetResourceConfig();
    $frameworkDeploymentFramework = (new FrameworkReference())
        ->setFramework($frameworkDeploymentFrameworkFramework);
    $frameworkDeploymentCloudControlMetadataCloudControlDetails = (new CloudControlDetails())
        ->setName($frameworkDeploymentCloudControlMetadataCloudControlDetailsName)
        ->setMajorRevisionId($frameworkDeploymentCloudControlMetadataCloudControlDetailsMajorRevisionId);
    $cloudControlMetadata = (new CloudControlMetadata())
        ->setCloudControlDetails($frameworkDeploymentCloudControlMetadataCloudControlDetails)
        ->setEnforcementMode($frameworkDeploymentCloudControlMetadataEnforcementMode);
    $frameworkDeploymentCloudControlMetadata = [$cloudControlMetadata,];
    $frameworkDeployment = (new FrameworkDeployment())
        ->setTargetResourceConfig($frameworkDeploymentTargetResourceConfig)
        ->setFramework($frameworkDeploymentFramework)
        ->setCloudControlMetadata($frameworkDeploymentCloudControlMetadata);
    $request = (new CreateFrameworkDeploymentRequest())
        ->setParent($formattedParent)
        ->setFrameworkDeployment($frameworkDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $deploymentClient->createFrameworkDeployment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var FrameworkDeployment $result */
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
    $formattedParent = DeploymentClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $frameworkDeploymentFrameworkFramework = '[FRAMEWORK]';
    $frameworkDeploymentCloudControlMetadataCloudControlDetailsName = '[NAME]';
    $frameworkDeploymentCloudControlMetadataCloudControlDetailsMajorRevisionId = 0;
    $frameworkDeploymentCloudControlMetadataEnforcementMode = EnforcementMode::ENFORCEMENT_MODE_UNSPECIFIED;

    create_framework_deployment_sample(
        $formattedParent,
        $frameworkDeploymentFrameworkFramework,
        $frameworkDeploymentCloudControlMetadataCloudControlDetailsName,
        $frameworkDeploymentCloudControlMetadataCloudControlDetailsMajorRevisionId,
        $frameworkDeploymentCloudControlMetadataEnforcementMode
    );
}
// [END cloudsecuritycompliance_v1_generated_Deployment_CreateFrameworkDeployment_sync]
