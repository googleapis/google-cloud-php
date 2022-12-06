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

// [START gameservices_v1_generated_GameServerClustersService_UpdateGameServerCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Gaming\V1\GameServerCluster;
use Google\Cloud\Gaming\V1\GameServerClustersServiceClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Patches a single game server cluster.
 *
 * @param string $gameServerClusterName The resource name of the game server cluster, in the following form:
 *                                      `projects/{project}/locations/{location}/realms/{realm}/gameServerClusters/{cluster}`.
 *                                      For example,
 *                                      `projects/my-project/locations/{location}/realms/zanzibar/gameServerClusters/my-onprem-cluster`.
 */
function update_game_server_cluster_sample(string $gameServerClusterName): void
{
    // Create a client.
    $gameServerClustersServiceClient = new GameServerClustersServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $gameServerCluster = (new GameServerCluster())
        ->setName($gameServerClusterName);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gameServerClustersServiceClient->updateGameServerCluster(
            $gameServerCluster,
            $updateMask
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GameServerCluster $result */
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
    $gameServerClusterName = '[NAME]';

    update_game_server_cluster_sample($gameServerClusterName);
}
// [END gameservices_v1_generated_GameServerClustersService_UpdateGameServerCluster_sync]
