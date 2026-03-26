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

// [START networksecurity_v1_generated_Intercept_CreateInterceptDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\InterceptClient;
use Google\Cloud\NetworkSecurity\V1\CreateInterceptDeploymentRequest;
use Google\Cloud\NetworkSecurity\V1\InterceptDeployment;
use Google\Rpc\Status;

/**
 * Creates a deployment in a given project and location.
 * See https://google.aip.dev/133.
 *
 * @param string $formattedParent                                      The parent resource where this deployment will be created.
 *                                                                     Format: projects/{project}/locations/{location}
 *                                                                     Please see {@see InterceptClient::locationName()} for help formatting this field.
 * @param string $interceptDeploymentId                                The ID to use for the new deployment, which will become the final
 *                                                                     component of the deployment's resource name.
 * @param string $formattedInterceptDeploymentForwardingRule           Immutable. The regional forwarding rule that fronts the
 *                                                                     interceptors, for example:
 *                                                                     `projects/123456789/regions/us-central1/forwardingRules/my-rule`.
 *                                                                     See https://google.aip.dev/124. Please see
 *                                                                     {@see InterceptClient::forwardingRuleName()} for help formatting this field.
 * @param string $formattedInterceptDeploymentInterceptDeploymentGroup Immutable. The deployment group that this deployment is a part
 *                                                                     of, for example:
 *                                                                     `projects/123456789/locations/global/interceptDeploymentGroups/my-dg`.
 *                                                                     See https://google.aip.dev/124. Please see
 *                                                                     {@see InterceptClient::interceptDeploymentGroupName()} for help formatting this field.
 */
function create_intercept_deployment_sample(
    string $formattedParent,
    string $interceptDeploymentId,
    string $formattedInterceptDeploymentForwardingRule,
    string $formattedInterceptDeploymentInterceptDeploymentGroup
): void {
    // Create a client.
    $interceptClient = new InterceptClient();

    // Prepare the request message.
    $interceptDeployment = (new InterceptDeployment())
        ->setForwardingRule($formattedInterceptDeploymentForwardingRule)
        ->setInterceptDeploymentGroup($formattedInterceptDeploymentInterceptDeploymentGroup);
    $request = (new CreateInterceptDeploymentRequest())
        ->setParent($formattedParent)
        ->setInterceptDeploymentId($interceptDeploymentId)
        ->setInterceptDeployment($interceptDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $interceptClient->createInterceptDeployment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InterceptDeployment $result */
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
    $interceptDeploymentId = '[INTERCEPT_DEPLOYMENT_ID]';
    $formattedInterceptDeploymentForwardingRule = InterceptClient::forwardingRuleName(
        '[PROJECT]',
        '[FORWARDING_RULE]'
    );
    $formattedInterceptDeploymentInterceptDeploymentGroup = InterceptClient::interceptDeploymentGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[INTERCEPT_DEPLOYMENT_GROUP]'
    );

    create_intercept_deployment_sample(
        $formattedParent,
        $interceptDeploymentId,
        $formattedInterceptDeploymentForwardingRule,
        $formattedInterceptDeploymentInterceptDeploymentGroup
    );
}
// [END networksecurity_v1_generated_Intercept_CreateInterceptDeployment_sync]
