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

// [START networkservices_v1_generated_NetworkServices_UpdateEndpointPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\EndpointMatcher;
use Google\Cloud\NetworkServices\V1\EndpointPolicy;
use Google\Cloud\NetworkServices\V1\EndpointPolicy\EndpointPolicyType;
use Google\Cloud\NetworkServices\V1\NetworkServicesClient;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single EndpointPolicy.
 *
 * @param string $endpointPolicyName Name of the EndpointPolicy resource. It matches pattern
 *                                   `projects/{project}/locations/global/endpointPolicies/{endpoint_policy}`.
 * @param int    $endpointPolicyType The type of endpoint policy. This is primarily used to validate
 *                                   the configuration.
 */
function update_endpoint_policy_sample(string $endpointPolicyName, int $endpointPolicyType): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $endpointPolicyEndpointMatcher = new EndpointMatcher();
    $endpointPolicy = (new EndpointPolicy())
        ->setName($endpointPolicyName)
        ->setType($endpointPolicyType)
        ->setEndpointMatcher($endpointPolicyEndpointMatcher);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->updateEndpointPolicy($endpointPolicy);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var EndpointPolicy $result */
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
    $endpointPolicyName = '[NAME]';
    $endpointPolicyType = EndpointPolicyType::ENDPOINT_POLICY_TYPE_UNSPECIFIED;

    update_endpoint_policy_sample($endpointPolicyName, $endpointPolicyType);
}
// [END networkservices_v1_generated_NetworkServices_UpdateEndpointPolicy_sync]
