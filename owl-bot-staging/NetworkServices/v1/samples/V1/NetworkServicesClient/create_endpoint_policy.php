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

// [START networkservices_v1_generated_NetworkServices_CreateEndpointPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateEndpointPolicyRequest;
use Google\Cloud\NetworkServices\V1\EndpointMatcher;
use Google\Cloud\NetworkServices\V1\EndpointPolicy;
use Google\Cloud\NetworkServices\V1\EndpointPolicy\EndpointPolicyType;
use Google\Rpc\Status;

/**
 * Creates a new EndpointPolicy in a given project and location.
 *
 * @param string $formattedParent    The parent resource of the EndpointPolicy. Must be in the
 *                                   format `projects/&#42;/locations/global`. Please see
 *                                   {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $endpointPolicyId   Short name of the EndpointPolicy resource to be created.
 *                                   E.g. "CustomECS".
 * @param string $endpointPolicyName Name of the EndpointPolicy resource. It matches pattern
 *                                   `projects/{project}/locations/global/endpointPolicies/{endpoint_policy}`.
 * @param int    $endpointPolicyType The type of endpoint policy. This is primarily used to validate
 *                                   the configuration.
 */
function create_endpoint_policy_sample(
    string $formattedParent,
    string $endpointPolicyId,
    string $endpointPolicyName,
    int $endpointPolicyType
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $endpointPolicyEndpointMatcher = new EndpointMatcher();
    $endpointPolicy = (new EndpointPolicy())
        ->setName($endpointPolicyName)
        ->setType($endpointPolicyType)
        ->setEndpointMatcher($endpointPolicyEndpointMatcher);
    $request = (new CreateEndpointPolicyRequest())
        ->setParent($formattedParent)
        ->setEndpointPolicyId($endpointPolicyId)
        ->setEndpointPolicy($endpointPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createEndpointPolicy($request);
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
    $formattedParent = NetworkServicesClient::locationName('[PROJECT]', '[LOCATION]');
    $endpointPolicyId = '[ENDPOINT_POLICY_ID]';
    $endpointPolicyName = '[NAME]';
    $endpointPolicyType = EndpointPolicyType::ENDPOINT_POLICY_TYPE_UNSPECIFIED;

    create_endpoint_policy_sample(
        $formattedParent,
        $endpointPolicyId,
        $endpointPolicyName,
        $endpointPolicyType
    );
}
// [END networkservices_v1_generated_NetworkServices_CreateEndpointPolicy_sync]
