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

// [START bigtableadmin_v2_generated_BigtableInstanceAdmin_CreateCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\CreateClusterRequest;
use Google\Rpc\Status;

/**
 * Creates a cluster within an instance.
 *
 * Note that exactly one of Cluster.serve_nodes and
 * Cluster.cluster_config.cluster_autoscaling_config can be set. If
 * serve_nodes is set to non-zero, then the cluster is manually scaled. If
 * cluster_config.cluster_autoscaling_config is non-empty, then autoscaling is
 * enabled.
 *
 * @param string $formattedParent The unique name of the instance in which to create the new
 *                                cluster. Values are of the form `projects/{project}/instances/{instance}`. Please see
 *                                {@see BigtableInstanceAdminClient::instanceName()} for help formatting this field.
 * @param string $clusterId       The ID to be used when referring to the new cluster within its
 *                                instance, e.g., just `mycluster` rather than
 *                                `projects/myproject/instances/myinstance/clusters/mycluster`.
 */
function create_cluster_sample(string $formattedParent, string $clusterId): void
{
    // Create a client.
    $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();

    // Prepare the request message.
    $cluster = new Cluster();
    $request = (new CreateClusterRequest())
        ->setParent($formattedParent)
        ->setClusterId($clusterId)
        ->setCluster($cluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableInstanceAdminClient->createCluster($request);
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
    $formattedParent = BigtableInstanceAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $clusterId = '[CLUSTER_ID]';

    create_cluster_sample($formattedParent, $clusterId);
}
// [END bigtableadmin_v2_generated_BigtableInstanceAdmin_CreateCluster_sync]
