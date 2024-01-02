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

// [START dataproc_v1_generated_ClusterController_UpdateCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\Cluster;
use Google\Cloud\Dataproc\V1\ClusterControllerClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a cluster in a project. The returned
 * [Operation.metadata][google.longrunning.Operation.metadata] will be
 * [ClusterOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#clusteroperationmetadata).
 * The cluster must be in a
 * [`RUNNING`][google.cloud.dataproc.v1.ClusterStatus.State] state or an error
 * is returned.
 *
 * @param string $projectId          The ID of the Google Cloud Platform project the
 *                                   cluster belongs to.
 * @param string $region             The Dataproc region in which to handle the request.
 * @param string $clusterName        The cluster name.
 * @param string $clusterProjectId   The Google Cloud Platform project ID that the cluster belongs to.
 * @param string $clusterClusterName The cluster name, which must be unique within a project.
 *                                   The name must start with a lowercase letter, and can contain
 *                                   up to 51 lowercase letters, numbers, and hyphens. It cannot end
 *                                   with a hyphen. The name of a deleted cluster can be reused.
 */
function update_cluster_sample(
    string $projectId,
    string $region,
    string $clusterName,
    string $clusterProjectId,
    string $clusterClusterName
): void {
    // Create a client.
    $clusterControllerClient = new ClusterControllerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $cluster = (new Cluster())
        ->setProjectId($clusterProjectId)
        ->setClusterName($clusterClusterName);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $clusterControllerClient->updateCluster(
            $projectId,
            $region,
            $clusterName,
            $cluster,
            $updateMask
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Cluster $result */
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
    $projectId = '[PROJECT_ID]';
    $region = '[REGION]';
    $clusterName = '[CLUSTER_NAME]';
    $clusterProjectId = '[PROJECT_ID]';
    $clusterClusterName = '[CLUSTER_NAME]';

    update_cluster_sample($projectId, $region, $clusterName, $clusterProjectId, $clusterClusterName);
}
// [END dataproc_v1_generated_ClusterController_UpdateCluster_sync]
