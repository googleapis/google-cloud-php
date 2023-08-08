<?php
/*
 * Copyright 2023 Google LLC
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

// [START container_v1_generated_ClusterManager_SetMaintenancePolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\Cloud\Container\V1\MaintenancePolicy;
use Google\Cloud\Container\V1\Operation;

/**
 * Sets the maintenance policy for a cluster.
 *
 * @param string $projectId The Google Developers Console [project ID or project
 *                          number](https://cloud.google.com/resource-manager/docs/creating-managing-projects).
 * @param string $zone      The name of the Google Compute Engine
 *                          [zone](https://cloud.google.com/compute/docs/zones#available) in which the
 *                          cluster resides.
 * @param string $clusterId The name of the cluster to update.
 */
function set_maintenance_policy_sample(string $projectId, string $zone, string $clusterId): void
{
    // Create a client.
    $clusterManagerClient = new ClusterManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $maintenancePolicy = new MaintenancePolicy();

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $clusterManagerClient->setMaintenancePolicy(
            $projectId,
            $zone,
            $clusterId,
            $maintenancePolicy
        );
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
    $projectId = '[PROJECT_ID]';
    $zone = '[ZONE]';
    $clusterId = '[CLUSTER_ID]';

    set_maintenance_policy_sample($projectId, $zone, $clusterId);
}
// [END container_v1_generated_ClusterManager_SetMaintenancePolicy_sync]
