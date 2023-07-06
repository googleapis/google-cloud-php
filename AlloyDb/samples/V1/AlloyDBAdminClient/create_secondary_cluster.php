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

// [START alloydb_v1_generated_AlloyDBAdmin_CreateSecondaryCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AlloyDb\V1\Client\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\Cluster;
use Google\Cloud\AlloyDb\V1\CreateSecondaryClusterRequest;
use Google\Rpc\Status;

/**
 * Creates a cluster of type SECONDARY in the given location using
 * the primary cluster as the source.
 *
 * @param string $formattedParent         The location of the new cluster. For the required
 *                                        format, see the comment on the Cluster.name field. Please see
 *                                        {@see AlloyDBAdminClient::locationName()} for help formatting this field.
 * @param string $clusterId               ID of the requesting object (the secondary cluster).
 * @param string $formattedClusterNetwork The resource link for the VPC network in which cluster resources
 *                                        are created and from which they are accessible via Private IP. The network
 *                                        must belong to the same project as the cluster. It is specified in the
 *                                        form: "projects/{project_number}/global/networks/{network_id}". This is
 *                                        required to create a cluster. It can be updated, but it cannot be removed. Please see
 *                                        {@see AlloyDBAdminClient::networkName()} for help formatting this field.
 */
function create_secondary_cluster_sample(
    string $formattedParent,
    string $clusterId,
    string $formattedClusterNetwork
): void {
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare the request message.
    $cluster = (new Cluster())
        ->setNetwork($formattedClusterNetwork);
    $request = (new CreateSecondaryClusterRequest())
        ->setParent($formattedParent)
        ->setClusterId($clusterId)
        ->setCluster($cluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alloyDBAdminClient->createSecondaryCluster($request);
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
    $formattedParent = AlloyDBAdminClient::locationName('[PROJECT]', '[LOCATION]');
    $clusterId = '[CLUSTER_ID]';
    $formattedClusterNetwork = AlloyDBAdminClient::networkName('[PROJECT]', '[NETWORK]');

    create_secondary_cluster_sample($formattedParent, $clusterId, $formattedClusterNetwork);
}
// [END alloydb_v1_generated_AlloyDBAdmin_CreateSecondaryCluster_sync]
