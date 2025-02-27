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

// [START compute_v1_generated_RegionInstanceGroups_SetNamedPorts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\RegionInstanceGroupsClient;
use Google\Cloud\Compute\V1\RegionInstanceGroupsSetNamedPortsRequest;
use Google\Cloud\Compute\V1\SetNamedPortsRegionInstanceGroupRequest;
use Google\Rpc\Status;

/**
 * Sets the named ports for the specified regional instance group.
 *
 * @param string $instanceGroup The name of the regional instance group where the named ports are updated.
 * @param string $project       Project ID for this request.
 * @param string $region        Name of the region scoping this request.
 */
function set_named_ports_sample(string $instanceGroup, string $project, string $region): void
{
    // Create a client.
    $regionInstanceGroupsClient = new RegionInstanceGroupsClient();

    // Prepare the request message.
    $regionInstanceGroupsSetNamedPortsRequestResource = new RegionInstanceGroupsSetNamedPortsRequest();
    $request = (new SetNamedPortsRegionInstanceGroupRequest())
        ->setInstanceGroup($instanceGroup)
        ->setProject($project)
        ->setRegion($region)
        ->setRegionInstanceGroupsSetNamedPortsRequestResource(
            $regionInstanceGroupsSetNamedPortsRequestResource
        );

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $regionInstanceGroupsClient->setNamedPorts($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $instanceGroup = '[INSTANCE_GROUP]';
    $project = '[PROJECT]';
    $region = '[REGION]';

    set_named_ports_sample($instanceGroup, $project, $region);
}
// [END compute_v1_generated_RegionInstanceGroups_SetNamedPorts_sync]
