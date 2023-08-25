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

// [START container_v1_generated_ClusterManager_UpdateMaster_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\Cloud\Container\V1\Operation;

/**
 * Updates the master for a specific cluster.
 *
 * @param string $masterVersion The Kubernetes version to change the master to.
 *
 *                              Users may specify either explicit versions offered by Kubernetes Engine or
 *                              version aliases, which have the following behavior:
 *
 *                              - "latest": picks the highest valid Kubernetes version
 *                              - "1.X": picks the highest valid patch+gke.N patch in the 1.X version
 *                              - "1.X.Y": picks the highest valid gke.N patch in the 1.X.Y version
 *                              - "1.X.Y-gke.N": picks an explicit Kubernetes version
 *                              - "-": picks the default Kubernetes version
 */
function update_master_sample(string $masterVersion): void
{
    // Create a client.
    $clusterManagerClient = new ClusterManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $clusterManagerClient->updateMaster($masterVersion);
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
    $masterVersion = '[MASTER_VERSION]';

    update_master_sample($masterVersion);
}
// [END container_v1_generated_ClusterManager_UpdateMaster_sync]
