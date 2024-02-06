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

// [START compute_v1_generated_RegionInstanceGroupManagers_RecreateInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersClient;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersRecreateRequest;
use Google\Rpc\Status;

/**
 * Flags the specified VM instances in the managed instance group to be immediately recreated. Each instance is recreated using the group's current configuration. This operation is marked as DONE when the flag is set even if the instances have not yet been recreated. You must separately verify the status of each instance by checking its currentAction field; for more information, see Checking the status of managed instances. If the group is part of a backend service that has enabled connection draining, it can take up to 60 seconds after the connection draining duration has elapsed before the VM instance is removed or deleted. You can specify a maximum of 1000 instances with this method per request.
 *
 * @param string $instanceGroupManager Name of the managed instance group.
 * @param string $project              Project ID for this request.
 * @param string $region               Name of the region scoping this request.
 */
function recreate_instances_sample(
    string $instanceGroupManager,
    string $project,
    string $region
): void {
    // Create a client.
    $regionInstanceGroupManagersClient = new RegionInstanceGroupManagersClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $regionInstanceGroupManagersRecreateRequestResource = new RegionInstanceGroupManagersRecreateRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $regionInstanceGroupManagersClient->recreateInstances(
            $instanceGroupManager,
            $project,
            $region,
            $regionInstanceGroupManagersRecreateRequestResource
        );
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
    $instanceGroupManager = '[INSTANCE_GROUP_MANAGER]';
    $project = '[PROJECT]';
    $region = '[REGION]';

    recreate_instances_sample($instanceGroupManager, $project, $region);
}
// [END compute_v1_generated_RegionInstanceGroupManagers_RecreateInstances_sync]
