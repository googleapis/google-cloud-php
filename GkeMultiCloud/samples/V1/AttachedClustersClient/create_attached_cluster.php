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

// [START gkemulticloud_v1_generated_AttachedClusters_CreateAttachedCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AttachedCluster;
use Google\Cloud\GkeMultiCloud\V1\AttachedOidcConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\CreateAttachedClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\Fleet;
use Google\Rpc\Status;

/**
 * Creates a new
 * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 * on a given Google Cloud Platform project and region.
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent                The parent location where this
 *                                               [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 *                                               will be created.
 *
 *                                               Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                               See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                               for more details on Google Cloud resource names. Please see
 *                                               {@see AttachedClustersClient::locationName()} for help formatting this field.
 * @param string $attachedClusterPlatformVersion The platform version for the cluster (e.g. `1.19.0-gke.1000`).
 *
 *                                               You can list all supported versions on a given Google Cloud region by
 *                                               calling
 *                                               [GetAttachedServerConfig][google.cloud.gkemulticloud.v1.AttachedClusters.GetAttachedServerConfig].
 * @param string $attachedClusterDistribution    The Kubernetes distribution of the underlying attached cluster.
 *
 *                                               Supported values: ["eks", "aks", "generic"].
 * @param string $attachedClusterFleetProject    The name of the Fleet host project where this cluster will be
 *                                               registered.
 *
 *                                               Project names are formatted as
 *                                               `projects/<project-number>`.
 * @param string $attachedClusterId              A client provided ID the resource. Must be unique within the
 *                                               parent resource.
 *
 *                                               The provided ID will be part of the
 *                                               [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 *                                               name formatted as
 *                                               `projects/<project-id>/locations/<region>/attachedClusters/<cluster-id>`.
 *
 *                                               Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 63 characters.
 */
function create_attached_cluster_sample(
    string $formattedParent,
    string $attachedClusterPlatformVersion,
    string $attachedClusterDistribution,
    string $attachedClusterFleetProject,
    string $attachedClusterId
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
    $request = (new CreateAttachedClusterRequest())
        ->setParent($formattedParent)
        ->setAttachedCluster($attachedCluster)
        ->setAttachedClusterId($attachedClusterId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $attachedClustersClient->createAttachedCluster($request);
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
    $formattedParent = AttachedClustersClient::locationName('[PROJECT]', '[LOCATION]');
    $attachedClusterPlatformVersion = '[PLATFORM_VERSION]';
    $attachedClusterDistribution = '[DISTRIBUTION]';
    $attachedClusterFleetProject = '[PROJECT]';
    $attachedClusterId = '[ATTACHED_CLUSTER_ID]';

    create_attached_cluster_sample(
        $formattedParent,
        $attachedClusterPlatformVersion,
        $attachedClusterDistribution,
        $attachedClusterFleetProject,
        $attachedClusterId
    );
}
// [END gkemulticloud_v1_generated_AttachedClusters_CreateAttachedCluster_sync]
