<?php
/*
 * Copyright 2025 Google LLC
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

// [START container_v1_generated_ClusterManager_FetchNodePoolUpgradeInfo_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Container\V1\Client\ClusterManagerClient;
use Google\Cloud\Container\V1\FetchNodePoolUpgradeInfoRequest;
use Google\Cloud\Container\V1\NodePoolUpgradeInfo;

/**
 * Fetch upgrade information of a specific nodepool.
 *
 * @param string $name The name (project, location, cluster, nodepool) of the nodepool
 *                     to get. Specified in the format
 *                     `projects/&#42;/locations/&#42;/clusters/&#42;/nodePools/*` or
 *                     `projects/&#42;/zones/&#42;/clusters/&#42;/nodePools/*`.
 */
function fetch_node_pool_upgrade_info_sample(string $name): void
{
    // Create a client.
    $clusterManagerClient = new ClusterManagerClient();

    // Prepare the request message.
    $request = (new FetchNodePoolUpgradeInfoRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var NodePoolUpgradeInfo $response */
        $response = $clusterManagerClient->fetchNodePoolUpgradeInfo($request);
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
    $name = '[NAME]';

    fetch_node_pool_upgrade_info_sample($name);
}
// [END container_v1_generated_ClusterManager_FetchNodePoolUpgradeInfo_sync]
