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

// [START gkemulticloud_v1_generated_AttachedClusters_ImportAttachedCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AttachedCluster;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\ImportAttachedClusterRequest;
use Google\Rpc\Status;

/**
 * Imports creates a new
 * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 * by importing an existing Fleet Membership resource.
 *
 * Attached Clusters created before the introduction of the Anthos Multi-Cloud
 * API can be imported through this method.
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent The parent location where this
 *                                [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 *                                will be created.
 *
 *                                Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                for more details on Google Cloud resource names. Please see
 *                                {@see AttachedClustersClient::locationName()} for help formatting this field.
 * @param string $fleetMembership The name of the fleet membership resource to import.
 * @param string $platformVersion The platform version for the cluster (e.g. `1.19.0-gke.1000`).
 *
 *                                You can list all supported versions on a given Google Cloud region by
 *                                calling
 *                                [GetAttachedServerConfig][google.cloud.gkemulticloud.v1.AttachedClusters.GetAttachedServerConfig].
 * @param string $distribution    The Kubernetes distribution of the underlying attached cluster.
 *
 *                                Supported values: ["eks", "aks"].
 */
function import_attached_cluster_sample(
    string $formattedParent,
    string $fleetMembership,
    string $platformVersion,
    string $distribution
): void {
    // Create a client.
    $attachedClustersClient = new AttachedClustersClient();

    // Prepare the request message.
    $request = (new ImportAttachedClusterRequest())
        ->setParent($formattedParent)
        ->setFleetMembership($fleetMembership)
        ->setPlatformVersion($platformVersion)
        ->setDistribution($distribution);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $attachedClustersClient->importAttachedCluster($request);
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
    $fleetMembership = '[FLEET_MEMBERSHIP]';
    $platformVersion = '[PLATFORM_VERSION]';
    $distribution = '[DISTRIBUTION]';

    import_attached_cluster_sample($formattedParent, $fleetMembership, $platformVersion, $distribution);
}
// [END gkemulticloud_v1_generated_AttachedClusters_ImportAttachedCluster_sync]
