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

// [START compute_v1_generated_NetworkEndpointGroups_Delete_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\NetworkEndpointGroupsClient;
use Google\Rpc\Status;

/**
 * Deletes the specified network endpoint group. The network endpoints in the NEG and the VM instances they belong to are not terminated when the NEG is deleted. Note that the NEG cannot be deleted if there are backend services referencing it.
 *
 * @param string $networkEndpointGroup The name of the network endpoint group to delete. It should comply with RFC1035.
 * @param string $project              Project ID for this request.
 * @param string $zone                 The name of the zone where the network endpoint group is located. It should comply with RFC1035.
 */
function delete_sample(string $networkEndpointGroup, string $project, string $zone): void
{
    // Create a client.
    $networkEndpointGroupsClient = new NetworkEndpointGroupsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkEndpointGroupsClient->delete($networkEndpointGroup, $project, $zone);
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
    $networkEndpointGroup = '[NETWORK_ENDPOINT_GROUP]';
    $project = '[PROJECT]';
    $zone = '[ZONE]';

    delete_sample($networkEndpointGroup, $project, $zone);
}
// [END compute_v1_generated_NetworkEndpointGroups_Delete_sync]
