<?php
/*
 * Copyright 2023 Google LLC
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

// [START edgenetwork_v1_generated_EdgeNetwork_CreateSubnet_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\EdgeNetwork\V1\Client\EdgeNetworkClient;
use Google\Cloud\EdgeNetwork\V1\CreateSubnetRequest;
use Google\Cloud\EdgeNetwork\V1\Subnet;
use Google\Rpc\Status;

/**
 * Creates a new Subnet in a given project and location.
 *
 * @param string $formattedParent        Value for parent. Please see
 *                                       {@see EdgeNetworkClient::zoneName()} for help formatting this field.
 * @param string $subnetId               Id of the requesting object
 *                                       If auto-generating Id server-side, remove this field and
 *                                       subnet_id from the method_signature of Create RPC
 * @param string $subnetName             The canonical resource name of the subnet.
 * @param string $formattedSubnetNetwork The network that this subnetwork belongs to. Please see
 *                                       {@see EdgeNetworkClient::networkName()} for help formatting this field.
 */
function create_subnet_sample(
    string $formattedParent,
    string $subnetId,
    string $subnetName,
    string $formattedSubnetNetwork
): void {
    // Create a client.
    $edgeNetworkClient = new EdgeNetworkClient();

    // Prepare the request message.
    $subnet = (new Subnet())
        ->setName($subnetName)
        ->setNetwork($formattedSubnetNetwork);
    $request = (new CreateSubnetRequest())
        ->setParent($formattedParent)
        ->setSubnetId($subnetId)
        ->setSubnet($subnet);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $edgeNetworkClient->createSubnet($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Subnet $result */
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
    $formattedParent = EdgeNetworkClient::zoneName('[PROJECT]', '[LOCATION]', '[ZONE]');
    $subnetId = '[SUBNET_ID]';
    $subnetName = '[NAME]';
    $formattedSubnetNetwork = EdgeNetworkClient::networkName(
        '[PROJECT]',
        '[LOCATION]',
        '[ZONE]',
        '[NETWORK]'
    );

    create_subnet_sample($formattedParent, $subnetId, $subnetName, $formattedSubnetNetwork);
}
// [END edgenetwork_v1_generated_EdgeNetwork_CreateSubnet_sync]
