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

// [START vmwareengine_v1_generated_VmwareEngine_UpdateNetworkPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\NetworkPolicy;
use Google\Cloud\VmwareEngine\V1\UpdateNetworkPolicyRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Modifies a `NetworkPolicy` resource. Only the following fields can be
 * updated: `internet_access`, `external_ip`, `edge_services_cidr`.
 * Only fields specified in `updateMask` are applied. When updating a network
 * policy, the external IP network service can only be disabled if there are
 * no external IP addresses present in the scope of the policy. Also, a
 * `NetworkService` cannot be updated when `NetworkService.state` is set
 * to `RECONCILING`.
 *
 * During operation processing, the resource is temporarily in the `ACTIVE`
 * state before the operation fully completes. For that period of time, you
 * can't update the resource. Use the operation status to determine when the
 * processing fully completes.
 *
 * @param string $networkPolicyEdgeServicesCidr IP address range in CIDR notation used to create internet access
 *                                              and external IP access. An RFC 1918 CIDR block, with a "/26" prefix, is
 *                                              required. The range cannot overlap with any prefixes either in the consumer
 *                                              VPC network or in use by the private clouds attached to that VPC network.
 */
function update_network_policy_sample(string $networkPolicyEdgeServicesCidr): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $networkPolicy = (new NetworkPolicy())
        ->setEdgeServicesCidr($networkPolicyEdgeServicesCidr);
    $updateMask = new FieldMask();
    $request = (new UpdateNetworkPolicyRequest())
        ->setNetworkPolicy($networkPolicy)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->updateNetworkPolicy($request);
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
    $networkPolicyEdgeServicesCidr = '[EDGE_SERVICES_CIDR]';

    update_network_policy_sample($networkPolicyEdgeServicesCidr);
}
// [END vmwareengine_v1_generated_VmwareEngine_UpdateNetworkPolicy_sync]
