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

// [START networksecurity_v1_generated_FirewallActivation_UpdateFirewallEndpointAssociation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\FirewallActivationClient;
use Google\Cloud\NetworkSecurity\V1\FirewallEndpointAssociation;
use Google\Cloud\NetworkSecurity\V1\UpdateFirewallEndpointAssociationRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update a single FirewallEndpointAssociation.
 *
 * @param string $firewallEndpointAssociationNetwork          The URL of the network that is being associated.
 * @param string $firewallEndpointAssociationFirewallEndpoint The URL of the FirewallEndpoint that is being associated.
 */
function update_firewall_endpoint_association_sample(
    string $firewallEndpointAssociationNetwork,
    string $firewallEndpointAssociationFirewallEndpoint
): void {
    // Create a client.
    $firewallActivationClient = new FirewallActivationClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $firewallEndpointAssociation = (new FirewallEndpointAssociation())
        ->setNetwork($firewallEndpointAssociationNetwork)
        ->setFirewallEndpoint($firewallEndpointAssociationFirewallEndpoint);
    $request = (new UpdateFirewallEndpointAssociationRequest())
        ->setUpdateMask($updateMask)
        ->setFirewallEndpointAssociation($firewallEndpointAssociation);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firewallActivationClient->updateFirewallEndpointAssociation($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var FirewallEndpointAssociation $result */
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
    $firewallEndpointAssociationNetwork = '[NETWORK]';
    $firewallEndpointAssociationFirewallEndpoint = '[FIREWALL_ENDPOINT]';

    update_firewall_endpoint_association_sample(
        $firewallEndpointAssociationNetwork,
        $firewallEndpointAssociationFirewallEndpoint
    );
}
// [END networksecurity_v1_generated_FirewallActivation_UpdateFirewallEndpointAssociation_sync]
