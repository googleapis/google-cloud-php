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

// [START redis_v1_generated_CloudRedisCluster_CreateCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\Cluster\V1\Client\CloudRedisClusterClient;
use Google\Cloud\Redis\Cluster\V1\Cluster;
use Google\Cloud\Redis\Cluster\V1\CreateClusterRequest;
use Google\Rpc\Status;

/**
 * Creates a Redis cluster based on the specified properties.
 * The creation is executed asynchronously and callers may check the returned
 * operation to track its progress. Once the operation is completed the Redis
 * cluster will be fully functional. The completed longrunning.Operation will
 * contain the new cluster object in the response field.
 *
 * The returned operation is automatically deleted after a few hours, so there
 * is no need to call DeleteOperation.
 *
 * @param string $formattedParent The resource name of the cluster location using the form:
 *                                `projects/{project_id}/locations/{location_id}`
 *                                where `location_id` refers to a GCP region. Please see
 *                                {@see CloudRedisClusterClient::locationName()} for help formatting this field.
 * @param string $clusterId       The logical name of the Redis cluster in the customer project
 *                                with the following restrictions:
 *
 *                                * Must contain only lowercase letters, numbers, and hyphens.
 *                                * Must start with a letter.
 *                                * Must be between 1-63 characters.
 *                                * Must end with a number or a letter.
 *                                * Must be unique within the customer project / location
 * @param string $clusterName     Identifier. Unique name of the resource in this scope including
 *                                project and location using the form:
 *                                `projects/{project_id}/locations/{location_id}/clusters/{cluster_id}`
 */
function create_cluster_sample(
    string $formattedParent,
    string $clusterId,
    string $clusterName
): void {
    // Create a client.
    $cloudRedisClusterClient = new CloudRedisClusterClient();

    // Prepare the request message.
    $cluster = (new Cluster())
        ->setName($clusterName);
    $request = (new CreateClusterRequest())
        ->setParent($formattedParent)
        ->setClusterId($clusterId)
        ->setCluster($cluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClusterClient->createCluster($request);
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
    $formattedParent = CloudRedisClusterClient::locationName('[PROJECT]', '[LOCATION]');
    $clusterId = '[CLUSTER_ID]';
    $clusterName = '[NAME]';

    create_cluster_sample($formattedParent, $clusterId, $clusterName);
}
// [END redis_v1_generated_CloudRedisCluster_CreateCluster_sync]
