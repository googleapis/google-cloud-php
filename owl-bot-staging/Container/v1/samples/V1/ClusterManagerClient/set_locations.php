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

// [START container_v1_generated_ClusterManager_SetLocations_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\Cloud\Container\V1\Operation;

/**
 * Sets the locations for a specific cluster.
 * Deprecated. Use
 * [projects.locations.clusters.update](https://cloud.google.com/kubernetes-engine/docs/reference/rest/v1/projects.locations.clusters/update)
 * instead.
 *
 * @param string $locationsElement The desired list of Google Compute Engine
 *                                 [zones](https://cloud.google.com/compute/docs/zones#available) in which the
 *                                 cluster's nodes should be located. Changing the locations a cluster is in
 *                                 will result in nodes being either created or removed from the cluster,
 *                                 depending on whether locations are being added or removed.
 *
 *                                 This list must always include the cluster's primary zone.
 */
function set_locations_sample(string $locationsElement): void
{
    // Create a client.
    $clusterManagerClient = new ClusterManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $locations = [$locationsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $clusterManagerClient->setLocations($locations);
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
    $locationsElement = '[LOCATIONS]';

    set_locations_sample($locationsElement);
}
// [END container_v1_generated_ClusterManager_SetLocations_sync]
