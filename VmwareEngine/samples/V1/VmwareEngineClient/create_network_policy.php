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

// [START vmwareengine_v1_generated_VmwareEngine_CreateNetworkPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\CreateNetworkPolicyRequest;
use Google\Cloud\VmwareEngine\V1\NetworkPolicy;
use Google\Rpc\Status;

/**
 * Creates a new network policy in a given VMware Engine network of a
 * project and location (region). A new network policy cannot be created if
 * another network policy already exists in the same scope.
 *
 * @param string $formattedParent               The resource name of the location (region)
 *                                              to create the new network policy in.
 *                                              Resource names are schemeless URIs that follow the conventions in
 *                                              https://cloud.google.com/apis/design/resource_names.
 *                                              For example:
 *                                              `projects/my-project/locations/us-central1`
 *                                              Please see {@see VmwareEngineClient::locationName()} for help formatting this field.
 * @param string $networkPolicyId               The user-provided identifier of the network policy to be created.
 *                                              This identifier must be unique within parent
 *                                              `projects/{my-project}/locations/{us-central1}/networkPolicies` and becomes
 *                                              the final token in the name URI.
 *                                              The identifier must meet the following requirements:
 *
 *                                              * Only contains 1-63 alphanumeric characters and hyphens
 *                                              * Begins with an alphabetical character
 *                                              * Ends with a non-hyphen character
 *                                              * Not formatted as a UUID
 *                                              * Complies with [RFC 1034](https://datatracker.ietf.org/doc/html/rfc1034)
 *                                              (section 3.5)
 * @param string $networkPolicyEdgeServicesCidr IP address range in CIDR notation used to create internet access
 *                                              and external IP access. An RFC 1918 CIDR block, with a "/26" prefix, is
 *                                              required. The range cannot overlap with any prefixes either in the consumer
 *                                              VPC network or in use by the private clouds attached to that VPC network.
 */
function create_network_policy_sample(
    string $formattedParent,
    string $networkPolicyId,
    string $networkPolicyEdgeServicesCidr
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $networkPolicy = (new NetworkPolicy())
        ->setEdgeServicesCidr($networkPolicyEdgeServicesCidr);
    $request = (new CreateNetworkPolicyRequest())
        ->setParent($formattedParent)
        ->setNetworkPolicyId($networkPolicyId)
        ->setNetworkPolicy($networkPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->createNetworkPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var NetworkPolicy $result */
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
    $formattedParent = VmwareEngineClient::locationName('[PROJECT]', '[LOCATION]');
    $networkPolicyId = '[NETWORK_POLICY_ID]';
    $networkPolicyEdgeServicesCidr = '[EDGE_SERVICES_CIDR]';

    create_network_policy_sample($formattedParent, $networkPolicyId, $networkPolicyEdgeServicesCidr);
}
// [END vmwareengine_v1_generated_VmwareEngine_CreateNetworkPolicy_sync]
