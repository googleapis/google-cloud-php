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

// [START container_v1_generated_ClusterManager_SetMonitoringService_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\Cloud\Container\V1\Operation;

/**
 * Sets the monitoring service for a specific cluster.
 *
 * @param string $monitoringService The monitoring service the cluster should use to write metrics.
 *                                  Currently available options:
 *
 *                                  * "monitoring.googleapis.com/kubernetes" - The Cloud Monitoring
 *                                  service with a Kubernetes-native resource model
 *                                  * `monitoring.googleapis.com` - The legacy Cloud Monitoring service (no
 *                                  longer available as of GKE 1.15).
 *                                  * `none` - No metrics will be exported from the cluster.
 *
 *                                  If left as an empty string,`monitoring.googleapis.com/kubernetes` will be
 *                                  used for GKE 1.14+ or `monitoring.googleapis.com` for earlier versions.
 */
function set_monitoring_service_sample(string $monitoringService): void
{
    // Create a client.
    $clusterManagerClient = new ClusterManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $clusterManagerClient->setMonitoringService($monitoringService);
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
    $monitoringService = '[MONITORING_SERVICE]';

    set_monitoring_service_sample($monitoringService);
}
// [END container_v1_generated_ClusterManager_SetMonitoringService_sync]
