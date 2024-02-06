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

// [START apigeeregistry_v1_generated_Registry_CreateApiDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApigeeRegistry\V1\ApiDeployment;
use Google\Cloud\ApigeeRegistry\V1\Client\RegistryClient;
use Google\Cloud\ApigeeRegistry\V1\CreateApiDeploymentRequest;

/**
 * Creates a specified deployment.
 *
 * @param string $formattedParent The parent, which owns this collection of deployments.
 *                                Format: `projects/&#42;/locations/&#42;/apis/*`
 *                                Please see {@see RegistryClient::apiName()} for help formatting this field.
 * @param string $apiDeploymentId The ID to use for the deployment, which will become the final component of
 *                                the deployment's resource name.
 *
 *                                This value should be 4-63 characters, and valid characters
 *                                are /[a-z][0-9]-/.
 *
 *                                Following AIP-162, IDs must not have the form of a UUID.
 */
function create_api_deployment_sample(string $formattedParent, string $apiDeploymentId): void
{
    // Create a client.
    $registryClient = new RegistryClient();

    // Prepare the request message.
    $apiDeployment = new ApiDeployment();
    $request = (new CreateApiDeploymentRequest())
        ->setParent($formattedParent)
        ->setApiDeployment($apiDeployment)
        ->setApiDeploymentId($apiDeploymentId);

    // Call the API and handle any network failures.
    try {
        /** @var ApiDeployment $response */
        $response = $registryClient->createApiDeployment($request);
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
    $formattedParent = RegistryClient::apiName('[PROJECT]', '[LOCATION]', '[API]');
    $apiDeploymentId = '[API_DEPLOYMENT_ID]';

    create_api_deployment_sample($formattedParent, $apiDeploymentId);
}
// [END apigeeregistry_v1_generated_Registry_CreateApiDeployment_sync]
