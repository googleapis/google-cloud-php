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

// [START gameservices_v1_generated_GameServerDeploymentsService_UpdateGameServerDeploymentRollout_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Gaming\V1\GameServerDeployment;
use Google\Cloud\Gaming\V1\GameServerDeploymentRollout;
use Google\Cloud\Gaming\V1\GameServerDeploymentsServiceClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Patches a single game server deployment rollout.
 * The method will not return an error if the update does not affect any
 * existing realms. For example - if the default_game_server_config is changed
 * but all existing realms use the override, that is valid. Similarly, if a
 * non existing realm is explicitly called out in game_server_config_overrides
 * field, that will also not result in an error.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_game_server_deployment_rollout_sample(): void
{
    // Create a client.
    $gameServerDeploymentsServiceClient = new GameServerDeploymentsServiceClient();

    // Prepare the request message.
    $rollout = new GameServerDeploymentRollout();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gameServerDeploymentsServiceClient->updateGameServerDeploymentRollout(
            $rollout,
            $updateMask
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GameServerDeployment $result */
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
// [END gameservices_v1_generated_GameServerDeploymentsService_UpdateGameServerDeploymentRollout_sync]
