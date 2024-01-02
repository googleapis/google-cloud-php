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

// [START dataproc_v1_generated_NodeGroupController_CreateNodeGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\NodeGroup;
use Google\Cloud\Dataproc\V1\NodeGroupControllerClient;
use Google\Cloud\Dataproc\V1\NodeGroup\Role;
use Google\Rpc\Status;

/**
 * Creates a node group in a cluster. The returned
 * [Operation.metadata][google.longrunning.Operation.metadata] is
 * [NodeGroupOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#nodegroupoperationmetadata).
 *
 * @param string $formattedParent       The parent resource where this node group will be created.
 *                                      Format: `projects/{project}/regions/{region}/clusters/{cluster}`
 *                                      Please see {@see NodeGroupControllerClient::clusterRegionName()} for help formatting this field.
 * @param int    $nodeGroupRolesElement Node group roles.
 */
function create_node_group_sample(string $formattedParent, int $nodeGroupRolesElement): void
{
    // Create a client.
    $nodeGroupControllerClient = new NodeGroupControllerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $nodeGroupRoles = [$nodeGroupRolesElement,];
    $nodeGroup = (new NodeGroup())
        ->setRoles($nodeGroupRoles);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $nodeGroupControllerClient->createNodeGroup($formattedParent, $nodeGroup);
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
    $formattedParent = NodeGroupControllerClient::clusterRegionName(
        '[PROJECT]',
        '[REGION]',
        '[CLUSTER]'
    );
    $nodeGroupRolesElement = Role::ROLE_UNSPECIFIED;

    create_node_group_sample($formattedParent, $nodeGroupRolesElement);
}
// [END dataproc_v1_generated_NodeGroupController_CreateNodeGroup_sync]
