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

// [START vmwareengine_v1_generated_VmwareEngine_CreateVmwareEngineNetwork_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\CreateVmwareEngineNetworkRequest;
use Google\Cloud\VmwareEngine\V1\VmwareEngineNetwork;
use Google\Cloud\VmwareEngine\V1\VmwareEngineNetwork\Type;
use Google\Rpc\Status;

/**
 * Creates a new VMware Engine network that can be used by a private cloud.
 *
 * @param string $formattedParent         The resource name of the location to create the new VMware Engine
 *                                        network in. A VMware Engine network of type
 *                                        `LEGACY` is a regional resource, and a VMware
 *                                        Engine network of type `STANDARD` is a global resource.
 *                                        Resource names are schemeless URIs that follow the conventions in
 *                                        https://cloud.google.com/apis/design/resource_names. For example:
 *                                        `projects/my-project/locations/global`
 *                                        Please see {@see VmwareEngineClient::locationName()} for help formatting this field.
 * @param string $vmwareEngineNetworkId   The user-provided identifier of the new VMware Engine network.
 *                                        This identifier must be unique among VMware Engine network resources
 *                                        within the parent and becomes the final token in the name URI. The
 *                                        identifier must meet the following requirements:
 *
 *                                        * For networks of type LEGACY, adheres to the format:
 *                                        `{region-id}-default`. Replace `{region-id}` with the region where you want
 *                                        to create the VMware Engine network. For example, "us-central1-default".
 *                                        * Only contains 1-63 alphanumeric characters and hyphens
 *                                        * Begins with an alphabetical character
 *                                        * Ends with a non-hyphen character
 *                                        * Not formatted as a UUID
 *                                        * Complies with [RFC 1034](https://datatracker.ietf.org/doc/html/rfc1034)
 *                                        (section 3.5)
 * @param int    $vmwareEngineNetworkType VMware Engine network type.
 */
function create_vmware_engine_network_sample(
    string $formattedParent,
    string $vmwareEngineNetworkId,
    int $vmwareEngineNetworkType
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $vmwareEngineNetwork = (new VmwareEngineNetwork())
        ->setType($vmwareEngineNetworkType);
    $request = (new CreateVmwareEngineNetworkRequest())
        ->setParent($formattedParent)
        ->setVmwareEngineNetworkId($vmwareEngineNetworkId)
        ->setVmwareEngineNetwork($vmwareEngineNetwork);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->createVmwareEngineNetwork($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var VmwareEngineNetwork $result */
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
    $vmwareEngineNetworkId = '[VMWARE_ENGINE_NETWORK_ID]';
    $vmwareEngineNetworkType = Type::TYPE_UNSPECIFIED;

    create_vmware_engine_network_sample(
        $formattedParent,
        $vmwareEngineNetworkId,
        $vmwareEngineNetworkType
    );
}
// [END vmwareengine_v1_generated_VmwareEngine_CreateVmwareEngineNetwork_sync]
