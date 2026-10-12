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

// [START networksecurity_v1_generated_Intercept_GetInterceptDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkSecurity\V1\Client\InterceptClient;
use Google\Cloud\NetworkSecurity\V1\GetInterceptDeploymentRequest;
use Google\Cloud\NetworkSecurity\V1\InterceptDeployment;

/**
 * Gets a specific deployment.
 * See https://google.aip.dev/131.
 *
 * @param string $formattedName The name of the deployment to retrieve.
 *                              Format:
 *                              projects/{project}/locations/{location}/interceptDeployments/{intercept_deployment}
 *                              Please see {@see InterceptClient::interceptDeploymentName()} for help formatting this field.
 */
function get_intercept_deployment_sample(string $formattedName): void
{
    // Create a client.
    $interceptClient = new InterceptClient();

    // Prepare the request message.
    $request = (new GetInterceptDeploymentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var InterceptDeployment $response */
        $response = $interceptClient->getInterceptDeployment($request);
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
    $formattedName = InterceptClient::interceptDeploymentName(
        '[PROJECT]',
        '[LOCATION]',
        '[INTERCEPT_DEPLOYMENT]'
    );

    get_intercept_deployment_sample($formattedName);
}
// [END networksecurity_v1_generated_Intercept_GetInterceptDeployment_sync]
