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

// [START dataproc_v1_generated_NodeGroupController_ResizeNodeGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\NodeGroup;
use Google\Cloud\Dataproc\V1\NodeGroupControllerClient;
use Google\Rpc\Status;

/**
 * Resizes a node group in a cluster. The returned
 * [Operation.metadata][google.longrunning.Operation.metadata] is
 * [NodeGroupOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#nodegroupoperationmetadata).
 *
 * @param string $name The name of the node group to resize.
 *                     Format:
 *                     `projects/{project}/regions/{region}/clusters/{cluster}/nodeGroups/{nodeGroup}`
 * @param int    $size The number of running instances for the node group to maintain.
 *                     The group adds or removes instances to maintain the number of instances
 *                     specified by this parameter.
 */
function resize_node_group_sample(string $name, int $size): void
{
    // Create a client.
    $nodeGroupControllerClient = new NodeGroupControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $nodeGroupControllerClient->resizeNodeGroup($name, $size);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var NodeGroup $result */
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
    $name = '[NAME]';
    $size = 0;

    resize_node_group_sample($name, $size);
}
// [END dataproc_v1_generated_NodeGroupController_ResizeNodeGroup_sync]
