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

// [START vmwareengine_v1_generated_VmwareEngine_GetVmwareEngineNetwork_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\GetVmwareEngineNetworkRequest;
use Google\Cloud\VmwareEngine\V1\VmwareEngineNetwork;

/**
 * Retrieves a `VmwareEngineNetwork` resource by its resource name. The
 * resource contains details of the VMware Engine network, such as its VMware
 * Engine network type, peered networks in a service project, and state
 * (for example, `CREATING`, `ACTIVE`, `DELETING`).
 *
 * @param string $formattedName The resource name of the VMware Engine network to retrieve.
 *                              Resource names are schemeless URIs that follow the conventions in
 *                              https://cloud.google.com/apis/design/resource_names.
 *                              For example:
 *                              `projects/my-project/locations/global/vmwareEngineNetworks/my-network`
 *                              Please see {@see VmwareEngineClient::vmwareEngineNetworkName()} for help formatting this field.
 */
function get_vmware_engine_network_sample(string $formattedName): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $request = (new GetVmwareEngineNetworkRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var VmwareEngineNetwork $response */
        $response = $vmwareEngineClient->getVmwareEngineNetwork($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = VmwareEngineClient::vmwareEngineNetworkName(
        '[PROJECT]',
        '[LOCATION]',
        '[VMWARE_ENGINE_NETWORK]'
    );

    get_vmware_engine_network_sample($formattedName);
}
// [END vmwareengine_v1_generated_VmwareEngine_GetVmwareEngineNetwork_sync]
