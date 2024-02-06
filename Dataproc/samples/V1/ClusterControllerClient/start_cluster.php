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

// [START dataproc_v1_generated_ClusterController_StartCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\Client\ClusterControllerClient;
use Google\Cloud\Dataproc\V1\Cluster;
use Google\Cloud\Dataproc\V1\StartClusterRequest;
use Google\Rpc\Status;

/**
 * Starts a cluster in a project.
 *
 * @param string $projectId   The ID of the Google Cloud Platform project the
 *                            cluster belongs to.
 * @param string $region      The Dataproc region in which to handle the request.
 * @param string $clusterName The cluster name.
 */
function start_cluster_sample(string $projectId, string $region, string $clusterName): void
{
    // Create a client.
    $clusterControllerClient = new ClusterControllerClient();

    // Prepare the request message.
    $request = (new StartClusterRequest())
        ->setProjectId($projectId)
        ->setRegion($region)
        ->setClusterName($clusterName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $clusterControllerClient->startCluster($request);
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

    start_cluster_sample($projectId, $region, $clusterName);
}
// [END dataproc_v1_generated_ClusterController_StartCluster_sync]
