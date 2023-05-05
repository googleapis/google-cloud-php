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

// [START compute_v1_generated_RegionInstanceGroupManagers_CreateInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersClient;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersCreateInstancesRequest;
use Google\Rpc\Status;

/**
 * Creates instances with per-instance configurations in this regional managed instance group. Instances are created using the current instance template. The create instances operation is marked DONE if the createInstances request is successful. The underlying actions take additional time. You must separately verify the status of the creating or actions with the listmanagedinstances method.
 *
 * @param string $instanceGroupManager The name of the managed instance group. It should conform to RFC1035.
 * @param string $project              Project ID for this request.
 * @param string $region               The name of the region where the managed instance group is located. It should conform to RFC1035.
 */
function create_instances_sample(
    string $instanceGroupManager,
    string $project,
    string $region
): void {
    // Create a client.
    $regionInstanceGroupManagersClient = new RegionInstanceGroupManagersClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $regionInstanceGroupManagersCreateInstancesRequestResource = new RegionInstanceGroupManagersCreateInstancesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $regionInstanceGroupManagersClient->createInstances(
            $instanceGroupManager,
            $project,
            $region,
            $regionInstanceGroupManagersCreateInstancesRequestResource
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

    create_instances_sample($instanceGroupManager, $project, $region);
}
// [END compute_v1_generated_RegionInstanceGroupManagers_CreateInstances_sync]
