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

// [START gkemulticloud_v1_generated_AttachedClusters_UpdateAttachedCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AttachedCluster;
use Google\Cloud\GkeMultiCloud\V1\AttachedOidcConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\Fleet;
use Google\Cloud\GkeMultiCloud\V1\UpdateAttachedClusterRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an
 * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster].
 *
 * @param string $attachedClusterPlatformVersion The platform version for the cluster (e.g. `1.19.0-gke.1000`).
 *
 *                                               You can list all supported versions on a given Google Cloud region by
 *                                               calling
 *                                               [GetAttachedServerConfig][google.cloud.gkemulticloud.v1.AttachedClusters.GetAttachedServerConfig].
 * @param string $attachedClusterDistribution    The Kubernetes distribution of the underlying attached cluster.
 *
 *                                               Supported values: ["eks", "aks"].
 * @param string $attachedClusterFleetProject    The name of the Fleet host project where this cluster will be
 *                                               registered.
 *
 *                                               Project names are formatted as
 *                                               `projects/<project-number>`.
 */
function update_attached_cluster_sample(
    string $attachedClusterPlatformVersion,
    string $attachedClusterDistribution,
    string $attachedClusterFleetProject
): void {
    // Create a client.
    $attachedClustersClient = new AttachedClustersClient();

    // Prepare the request message.
    $attachedClusterOidcConfig = new AttachedOidcConfig();
    $attachedClusterFleet = (new Fleet())
        ->setProject($attachedClusterFleetProject);
    $attachedCluster = (new AttachedCluster())
        ->setOidcConfig($attachedClusterOidcConfig)
        ->setPlatformVersion($attachedClusterPlatformVersion)
        ->setDistribution($attachedClusterDistribution)
        ->setFleet($attachedClusterFleet);
    $updateMask = new FieldMask();
    $request = (new UpdateAttachedClusterRequest())
        ->setAttachedCluster($attachedCluster)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $attachedClustersClient->updateAttachedCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AttachedCluster $result */
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
    $attachedClusterPlatformVersion = '[PLATFORM_VERSION]';
    $attachedClusterDistribution = '[DISTRIBUTION]';
    $attachedClusterFleetProject = '[PROJECT]';

    update_attached_cluster_sample(
        $attachedClusterPlatformVersion,
        $attachedClusterDistribution,
        $attachedClusterFleetProject
    );
}
// [END gkemulticloud_v1_generated_AttachedClusters_UpdateAttachedCluster_sync]
