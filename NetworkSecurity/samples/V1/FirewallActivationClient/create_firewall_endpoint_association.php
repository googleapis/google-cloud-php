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

// [START networksecurity_v1_generated_FirewallActivation_CreateFirewallEndpointAssociation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\FirewallActivationClient;
use Google\Cloud\NetworkSecurity\V1\CreateFirewallEndpointAssociationRequest;
use Google\Cloud\NetworkSecurity\V1\FirewallEndpointAssociation;
use Google\Rpc\Status;

/**
 * Creates a new FirewallEndpointAssociation in a given project and location.
 *
 * @param string $formattedParent                             Value for parent. Please see
 *                                                            {@see FirewallActivationClient::locationName()} for help formatting this field.
 * @param string $firewallEndpointAssociationNetwork          The URL of the network that is being associated.
 * @param string $firewallEndpointAssociationFirewallEndpoint The URL of the FirewallEndpoint that is being associated.
 */
function create_firewall_endpoint_association_sample(
    string $formattedParent,
    string $firewallEndpointAssociationNetwork,
    string $firewallEndpointAssociationFirewallEndpoint
): void {
    // Create a client.
    $firewallActivationClient = new FirewallActivationClient();

    // Prepare the request message.
    $firewallEndpointAssociation = (new FirewallEndpointAssociation())
        ->setNetwork($firewallEndpointAssociationNetwork)
        ->setFirewallEndpoint($firewallEndpointAssociationFirewallEndpoint);
    $request = (new CreateFirewallEndpointAssociationRequest())
        ->setParent($formattedParent)
        ->setFirewallEndpointAssociation($firewallEndpointAssociation);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firewallActivationClient->createFirewallEndpointAssociation($request);
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
    $formattedParent = FirewallActivationClient::locationName('[PROJECT]', '[LOCATION]');
    $firewallEndpointAssociationNetwork = '[NETWORK]';
    $firewallEndpointAssociationFirewallEndpoint = '[FIREWALL_ENDPOINT]';

    create_firewall_endpoint_association_sample(
        $formattedParent,
        $firewallEndpointAssociationNetwork,
        $firewallEndpointAssociationFirewallEndpoint
    );
}
// [END networksecurity_v1_generated_FirewallActivation_CreateFirewallEndpointAssociation_sync]
