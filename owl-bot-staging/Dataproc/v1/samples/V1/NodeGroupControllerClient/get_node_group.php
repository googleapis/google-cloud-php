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

// [START dataproc_v1_generated_NodeGroupController_GetNodeGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\NodeGroup;
use Google\Cloud\Dataproc\V1\NodeGroupControllerClient;

/**
 * Gets the resource representation for a node group in a
 * cluster.
 *
 * @param string $formattedName The name of the node group to retrieve.
 *                              Format:
 *                              `projects/{project}/regions/{region}/clusters/{cluster}/nodeGroups/{nodeGroup}`
 *                              Please see {@see NodeGroupControllerClient::nodeGroupName()} for help formatting this field.
 */
function get_node_group_sample(string $formattedName): void
{
    // Create a client.
    $nodeGroupControllerClient = new NodeGroupControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var NodeGroup $response */
        $response = $nodeGroupControllerClient->getNodeGroup($formattedName);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = NodeGroupControllerClient::nodeGroupName(
        '[PROJECT]',
        '[REGION]',
        '[CLUSTER]',
        '[NODE_GROUP]'
    );

    get_node_group_sample($formattedName);
}
// [END dataproc_v1_generated_NodeGroupController_GetNodeGroup_sync]
