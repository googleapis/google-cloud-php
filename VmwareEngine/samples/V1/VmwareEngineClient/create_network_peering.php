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

// [START vmwareengine_v1_generated_VmwareEngine_CreateNetworkPeering_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\CreateNetworkPeeringRequest;
use Google\Cloud\VmwareEngine\V1\NetworkPeering;
use Google\Cloud\VmwareEngine\V1\NetworkPeering\PeerNetworkType;
use Google\Rpc\Status;

/**
 * Creates a new network peering between the peer network and VMware Engine
 * network provided in a `NetworkPeering` resource. NetworkPeering is a
 * global resource and location can only be global.
 *
 * @param string $formattedParent                            The resource name of the location to create the new network
 *                                                           peering in. This value is always `global`, because `NetworkPeering` is a
 *                                                           global resource. Resource names are schemeless URIs that follow the
 *                                                           conventions in https://cloud.google.com/apis/design/resource_names. For
 *                                                           example: `projects/my-project/locations/global`
 *                                                           Please see {@see VmwareEngineClient::locationName()} for help formatting this field.
 * @param string $networkPeeringId                           The user-provided identifier of the new `NetworkPeering`.
 *                                                           This identifier must be unique among `NetworkPeering` resources within the
 *                                                           parent and becomes the final token in the name URI.
 *                                                           The identifier must meet the following requirements:
 *
 *                                                           * Only contains 1-63 alphanumeric characters and hyphens
 *                                                           * Begins with an alphabetical character
 *                                                           * Ends with a non-hyphen character
 *                                                           * Not formatted as a UUID
 *                                                           * Complies with [RFC 1034](https://datatracker.ietf.org/doc/html/rfc1034)
 *                                                           (section 3.5)
 * @param string $networkPeeringPeerNetwork                  The relative resource name of the network to peer with
 *                                                           a standard VMware Engine network. The provided network can be a
 *                                                           consumer VPC network or another standard VMware Engine network. If the
 *                                                           `peer_network_type` is VMWARE_ENGINE_NETWORK, specify the name in the form:
 *                                                           `projects/{project}/locations/global/vmwareEngineNetworks/{vmware_engine_network_id}`.
 *                                                           Otherwise specify the name in the form:
 *                                                           `projects/{project}/global/networks/{network_id}`, where
 *                                                           `{project}` can either be a project number or a project ID.
 * @param int    $networkPeeringPeerNetworkType              The type of the network to peer with the VMware Engine network.
 * @param string $formattedNetworkPeeringVmwareEngineNetwork The relative resource name of the VMware Engine network.
 *                                                           Specify the name in the following form:
 *                                                           `projects/{project}/locations/{location}/vmwareEngineNetworks/{vmware_engine_network_id}`
 *                                                           where `{project}` can either be a project number or a project ID. Please see
 *                                                           {@see VmwareEngineClient::vmwareEngineNetworkName()} for help formatting this field.
 */
function create_network_peering_sample(
    string $formattedParent,
    string $networkPeeringId,
    string $networkPeeringPeerNetwork,
    int $networkPeeringPeerNetworkType,
    string $formattedNetworkPeeringVmwareEngineNetwork
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $networkPeering = (new NetworkPeering())
        ->setPeerNetwork($networkPeeringPeerNetwork)
        ->setPeerNetworkType($networkPeeringPeerNetworkType)
        ->setVmwareEngineNetwork($formattedNetworkPeeringVmwareEngineNetwork);
    $request = (new CreateNetworkPeeringRequest())
        ->setParent($formattedParent)
        ->setNetworkPeeringId($networkPeeringId)
        ->setNetworkPeering($networkPeering);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->createNetworkPeering($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var NetworkPeering $result */
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
    $networkPeeringId = '[NETWORK_PEERING_ID]';
    $networkPeeringPeerNetwork = '[PEER_NETWORK]';
    $networkPeeringPeerNetworkType = PeerNetworkType::PEER_NETWORK_TYPE_UNSPECIFIED;
    $formattedNetworkPeeringVmwareEngineNetwork = VmwareEngineClient::vmwareEngineNetworkName(
        '[PROJECT]',
        '[LOCATION]',
        '[VMWARE_ENGINE_NETWORK]'
    );

    create_network_peering_sample(
        $formattedParent,
        $networkPeeringId,
        $networkPeeringPeerNetwork,
        $networkPeeringPeerNetworkType,
        $formattedNetworkPeeringVmwareEngineNetwork
    );
}
// [END vmwareengine_v1_generated_VmwareEngine_CreateNetworkPeering_sync]
