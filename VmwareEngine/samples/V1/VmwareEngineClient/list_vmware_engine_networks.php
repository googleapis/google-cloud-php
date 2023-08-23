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

// [START vmwareengine_v1_generated_VmwareEngine_ListVmwareEngineNetworks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\ListVmwareEngineNetworksRequest;
use Google\Cloud\VmwareEngine\V1\VmwareEngineNetwork;

/**
 * Lists `VmwareEngineNetwork` resources in a given project and location.
 *
 * @param string $formattedParent The resource name of the location to query for
 *                                VMware Engine networks. Resource names are schemeless URIs that follow the
 *                                conventions in https://cloud.google.com/apis/design/resource_names. For
 *                                example: `projects/my-project/locations/global`
 *                                Please see {@see VmwareEngineClient::locationName()} for help formatting this field.
 */
function list_vmware_engine_networks_sample(string $formattedParent): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $request = (new ListVmwareEngineNetworksRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $vmwareEngineClient->listVmwareEngineNetworks($request);

        /** @var VmwareEngineNetwork $element */
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
    $formattedParent = VmwareEngineClient::locationName('[PROJECT]', '[LOCATION]');

    list_vmware_engine_networks_sample($formattedParent);
}
// [END vmwareengine_v1_generated_VmwareEngine_ListVmwareEngineNetworks_sync]
