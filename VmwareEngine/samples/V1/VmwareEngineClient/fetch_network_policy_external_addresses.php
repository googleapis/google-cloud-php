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

// [START vmwareengine_v1_generated_VmwareEngine_FetchNetworkPolicyExternalAddresses_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\ExternalAddress;
use Google\Cloud\VmwareEngine\V1\FetchNetworkPolicyExternalAddressesRequest;

/**
 * Lists external IP addresses assigned to VMware workload VMs within the
 * scope of the given network policy.
 *
 * @param string $formattedNetworkPolicy The resource name of the network policy to query for assigned
 *                                       external IP addresses. Resource names are schemeless URIs that follow the
 *                                       conventions in https://cloud.google.com/apis/design/resource_names. For
 *                                       example:
 *                                       `projects/my-project/locations/us-central1/networkPolicies/my-policy`
 *                                       Please see {@see VmwareEngineClient::networkPolicyName()} for help formatting this field.
 */
function fetch_network_policy_external_addresses_sample(string $formattedNetworkPolicy): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $request = (new FetchNetworkPolicyExternalAddressesRequest())
        ->setNetworkPolicy($formattedNetworkPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $vmwareEngineClient->fetchNetworkPolicyExternalAddresses($request);

        /** @var ExternalAddress $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedNetworkPolicy = VmwareEngineClient::networkPolicyName(
        '[PROJECT]',
        '[LOCATION]',
        '[NETWORK_POLICY]'
    );

    fetch_network_policy_external_addresses_sample($formattedNetworkPolicy);
}
// [END vmwareengine_v1_generated_VmwareEngine_FetchNetworkPolicyExternalAddresses_sync]
