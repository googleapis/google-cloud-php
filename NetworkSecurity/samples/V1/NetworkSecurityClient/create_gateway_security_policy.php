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

// [START networksecurity_v1_generated_NetworkSecurity_CreateGatewaySecurityPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\CreateGatewaySecurityPolicyRequest;
use Google\Cloud\NetworkSecurity\V1\GatewaySecurityPolicy;
use Google\Rpc\Status;

/**
 * Creates a new GatewaySecurityPolicy in a given project and location.
 *
 * @param string $formattedParent           The parent resource of the GatewaySecurityPolicy. Must be in the
 *                                          format `projects/{project}/locations/{location}`. Please see
 *                                          {@see NetworkSecurityClient::locationName()} for help formatting this field.
 * @param string $gatewaySecurityPolicyId   Short name of the GatewaySecurityPolicy resource to be created.
 *                                          This value should be 1-63 characters long, containing only
 *                                          letters, numbers, hyphens, and underscores, and should not start
 *                                          with a number. E.g. "gateway_security_policy1".
 * @param string $gatewaySecurityPolicyName Name of the resource. Name is of the form
 *                                          projects/{project}/locations/{location}/gatewaySecurityPolicies/{gateway_security_policy}
 *                                          gateway_security_policy should match the
 *                                          pattern:(^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$).
 */
function create_gateway_security_policy_sample(
    string $formattedParent,
    string $gatewaySecurityPolicyId,
    string $gatewaySecurityPolicyName
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $gatewaySecurityPolicy = (new GatewaySecurityPolicy())
        ->setName($gatewaySecurityPolicyName);
    $request = (new CreateGatewaySecurityPolicyRequest())
        ->setParent($formattedParent)
        ->setGatewaySecurityPolicyId($gatewaySecurityPolicyId)
        ->setGatewaySecurityPolicy($gatewaySecurityPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->createGatewaySecurityPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GatewaySecurityPolicy $result */
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
    $formattedParent = NetworkSecurityClient::locationName('[PROJECT]', '[LOCATION]');
    $gatewaySecurityPolicyId = '[GATEWAY_SECURITY_POLICY_ID]';
    $gatewaySecurityPolicyName = '[NAME]';

    create_gateway_security_policy_sample(
        $formattedParent,
        $gatewaySecurityPolicyId,
        $gatewaySecurityPolicyName
    );
}
// [END networksecurity_v1_generated_NetworkSecurity_CreateGatewaySecurityPolicy_sync]
