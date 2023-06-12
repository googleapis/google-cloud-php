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

// [START vmwareengine_v1_generated_VmwareEngine_UpdatePrivateConnection_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\PrivateConnection;
use Google\Cloud\VmwareEngine\V1\PrivateConnection\Type;
use Google\Cloud\VmwareEngine\V1\UpdatePrivateConnectionRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Modifies a `PrivateConnection` resource. Only `description` and
 * `routing_mode` fields can be updated. Only fields specified in `updateMask`
 * are applied.
 *
 * @param string $formattedPrivateConnectionVmwareEngineNetwork The relative resource name of Legacy VMware Engine network.
 *                                                              Specify the name in the following form:
 *                                                              `projects/{project}/locations/{location}/vmwareEngineNetworks/{vmware_engine_network_id}`
 *                                                              where `{project}`, `{location}` will be same as specified in private
 *                                                              connection resource name and `{vmware_engine_network_id}` will be in the
 *                                                              form of `{location}`-default e.g.
 *                                                              projects/project/locations/us-central1/vmwareEngineNetworks/us-central1-default. Please see
 *                                                              {@see VmwareEngineClient::vmwareEngineNetworkName()} for help formatting this field.
 * @param int    $privateConnectionType                         Private connection type.
 * @param string $formattedPrivateConnectionServiceNetwork      Service network to create private connection.
 *                                                              Specify the name in the following form:
 *                                                              `projects/{project}/global/networks/{network_id}`
 *                                                              For type = PRIVATE_SERVICE_ACCESS, this field represents servicenetworking
 *                                                              VPC, e.g. projects/project-tp/global/networks/servicenetworking.
 *                                                              For type = NETAPP_CLOUD_VOLUME, this field represents NetApp service VPC,
 *                                                              e.g. projects/project-tp/global/networks/netapp-tenant-vpc.
 *                                                              For type = DELL_POWERSCALE, this field represent Dell service VPC, e.g.
 *                                                              projects/project-tp/global/networks/dell-tenant-vpc.
 *                                                              For type= THIRD_PARTY_SERVICE, this field could represent a consumer VPC or
 *                                                              any other producer VPC to which the VMware Engine Network needs to be
 *                                                              connected, e.g. projects/project/global/networks/vpc. Please see
 *                                                              {@see VmwareEngineClient::networkName()} for help formatting this field.
 */
function update_private_connection_sample(
    string $formattedPrivateConnectionVmwareEngineNetwork,
    int $privateConnectionType,
    string $formattedPrivateConnectionServiceNetwork
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $privateConnection = (new PrivateConnection())
        ->setVmwareEngineNetwork($formattedPrivateConnectionVmwareEngineNetwork)
        ->setType($privateConnectionType)
        ->setServiceNetwork($formattedPrivateConnectionServiceNetwork);
    $updateMask = new FieldMask();
    $request = (new UpdatePrivateConnectionRequest())
        ->setPrivateConnection($privateConnection)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->updatePrivateConnection($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PrivateConnection $result */
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
    $formattedPrivateConnectionVmwareEngineNetwork = VmwareEngineClient::vmwareEngineNetworkName(
        '[PROJECT]',
        '[LOCATION]',
        '[VMWARE_ENGINE_NETWORK]'
    );
    $privateConnectionType = Type::TYPE_UNSPECIFIED;
    $formattedPrivateConnectionServiceNetwork = VmwareEngineClient::networkName(
        '[PROJECT]',
        '[NETWORK]'
    );

    update_private_connection_sample(
        $formattedPrivateConnectionVmwareEngineNetwork,
        $privateConnectionType,
        $formattedPrivateConnectionServiceNetwork
    );
}
// [END vmwareengine_v1_generated_VmwareEngine_UpdatePrivateConnection_sync]
