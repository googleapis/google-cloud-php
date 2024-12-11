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

// [START compute_v1_generated_InstanceGroupManagers_StartInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\InstanceGroupManagersClient;
use Google\Cloud\Compute\V1\InstanceGroupManagersStartInstancesRequest;
use Google\Cloud\Compute\V1\StartInstancesInstanceGroupManagerRequest;
use Google\Rpc\Status;

/**
 * Flags the specified instances in the managed instance group to be started. This method increases the targetSize and decreases the targetStoppedSize of the managed instance group by the number of instances that you start. The startInstances operation is marked DONE if the startInstances request is successful. The underlying actions take additional time. You must separately verify the status of the STARTING action with the listmanagedinstances method. In this request, you can only specify instances that are stopped. For example, if an instance was previously stopped using the stopInstances method, it can be started using the startInstances method. If a health check is attached to the managed instance group, the specified instances will be verified as healthy after they are started. You can specify a maximum of 1000 instances with this method per request.
 *
 * @param string $instanceGroupManager The name of the managed instance group.
 * @param string $project              Project ID for this request.
 * @param string $zone                 The name of the zone where the managed instance group is located.
 */
function start_instances_sample(string $instanceGroupManager, string $project, string $zone): void
{
    // Create a client.
    $instanceGroupManagersClient = new InstanceGroupManagersClient();

    // Prepare the request message.
    $instanceGroupManagersStartInstancesRequestResource = new InstanceGroupManagersStartInstancesRequest();
    $request = (new StartInstancesInstanceGroupManagerRequest())
        ->setInstanceGroupManager($instanceGroupManager)
        ->setInstanceGroupManagersStartInstancesRequestResource(
            $instanceGroupManagersStartInstancesRequestResource
        )
        ->setProject($project)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceGroupManagersClient->startInstances($request);
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
    $zone = '[ZONE]';

    start_instances_sample($instanceGroupManager, $project, $zone);
}
// [END compute_v1_generated_InstanceGroupManagers_StartInstances_sync]
