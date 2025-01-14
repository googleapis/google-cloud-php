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

// [START compute_v1_generated_InstanceGroupManagerResizeRequests_Cancel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\CancelInstanceGroupManagerResizeRequestRequest;
use Google\Cloud\Compute\V1\Client\InstanceGroupManagerResizeRequestsClient;
use Google\Rpc\Status;

/**
 * Cancels the specified resize request and removes it from the queue. Cancelled resize request does no longer wait for the resources to be provisioned. Cancel is only possible for requests that are accepted in the queue.
 *
 * @param string $instanceGroupManager The name of the managed instance group. The name should conform to RFC1035 or be a resource ID.
 * @param string $project              Project ID for this request.
 * @param string $resizeRequest        The name of the resize request to cancel. The name should conform to RFC1035 or be a resource ID.
 * @param string $zone                 The name of the zone where the managed instance group is located. The name should conform to RFC1035.
 */
function cancel_sample(
    string $instanceGroupManager,
    string $project,
    string $resizeRequest,
    string $zone
): void {
    // Create a client.
    $instanceGroupManagerResizeRequestsClient = new InstanceGroupManagerResizeRequestsClient();

    // Prepare the request message.
    $request = (new CancelInstanceGroupManagerResizeRequestRequest())
        ->setInstanceGroupManager($instanceGroupManager)
        ->setProject($project)
        ->setResizeRequest($resizeRequest)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instanceGroupManagerResizeRequestsClient->cancel($request);
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
    $resizeRequest = '[RESIZE_REQUEST]';
    $zone = '[ZONE]';

    cancel_sample($instanceGroupManager, $project, $resizeRequest, $zone);
}
// [END compute_v1_generated_InstanceGroupManagerResizeRequests_Cancel_sync]
